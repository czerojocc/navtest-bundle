<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Model;

use DateTime;
use JMS\Serializer\Annotation as Serializer;

class InvoiceDigest
{
    /**
     * @var string
     *
     * @Serializer\SerializedName("invoiceNumber")
     * @Serializer\Type("string")
     */
    protected $invoiceNumber;

    /**
     * @var string
     *
     * @Serializer\SerializedName("invoiceOperation")
     * @Serializer\Type("string")
     */
    protected $invoiceOperation;

    /**
     * @var string
     *
     * @Serializer\SerializedName("invoiceCategory")
     * @Serializer\Type("string")
     */
    protected $invoiceCategory;

    /**
     * @var DateTime
     *
     * @Serializer\SerializedName("invoiceIssueDate")
     * @Serializer\Type("DateTime<'Y-m-d'>")
     */
    protected $invoiceIssueDate;

    /**
     * @var string
     *
     * @Serializer\SerializedName("supplierTaxNumber")
     * @Serializer\Type("string")
     */
    protected $supplierTaxNumber;


    /**
     * @var string
     *
     * @Serializer\SerializedName("supplierGroupMemberTaxNumber")
     * @Serializer\Type("string")
     */
    protected $supplierGroupMemberTaxNumber;

    /**
     * @var string
     *
     * @Serializer\SerializedName("supplierName")
     * @Serializer\Type("string")
     */
    protected $supplierName;

    /**
     * @var string
     *
     * @Serializer\SerializedName("customerTaxNumber")
     * @Serializer\Type("string")
     */
    protected $customerTaxNumber;

    /**
     * @var string
     *
     * @Serializer\SerializedName("customerGroupMemberTaxNumber")
     * @Serializer\Type("string")
     */
    protected $customerGroupMemberTaxNumber;

    /**
     * @var string
     *
     * @Serializer\SerializedName("customerName")
     * @Serializer\Type("string")
     */
    protected $customerName;

    /**
     * @var string
     *
     * @Serializer\SerializedName("paymentMethod")
     * @Serializer\Type("string")
     */
    protected $paymentMethod;

    /**
     * @var DateTime
     *
     * @Serializer\SerializedName("paymentDate")
     * @Serializer\Type("DateTime<'Y-m-d'>")
     */
    protected $paymentDate;

    /**
     * @var string
     *
     * @Serializer\SerializedName("invoiceAppearance")
     * @Serializer\Type("string")
     */
    protected $invoiceAppearance;

    /**
     * @var string
     *
     * @Serializer\SerializedName("source")
     * @Serializer\Type("string")
     */
    protected $source;

    /**
     * @var DateTime
     *
     * @Serializer\SerializedName("invoiceDeliveryDate")
     * @Serializer\Type("DateTime<'Y-m-d'>")
     */
    protected $invoiceDeliveryDate;

    /**
     * @var string
     *
     * @Serializer\SerializedName("currency")
     * @Serializer\Type("string")
     */
    protected $currency;

    /**
     * @var string|null
     *
     * @Serializer\SerializedName("invoiceNetAmount")
     * @Serializer\Type("string")
     */
    protected $invoiceNetAmount;

    /**
     * @var string|null
     *
     * @Serializer\SerializedName("invoiceNetAmountHUF")
     * @Serializer\Type("string")
     */
    protected $invoiceNetAmountHUF;

    /**
     * @var string|null
     *
     * @Serializer\SerializedName("invoiceVatAmount")
     * @Serializer\Type("string")
     */
    protected $invoiceVatAmount;

    /**
     * @var string|null
     *
     * @Serializer\SerializedName("invoiceVatAmountHUF")
     * @Serializer\Type("string")
     */
    protected $invoiceVatAmountHUF;

    /**
     * @var string
     *
     * @Serializer\SerializedName("transactionId")
     * @Serializer\Type("string")
     */
    protected $transactionId;

