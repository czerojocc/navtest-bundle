<?php

namespace Flexibill\NavBundle\Transformer;

class NavAnnulmentXMLTransformer extends NavXMLTransformer
{
    /**
     * @var string
     */
    protected $transformerFile = 'navXmlAnnulment.xslt';

    /**
     * @var string
     */
    protected $validatorFile = 'invoiceAnnulment.xsd';
}