<?php

namespace Flexibill\NavBundle\Service;

use App\AppBundle\Transformer\NavUserFromCompanyNavUserTransformer;
use App\InvoiceBundle\Entity\Invoice;
use App\InvoiceBundle\Repository\NavFetchJobRepository;
use Flexibill\NavBundle\Entity\NavUserData;
use Flexibill\NavBundle\Model\AdditionalQueryParams;
use Flexibill\NavBundle\Model\InsDate;
use Flexibill\NavBundle\Model\InvoiceDigest;
use Flexibill\NavBundle\Model\InvoiceQueryDigestParams;
use Flexibill\NavBundle\Model\MandatoryQueryParams;
use Flexibill\NavBundle\Model\QueryInvoiceDataRequest;
use Flexibill\NavBundle\Model\QueryInvoiceDataResponse;
use Flexibill\NavBundle\Model\QueryInvoiceDigestResponse;
use Flexibill\NavBundle\Model\User;
use Flexibill\NavBundle\Utils\TimestampGenerator;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use Psr\Log\LoggerInterface;

class NavInvoiceRequestFactory
{
    // Max requestable interval 34 days
    const REQUEST_INTERVAL = '-3 days';

    // The number of new invoices processing with one queue message
    const PROCESS_INVOICES_NUM = 20;

    /**
     * @var NavUserData
     */
    protected NavUserData $companyNavUser;

    /**
     * @var string
     */
    protected string $taxNumber;

    /**
     * @var DateTime|null
     */
    protected ?DateTime $intervalStart;

    /**
     * @var DateTime|null
     */
    protected ?DateTime $intervalEnd;

    /**
     * @var User
     */
    protected User $navUser;

    /**
     * @var ConnectionHandler
     */
    protected ConnectionHandler $connectionHandler;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    private EntityManager $entityManager;

    private NavFetchJobRepository $navFetchQueueRepository;

    /**
     * NavInvoiceRequestFactory constructor.
     *
     * @param ConnectionHandler $connectionHandler
     * @param LoggerInterface $logger
     * @param EntityManager $entityManager
     */
    public function __construct(
        ConnectionHandler      $connectionHandler,
        LoggerInterface        $logger,
        EntityManagerInterface $entityManager,
        NavFetchJobRepository  $navFetchQueueRepository
    )
    {
        $this->connectionHandler = $connectionHandler;
        $this->logger = $logger;
        $this->entityManager = $entityManager;
        $this->navFetchQueueRepository = $navFetchQueueRepository;
    }

    /**
     * Loads digests for invoices which aren't exist in our database
     * Returns true if it should be rescheduled (there is data which hasn't been fetched yet)
     *
     * @param array $invoiceDigests
     * @param NavUserData $companyNavUser
     * @param string $taxNumber
     * @param string $direction
     * @param MandatoryQueryParams|null $mandatoryQueryParams
     * @param AdditionalQueryParams|null $additionalQueryParams
     * @param int $page
     * @return bool
     *
     * @throws NonUniqueResultException
     */
    public function getInvoiceDigests(
        array                   &$invoiceDigests,
        NavUserData $companyNavUser,
        string                  $taxNumber,
        string                  $direction,
        MandatoryQueryParams    $mandatoryQueryParams = null,
        AdditionalQueryParams   $additionalQueryParams = null,
        int                     $page = 1
    ): bool
    {
        $this->initialize($companyNavUser, $taxNumber);

        if (!$mandatoryQueryParams) {
            $mandatoryQueryParams = MandatoryQueryParamsBuilder::buildByIssueDate($this->intervalStart, $this->intervalEnd);
        }

        $digestResponse = $this->getInvoices(
            $companyNavUser,
            $taxNumber,
            $direction,
            $mandatoryQueryParams,
            $additionalQueryParams,
            $page
        );

        if ($digestResponse->getResult()->getFuncCode() === 'ERROR') {
            $this->logger->critical(
                sprintf(
                    'Nav incoming invoice error: %s - %s - %s',
                    $taxNumber,
                    $digestResponse->getResult()->getErrorCode(),
                    $digestResponse->getResult()->getMessage()
                )
            );
        }

        $invoiceDigestResult = $digestResponse->getInvoiceDigestResult();

        $invoiceDigests = array_merge($invoiceDigests, $invoiceDigestResult ? $invoiceDigestResult->getInvoiceDigests() : []);

        $this->validateInvoiceExistence($invoiceDigests);

        if (count($invoiceDigests) > self::PROCESS_INVOICES_NUM) {
            return $invoiceDigestResult->getCurrentPage() < $invoiceDigestResult->getAvailablePage();
        }

        if (
            $invoiceDigestResult
            && $invoiceDigestResult->getCurrentPage() < $invoiceDigestResult->getAvailablePage()
        ) {
            $this->getInvoiceDigests(
                $invoiceDigests,
                $companyNavUser,
                $taxNumber,
                $direction,
                $mandatoryQueryParams,
                $additionalQueryParams,
                ++$page
            );
        }

        return false;
    }

