<?php

namespace Flexibill\NavBundle\Model;

use JMS\Serializer\Annotation as Serializer;

class AdditionalQueryParams
{
    /**
     * @var string|null
     *
     * @Serializer\SerializedName("taxNumber")
     */
    protected ?string $taxNumber = null;

    /**
     * @var string|null
     *
     * @Serializer\SerializedName("groupMemberTaxNumber")
     */
    protected ?string $groupMemberTaxNumber = null;

    /**
     * @var string|null
     *
     * @Serializer\SerializedName("name")
     */
    protected ?string $name = null;

    /**
     * @var string|null
     *
     * @Serializer\SerializedName("invoiceCategory")
     */
    protected ?string $invoiceCategory = null;

    /**
     * @var string|null
     *
     * @Serializer\SerializedName("paymentMethod")
     */
    protected ?string $paymentMethod = null;

    /**
     * @var string|null
     *
     * @Serializer\SerializedName("invoiceAppearance")
     */
    protected ?string $invoiceAppearance = null;

    /**
     * @var string|null
     *
     * @Serializer\SerializedName("source")
     */
    protected ?string $source = null;

    /**
     * @var string|null
     *
     * @Serializer\SerializedName("currency")
     */
    protected ?string $currency = null;

    /**
     * @return string|null
     */
    public function getTaxNumber(): ?string
    {
        return $this->taxNumber;
    }

    /**
     * @param string|null $taxNumber
     */
    public function setTaxNumber(?string $taxNumber): void
    {
        $this->taxNumber = $taxNumber;
    }

    /**
     * @return string|null
     */
    public function getGroupMemberTaxNumber(): ?string
    {
        return $this->groupMemberTaxNumber;
    }

    /**
     * @param string|null $groupMemberTaxNumber
     */
    public function setGroupMemberTaxNumber(?string $groupMemberTaxNumber): void
    {
        $this->groupMemberTaxNumber = $groupMemberTaxNumber;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getInvoiceCategory(): ?string
    {
        return $this->invoiceCategory;
    }

    /**
     * @param string|null $invoiceCategory
     */
    public function setInvoiceCategory(?string $invoiceCategory): void
    {
        $this->invoiceCategory = $invoiceCategory;
    }

    /**
     * @return string|null
     */
    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    /**
     * @param string|null $paymentMethod
     */
    public function setPaymentMethod(?string $paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @return string|null
     */
    public function getInvoiceAppearance(): ?string
    {
        return $this->invoiceAppearance;
    }

    /**
     * @param string|null $invoiceAppearance
     */
    public function setInvoiceAppearance(?string $invoiceAppearance): void
    {
        $this->invoiceAppearance = $invoiceAppearance;
    }

    /**
     * @return string|null
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @param string|null $source
     */
    public function setSource(?string $source): void
    {
        $this->source = $source;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string|null $currency
     */
    public function setCurrency(?string $currency): void
    {
        $this->currency = $currency;
    }
}