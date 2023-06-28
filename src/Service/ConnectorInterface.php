<?php
declare(strict_types=1);

namespace Flexibill\NavBundle\Service;

use App\AppBundle\Model\RestResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface ConnectorInterface
 * @package Flexibill\NavBundle\Service
 */
interface ConnectorInterface
{
    /**
     * @param string $path
     * @param string $serializedParams
     * @return RestResponse
     */
    public function connect(string $path, string $serializedParams): RestResponse;
}