    /**
     * @param NavUserData $companyNavUser
     * @param string $taxNumber
     * @param string $invoiceNumber
     * @param string $direction
     * @param int $page
     *
     * @return QueryInvoiceDigestResponse
     *
     * @throws Exception
     * @deprecated Use getInvoices instead
     */
    public function getInvoicesByInvoiceNumber(
        NavUserData $companyNavUser,
        string                  $taxNumber,
        string                  $invoiceNumber,
        string                  $direction,
        int                     $page = 1
    ): QueryInvoiceDigestResponse
    {
        $this->initialize($companyNavUser, $taxNumber);

        $mandatoryQueryParams = new MandatoryQueryParams();
        $mandatoryQueryParams->setOriginalInvoiceNumber($invoiceNumber);

        return $this->queryInvoiceDigestRequest($this->navUser, $direction, $page, $mandatoryQueryParams);
    }

    /**
     * @param NavUserData $companyNavUser
     * @param string $taxNumber
     * @param string $direction
     * @param MandatoryQueryParams $mandatoryQueryParams
     * @param AdditionalQueryParams|null $additionalQueryParams
     * @param int $page
     * @return QueryInvoiceDigestResponse
     *
     * @throws Exception
     */
    public function getInvoices(
        NavUserData $companyNavUser,
        string                  $taxNumber,
        string                  $direction,
        MandatoryQueryParams    $mandatoryQueryParams,
        AdditionalQueryParams   $additionalQueryParams = null,
        int                     $page = 1
    ): QueryInvoiceDigestResponse
    {
        $this->initialize($companyNavUser, $taxNumber);

        return $this->queryInvoiceDigestRequest($this->navUser, $direction, $page, $mandatoryQueryParams, $additionalQueryParams);
    }

    /**
     * @param NavUserData $companyNavUser
     * @param string $taxNumber
     * @param string $direction
     * @param int $page
     *
     * @return QueryInvoiceDigestResponse
     *
     * @throws Exception
     */
    public function getInvoicesByInsDate(
        NavUserData $companyNavUser,
        string                  $taxNumber,
        string                  $direction,
        int                     $page = 1
    ): QueryInvoiceDigestResponse
    {
        $this->initialize($companyNavUser, $taxNumber);

        $insDate = new InsDate();
        $insDate->setDateTimeFrom(TimestampGenerator::generateFromDateTime($this->intervalStart));
        $insDate->setDateTimeTo(TimestampGenerator::generate());

        $mandatoryQueryParams = new MandatoryQueryParams();
        $mandatoryQueryParams->setInsDate($insDate);

        return $this->queryInvoiceDigestRequest($this->navUser, $direction, $page, $mandatoryQueryParams);
    }

    /**
     * @param NavUserData $companyNavUser
     * @param string $taxNumber
     * @param string|null $invoiceId
     * @param string|null $supplierTaxNumber
     * @param string $direction
     *
     * @return QueryInvoiceDataResponse
     * @throws Exception
     */
    public function getQueryInvoiceDigestResponse(
        NavUserData $companyNavUser,
        string                  $taxNumber,
        ?string                 $invoiceId,
        ?string                 $supplierTaxNumber,
        string                  $direction = QueryInvoiceDataRequest::DIRECTION_INBOUND
    ): QueryInvoiceDataResponse
    {
        $this->initialize($companyNavUser, $taxNumber);

        /** @var QueryInvoiceDataResponse $response */
        $response = $this->connectionHandler->queryInvoiceDataRequest(
            $this->navUser,
            $invoiceId,
            $direction,
            $supplierTaxNumber
        );

        return $response;
    }

