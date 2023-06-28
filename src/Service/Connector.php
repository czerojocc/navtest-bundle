<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Service;

use App\AppBundle\Model\RestResponse;
use App\AppBundle\Service\AbstractConnector;
use Flexibill\NavBundle\Exception\NotEnabledModuleException;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;

/**
 * Class Connector
 * @package Flexibill\NavBundle\Service
 */
class Connector extends AbstractConnector implements ConnectorInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var bool
     */
    private $enable;

    /**
     * Connector constructor.
     * @param LoggerInterface $logger
     * @param string $navUrl
     * @param bool $enable
     */
    public function __construct(LoggerInterface $logger, string $navUrl, bool $enable)
    {
        parent::__construct($logger);

        $this->client = $this->createClient([
            'verify' => false,
            'base_uri' => $navUrl,
            'timeout' => 30,
            'expect' => true,
            'headers' => [
                'Content-Type' => 'application/xml',
                'Accept' => 'application/xml'
            ]
        ]);

        $this->enable = $enable;
    }

    /**
     * @param string $path
     * @param string $serializedParams
     * @return RestResponse
     * @throws NotEnabledModuleException
     * @throws GuzzleException
     */
    public function connect(string $path, string $serializedParams): RestResponse
    {
        if (!$this->enable) {
            throw new NotEnabledModuleException();
        }

        try {
            $response = $this->client->request('POST', $path, ['body' => $serializedParams]);
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
        }

        return new RestResponse($response->getStatusCode(), $response->getBody());
    }

}
