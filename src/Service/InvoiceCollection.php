<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Service;

use App\AppBundle\Exception\InvalidXMLException;
use App\AppBundle\Exception\TransformationException;
use App\InvoiceBundle\Entity\InvoiceInterface;
use App\InvoiceBundle\Service\InvoiceCalculator;
use Flexibill\NavBundle\Transformer\NavTransformerInterface;
use Flexibill\NavBundle\Transformer\NavXMLTransformer;
use Flexibill\NavBundle\Utils\SHA512HashMaker;
use JMS\Serializer\SerializerInterface;

/**
 * Class InvoiceCollectionPreparatory
 * @package Flexibill\NavBundle\Service
 */
class InvoiceCollection
{
    /**
     * @var NavXMLTransformer
     */
    private $transformer;

    private array $invoices = [];

    /**
     * @param NavTransformerInterface $transformer
     * @param InvoiceCalculator $invoiceCalculator
     */
    public function __construct(NavTransformerInterface $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @return array
     * @throws InvalidXMLException
     * @throws TransformationException
     * @throws \App\AppBundle\Exception\TransformationInvalidTypeException
     */
    public function getEncodedInvoices()
    {
        $encodedInvoices = [];

        /** @var InvoiceInterface $invoice */
        foreach ($this->getInvoices() as $invoice) {
            $invoiceNAVDataXML = $this->transformer->transform($invoice);
            $base64EncodedXML = base64_encode($invoiceNAVDataXML);
            $encodedInvoices[] = $base64EncodedXML;
        }

        return $encodedInvoices;
    }

    /**
     * @return array
     */
    public function getInvoices(): array
    {
        return $this->invoices;
    }

    /**
     * @param array $invoices
     */
    public function setInvoices(array $invoices): void
    {
        $this->invoices = $invoices;
    }

    /**
     * @param object $invoice
     */
    public function addInvoice(object $invoice): void
    {
        $this->invoices[] = $invoice;
    }
}