    /**
     * @param $invoiceDigests
     * @return void
     * @throws NonUniqueResultException
     */
    protected function validateInvoiceExistence(&$invoiceDigests)
    {
        /**
         * @var integer $key
         * @var InvoiceDigest $invoiceDigest
         */
        foreach ($invoiceDigests as $key => $invoiceDigest) {
            $invoiceId = $invoiceDigest->getInvoiceNumber();
            $supplierTaxNumber = $invoiceDigest->getSupplierTaxNumber();

            // @todo handle outgoing invoices too
            $invoice = $this->getExistingInvoiceByInvoiceNumberAndSupplier($invoiceId, $supplierTaxNumber);

            if (
                ($invoice && $invoice->getCustomerCompany()) ||
                $this->navFetchQueueRepository->findBy([
                    'invoiceNumber' => $invoiceDigest->getInvoiceNumber(),
                    'supplierTaxNumber' => $invoiceDigest->getSupplierTaxNumber(),
                    'customerTaxNumber' => $invoiceDigest->getCustomerTaxNumber()
                ])
            ) {
                unset($invoiceDigests[$key]);
            }
        }
    }

    /**
     * @param string $invoiceNumber
     * @param string $taxNumber
     *
     * @return Invoice|null
     * @throws NonUniqueResultException
     */
    protected function getExistingInvoiceByInvoiceNumberAndSupplier(string $invoiceNumber, string $taxNumber): ?Invoice
    {
        $qb = $this->entityManager->getRepository(Invoice::class)->createQueryBuilder('invoice');

        return $qb
            ->leftJoin('invoice.accountingSupplierParty', 'accountingSupplierParty')
            ->andWhere('invoice.invoiceId = :invoiceId')
            ->andWhere('accountingSupplierParty.taxNumber like :taxNumber')
            ->setParameters(
                [
                    'invoiceId' => $invoiceNumber,
                    'taxNumber' => $taxNumber . '%'
                ]
            )
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param User $navDataUser
     * @param string $direction
     * @param int $page
     *
     * @param MandatoryQueryParams $mandatoryQueryParams
     * @param AdditionalQueryParams|null $additionalQueryParams
     * @return QueryInvoiceDigestResponse
     *
     * @throws Exception
     *
     * @todo add RelationalQueryParams and TransactionQueryParams
     */
    private function queryInvoiceDigestRequest(
        User                  $navDataUser,
        string                $direction,
        int                   $page,
        MandatoryQueryParams  $mandatoryQueryParams,
        AdditionalQueryParams $additionalQueryParams = null
    ): QueryInvoiceDigestResponse
    {
        $invoiceQueryParams = new InvoiceQueryDigestParams();
        $invoiceQueryParams->setMandatoryQueryParams($mandatoryQueryParams);

        if ($additionalQueryParams) {
            $invoiceQueryParams->setAdditionalQueryParams($additionalQueryParams);
        }

        return $this->connectionHandler->queryInvoiceDigestRequest(
            $navDataUser,
            $invoiceQueryParams,
            $direction,
            $page
        );
    }

    /**
     * @param NavUserData $companyNavUser
     * @param string $taxNumber
     * @param DateTime|null $intervalEnd
     */
    private function initialize(NavUserData $companyNavUser, string $taxNumber, ?DateTime $intervalEnd = null)
    {
        if (!$intervalEnd) {
            $intervalEnd = new DateTime();
        }

        $this->companyNavUser = $companyNavUser;
        $this->taxNumber = $taxNumber;
        $this->intervalEnd = $intervalEnd;

        $this->prepareRequestParameters();
    }

    private function prepareRequestParameters(): void
    {
        $this->navUser = NavUserFromCompanyNavUserTransformer::transform($this->companyNavUser, $this->taxNumber);
        $this->intervalStart = clone $this->intervalEnd;
        $this->intervalStart->modify(self::REQUEST_INTERVAL);
    }
}