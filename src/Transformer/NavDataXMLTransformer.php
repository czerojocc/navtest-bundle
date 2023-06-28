<?php

namespace Flexibill\NavBundle\Transformer;

class NavDataXMLTransformer extends NavXMLTransformer
{
    /**
     * @var string
     */
    protected $transformerFile = 'navXmlData.xslt';

    /**
     * @var string
     */
    protected $validatorFile = 'invoiceData.xsd';

}