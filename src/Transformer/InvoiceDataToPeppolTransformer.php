<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Transformer;

use App\InvoiceBundle\Entity\InvoiceInterface;
use App\InvoiceBundle\Serializer\InvoiceSerializer;
use JMS\Serializer\SerializerInterface;

/**
 * Class InvoiceDataToNAVStructureTransformer
 * @package Flexibill\NavBundle\Transformer
 */
class InvoiceDataToPeppolTransformer
{
    /**
     * @var InvoiceToUBL21PeppolTransformer
     */
    private $invoiceToUBL21PeppolTransformer;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * InvoiceDataToPeppolTransformer constructor.
     * @param InvoiceToUBL21PeppolTransformer $invoiceToUBL21Transformer
     * @param SerializerInterface $serializer
     */
    public function __construct(
        InvoiceToUBL21PeppolTransformer $invoiceToUBL21Transformer,
        SerializerInterface $serializer
    )
    {
        $this->invoiceToUBL21PeppolTransformer = $invoiceToUBL21Transformer;
        $this->serializer = $serializer;
    }

    /**
     * @param InvoiceInterface $invoice
     * @return mixed|string
     * @throws \App\AppBundle\Exception\InvalidXMLException
     * @throws \App\AppBundle\Exception\TransformationException
     */
    public function transform(InvoiceInterface $invoice)
    {
        $invoiceDataXML = $this->serializeInvoice($invoice);
        $ublXML = $this->invoiceToUBL21PeppolTransformer->transform($invoiceDataXML);
        return $ublXML;
    }

    /**
     * @param InvoiceInterface $invoice
     * @return string
     */
    private function serializeInvoice(InvoiceInterface $invoice)
    {
        return $this->serializer->serialize(
            $invoice,
            InvoiceSerializer::TYPE_XML,
            InvoiceSerializer::getSpecificSerializationContext()
        );
    }
}