    /**
     * @var int
     *
     * @Serializer\SerializedName("index")
     * @Serializer\Type("int")
     */
    protected $index;

    /**
     * @var string
     *
     * @Serializer\SerializedName("insDate")
     * @Serializer\Type("string")
     */
    protected $insDate;

    /**
     * @var bool
     *
     * @Serializer\SerializedName("completenessIndicator")
     * @Serializer\Type("bool")
     */
    protected $completenessIndicator;

    /**
     * @return string
     */
    public function getInvoiceNumber(): string
    {
        return $this->invoiceNumber;
    }

    /**
     * @param string $invoiceNumber
     *
     * @return InvoiceDigest
     */
    public function setInvoiceNumber(string $invoiceNumber): InvoiceDigest
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceOperation(): string
    {
        return $this->invoiceOperation;
    }

    /**
     * @param string $invoiceOperation
     *
     * @return InvoiceDigest
     */
    public function setInvoiceOperation(string $invoiceOperation): InvoiceDigest
    {
        $this->invoiceOperation = $invoiceOperation;

        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceCategory(): string
    {
        return $this->invoiceCategory;
    }

    /**
     * @param string $invoiceCategory
     *
     * @return InvoiceDigest
     */
    public function setInvoiceCategory(string $invoiceCategory): InvoiceDigest
    {
        $this->invoiceCategory = $invoiceCategory;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getInvoiceIssueDate(): DateTime
    {
        return $this->invoiceIssueDate;
    }

    /**
     * @param DateTime $invoiceIssueDate
     *
     * @return InvoiceDigest
     */
    public function setInvoiceIssueDate(DateTime $invoiceIssueDate): InvoiceDigest
    {
        $this->invoiceIssueDate = $invoiceIssueDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getSupplierTaxNumber(): string
    {
        return $this->supplierTaxNumber;
    }

    /**
     * @param string $supplierTaxNumber
     *
     * @return InvoiceDigest
     */
    public function setSupplierTaxNumber(string $supplierTaxNumber): InvoiceDigest
    {
        $this->supplierTaxNumber = $supplierTaxNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getSupplierGroupMemberTaxNumber(): string
    {
        return $this->supplierGroupMemberTaxNumber;
    }

    /**
     * @param string $supplierGroupMemberTaxNumber
     *
     * @return InvoiceDigest
     */
    public function setSupplierGroupMemberTaxNumber(string $supplierGroupMemberTaxNumber): InvoiceDigest
    {
        $this->supplierGroupMemberTaxNumber = $supplierGroupMemberTaxNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getSupplierName(): string
    {
        return $this->supplierName;
    }

    /**
     * @param string $supplierName
     *
     * @return InvoiceDigest
     */
    public function setSupplierName(string $supplierName): InvoiceDigest
    {
        $this->supplierName = $supplierName;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerTaxNumber(): ?string
    {
        return $this->customerTaxNumber;
    }

    /**
     * @param string $customerTaxNumber
     *
     * @return InvoiceDigest
     */
    public function setCustomerTaxNumber(string $customerTaxNumber): InvoiceDigest
    {
        $this->customerTaxNumber = $customerTaxNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerGroupMemberTaxNumber(): string
    {
        return $this->customerGroupMemberTaxNumber;
    }

    /**
     * @param string $customerGroupMemberTaxNumber
     *
     * @return InvoiceDigest
     */
    public function setCustomerGroupMemberTaxNumber(string $customerGroupMemberTaxNumber): InvoiceDigest
    {
        $this->customerGroupMemberTaxNumber = $customerGroupMemberTaxNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerName(): string
    {
        return $this->customerName;
    }

    /**
     * @param string $customerName
     *
     * @return InvoiceDigest
     */
    public function setCustomerName(string $customerName): InvoiceDigest
    {
        $this->customerName = $customerName;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    /**
     * @param string $paymentMethod
     *
     * @return InvoiceDigest
     */
    public function setPaymentMethod(string $paymentMethod): InvoiceDigest
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getPaymentDate(): ?DateTime
    {
        return $this->paymentDate;
    }

    /**
     * @param DateTime $paymentDate
     *
     * @return InvoiceDigest
     */
    public function setPaymentDate(DateTime $paymentDate): InvoiceDigest
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceAppearance(): string
    {
        return $this->invoiceAppearance;
    }

    /**
     * @param string $invoiceAppearance
     *
     * @return InvoiceDigest
     */
    public function setInvoiceAppearance(string $invoiceAppearance): InvoiceDigest
    {
        $this->invoiceAppearance = $invoiceAppearance;

        return $this;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param string $source
     *
     * @return InvoiceDigest
     */
    public function setSource(string $source): InvoiceDigest
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getInvoiceDeliveryDate(): DateTime
    {
        return $this->invoiceDeliveryDate;
    }

    /**
     * @param DateTime $invoiceDeliveryDate
     *
     * @return InvoiceDigest
     */
    public function setInvoiceDeliveryDate(DateTime $invoiceDeliveryDate): InvoiceDigest
    {
        $this->invoiceDeliveryDate = $invoiceDeliveryDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return InvoiceDigest
     */
    public function setCurrency(string $currency): InvoiceDigest
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInvoiceNetAmount(): ?string
    {
        return $this->invoiceNetAmount;
    }

    /**
     * @param string|null $invoiceNetAmount
     *
     * @return InvoiceDigest
     */
    public function setInvoiceNetAmount(?string $invoiceNetAmount): InvoiceDigest
    {
        $this->invoiceNetAmount = $invoiceNetAmount;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInvoiceNetAmountHUF(): ?string
    {
        return $this->invoiceNetAmountHUF;
    }

    /**
     * @param string|null $invoiceNetAmountHUF
     *
     * @return InvoiceDigest
     */
    public function setInvoiceNetAmountHUF(?string $invoiceNetAmountHUF): InvoiceDigest
    {
        $this->invoiceNetAmountHUF = $invoiceNetAmountHUF;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInvoiceVatAmount(): ?string
    {
        return $this->invoiceVatAmount;
    }

    /**
     * @param string|null $invoiceVatAmount
     *
     * @return InvoiceDigest
     */
    public function setInvoiceVatAmount(?string $invoiceVatAmount): InvoiceDigest
    {
        $this->invoiceVatAmount = $invoiceVatAmount;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInvoiceVatAmountHUF(): ?string
    {
        return $this->invoiceVatAmountHUF;
    }

    /**
     * @param string|null $invoiceVatAmountHUF
     *
     * @return InvoiceDigest
     */
    public function setInvoiceVatAmountHUF(?string $invoiceVatAmountHUF): InvoiceDigest
    {
        $this->invoiceVatAmountHUF = $invoiceVatAmountHUF;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * @param string $transactionId
     *
     * @return InvoiceDigest
     */
    public function setTransactionId(string $transactionId): InvoiceDigest
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    /**
     * @return int
     */
    public function getIndex(): int
    {
        return $this->index;
    }

    /**
     * @param int $index
     *
     * @return InvoiceDigest
     */
    public function setIndex(int $index): InvoiceDigest
    {
        $this->index = $index;

        return $this;
    }

    /**
     * @return string
     */
    public function getInsDate(): string
    {
        return $this->insDate;
    }

    /**
     * @param string $insDate
     *
     * @return InvoiceDigest
     */
    public function setInsDate(string $insDate): InvoiceDigest
    {
        $this->insDate = $insDate;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCompletenessIndicator(): bool
    {
        return $this->completenessIndicator;
    }

    /**
     * @param bool $completenessIndicator
     *
     * @return InvoiceDigest
     */
    public function setCompletenessIndicator(bool $completenessIndicator): InvoiceDigest
    {
        $this->completenessIndicator = $completenessIndicator;

        return $this;
    }
}
