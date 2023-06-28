<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Transformer;

use App\AppBundle\Exception\InvalidXMLException;
use App\AppBundle\Exception\TransformationException;
use App\AppBundle\Service\XSLTTransformer;

/**
 * Class InvoiceToUBL21Transformer
 * @package Flexibill\NavBundle\Service
 */
class InvoiceToUBL21PeppolTransformer extends XSLTTransformer
{
    protected $transformerFile = 'MappingMapToUBL-Invoice-2_1.xslt';
    protected $validatorFile = 'bavinvoice.xsd';
    protected $configPath = '@NavBundle/Resources/config';

    /**
     * @param $document
     * @return mixed|string
     * @throws InvalidXMLException
     * @throws TransformationException
     */
    public function transform($document)
    {
        $this->validate($document);

        return $this->xsltTransformation($document);
    }
}