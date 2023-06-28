<?php

declare(strict_types=1);

namespace Flexibill\NavBundle\Enum;

/**
 * Class InvoiceStatusValidationWarnEnum
 * @package Flexibill\NavBundle\Enum
 */
class InvoiceStatusValidationWarnEnum
{
    const SUPPLIER_CUSTOMER_MATCH_TAXPAYER = 'SUPPLIER_CUSTOMER_MATCH_TAXPAYER';
    const SUPPLIER_CUSTOMER_MATCH_BANKACCOUNT = 'SUPPLIER_CUSTOMER_MATCH_BANKACCOUNT';
    const SUPPLIER_FISCAL_MATCH_TAXPAYER = 'SUPPLIER_FISCAL_MATCH_TAXPAYER';
    const SUPPLIER_FISCAL_MATCH_NAME = 'SUPPLIER_FISCAL_MATCH_NAME';
    const INCORRECT_VAT_CODE_SUPPLIER = 'INCORRECT_VAT_CODE_SUPPLIER';
    const INCORRECT_VAT_CODE_SUPPLIER_GROUPMEMBER_MISSING = 'INCORRECT_VAT_CODE_SUPPLIER_GROUPMEMBER_MISSING';
    const INCORRECT_VAT_CODE_FISCALREPRESENTATIVE = 'INCORRECT_VAT_CODE_FISCALREPRESENTATIVE';
    const INCORRECT_VAT_CODE_TAXNUMBEROFOBLIGATOR = 'INCORRECT_VAT_CODE_TAXNUMBEROFOBLIGATOR';
    const INCORRECT_COUNTY_CODE_SUPPLIER = 'INCORRECT_COUNTY_CODE_SUPPLIER';
    const INCORRECT_COUNTY_CODE_SUPPLIER_GROUPMEMBER = 'INCORRECT_COUNTY_CODE_SUPPLIER_GROUPMEMBER';
    const INCORRECT_COUNTY_CODE_CUSTOMER = 'INCORRECT_COUNTY_CODE_CUSTOMER';
    const INCORRECT_COUNTY_CODE_CUSTOMER_GROUPMEMBER = 'INCORRECT_COUNTY_CODE_CUSTOMER_GROUPMEMBER';
    const INCORRECT_COUNTY_CODE_FISCAL_REPRESENTATIVE = 'INCORRECT_COUNTY_CODE_FISCAL_REPRESENTATIVE';
    const INCORRECT_COUNTY_CODE_TAXNUMBEROFOBLIGATOR = 'INCORRECT_COUNTY_CODE_TAXNUMBEROFOBLIGATOR';
    const INCORRECT_COUNTRY_CODE_FISCALREPRESENTATIVEADDRESS = 'INCORRECT_COUNTRY_CODE_FISCALREPRESENTATIVEADDRESS';
    const INCORRECT_CITY_ZIP_CODE_SUPPLIER = 'INCORRECT_CITY_ZIP_CODE_SUPPLIER';
    const INCORRECT_CITY_ZIP_CODE_CUSTOMER = 'INCORRECT_CITY_ZIP_CODE_CUSTOMER';
    const INCORRECT_PRODUCT_CODE_CATEGORY_TAKEOVER_01 = 'INCORRECT_PRODUCT_CODE_CATEGORY_TAKEOVER_01';
    const INCORRECT_PRODUCT_CODE_VALUE_TAKEOVER_01 = 'INCORRECT_PRODUCT_CODE_VALUE_TAKEOVER_01';
    const INCORRECT_PRODUCT_CODE_CATEGORY_VALUE_TAKEOVER_01 = 'INCORRECT_PRODUCT_CODE_CATEGORY_VALUE_TAKEOVER_01';
    const INCORRECT_PRODUCT_CODE_FEE_WEIGHT = 'INCORRECT_PRODUCT_CODE_FEE_WEIGHT';
    const INCORRECT_PRODUCT_CODE_FEE_CATEGORY = 'INCORRECT_PRODUCT_CODE_FEE_CATEGORY';
    const INCORRECT_PRODUCT_CODE_FEE_SUMMARY_CATEGORY = 'INCORRECT_PRODUCT_CODE_FEE_SUMMARY_CATEGORY';
    const INCORRECT_PRODUCT_CODE_FEE_CATEGORY_MISSING = 'INCORRECT_PRODUCT_CODE_FEE_CATEGORY_MISSING';
    const INCORRECT_PRODUCT_CODE_VALUE = 'INCORRECT_PRODUCT_CODE_VALUE';
    const INCORRECT_DATE_INVOICE_DELIVERY_DATE = 'INCORRECT_DATE_INVOICE_DELIVERY_DATE';
    const INCORRECT_DATE_INVOICE_DELIVERY_TO_FROM = 'INCORRECT_DATE_INVOICE_DELIVERY_TO_FROM';
    const MISSING_HEAD_DATA_INVOICE_VAT_AMOUNT_HUF = 'MISSING_HEAD_DATA_INVOICE_VAT_AMOUNT_HUF';
    const MISSING_PRODUCT_FEE_DATA_LINE_OBLIGATED_CONTENT_EMPTY = 'MISSING_PRODUCT_FEE_DATA_LINE_OBLIGATED_CONTENT_EMPTY';
    const MISSING_PRODUCT_FEE_DATA_LINE_OBLIGATED_SUMMARY_EMPTY = 'MISSING_PRODUCT_FEE_DATA_LINE_OBLIGATED_SUMMARY_EMPTY';
    const MISSING_PRODUCT_FEE_DATA_LINE_CONTENT_SUMMARY_EMPTY = 'MISSING_PRODUCT_FEE_DATA_LINE_CONTENT_SUMMARY_EMPTY';
    const MISSING_PRODUCT_FEE_DATA_LINE_QUANTITY_SUMMARY_QUANTITY = 'MISSING_PRODUCT_FEE_DATA_LINE_QUANTITY_SUMMARY_QUANTITY';
    const MISSING_PRODUCT_FEE_DATA_LINE_MEASURING_SUMMARY = 'MISSING_PRODUCT_FEE_DATA_LINE_MEASURING_SUMMARY';
    const INCORRECT_HEAD_DATA_SUPPLIER_COMMUNITY_VAT_NUMBER = 'INCORRECT_HEAD_DATA_SUPPLIER_COMMUNITY_VAT_NUMBER';
    const INCORRECT_HEAD_DATA_CUSTOMER_TAX_NUMBER = 'INCORRECT_HEAD_DATA_CUSTOMER_TAX_NUMBER';
    const INCORRECT_HEAD_DATA_FISCALREPRESENTATIVE = 'INCORRECT_HEAD_DATA_FISCALREPRESENTATIVE';
    const INCORRECT_HEAD_DATA_FISCAL_REPRESENTATIVE_TAX_NUMBER = 'INCORRECT_HEAD_DATA_FISCAL_REPRESENTATIVE_TAX_NUMBER';
    const INCORRECT_HEAD_DATA_MOD_REF_INVOICE_NUMBER = 'INCORRECT_HEAD_DATA_MOD_REF_INVOICE_NUMBER';
    const INCORRECT_HEAD_DATA_LAST_MOD_LAST_MOD_DOC_NUMBER = 'INCORRECT_HEAD_DATA_LAST_MOD_LAST_MOD_DOC_NUMBER';
    const INCORRECT_HEAD_DATA_EXCISE_LICENCE = 'INCORRECT_HEAD_DATA_EXCISE_LICENCE';
    const INCORRECT_LINE_DATA_SELF_LINE_NUMBER = 'INCORRECT_LINE_DATA_SELF_LINE_NUMBER';
    const INCORRECT_LINE_DATA_LINE_AMOUNTS_NORMAL_MANDATORY = 'INCORRECT_LINE_DATA_LINE_AMOUNTS_NORMAL_MANDATORY';
    const INCORRECT_LINE_DATA_LINE_AMOUNTS_SIMPLIFIED_MANDATORY = 'INCORRECT_LINE_DATA_LINE_AMOUNTS_SIMPLIFIED_MANDATORY';
    const INCORRECT_LINE_DATA_AGGREGATE_INV_LINE_DATA_MANDATORY = 'INCORRECT_LINE_DATA_AGGREGATE_INV_LINE_DATA_MANDATORY';
    const INCORRECT_LINE_DATA_LINE_AMOUNTS_SIMPLIFIED_NOT_ALLOWED = 'INCORRECT_LINE_DATA_LINE_AMOUNTS_SIMPLIFIED_NOT_ALLOWED';
    const INCORRECT_PRODUCT_FEE_DATA_OBLIGATED_LINE = 'INCORRECT_PRODUCT_FEE_DATA_OBLIGATED_LINE';
    const INCORRECT_PRODUCT_FEE_DATA_CHARGE_SUM = 'INCORRECT_PRODUCT_FEE_DATA_CHARGE_SUM';
    const INCORRECT_SUMMARY_DATA_VAT_PERCENTAGE = 'INCORRECT_SUMMARY_DATA_VAT_PERCENTAGE';
    const INCORRECT_SUMMARY_DATA_VAT_EXEMPTION = 'INCORRECT_SUMMARY_DATA_VAT_EXEMPTION';
    const INCORRECT_SUMMARY_DATA_VAT_OUT_OF_SCOPE = 'INCORRECT_SUMMARY_DATA_VAT_OUT_OF_SCOPE';
    const INCORRECT_SUMMARY_DATA_VAT_DOMESTIC_REVERSE_CHARGE = 'INCORRECT_SUMMARY_DATA_VAT_DOMESTIC_REVERSE_CHARGE';
    const INCORRECT_SUMMARY_DATA_MARGIN_SCHEME_NO_VAT = 'INCORRECT_SUMMARY_DATA_MARGIN_SCHEME_NO_VAT';
    const INCORRECT_LINE_CALCULATION_GROSS_AMOUNT = 'INCORRECT_LINE_CALCULATION_GROSS_AMOUNT';
    const INCORRECT_LINE_CALCULATION_NETTO_AMOUNT = 'INCORRECT_LINE_CALCULATION_NETTO_AMOUNT';
    const INCORRECT_PRODUCT_FEE_CALCULATION_PRODUCT_FEE_AMOUNT = 'INCORRECT_PRODUCT_FEE_CALCULATION_PRODUCT_FEE_AMOUNT';
    const INCORRECT_PRODUCT_FEE_CALCULATION_AGGREGATE_PRODUCT_CHARGE_SUM = 'INCORRECT_PRODUCT_FEE_CALCULATION_AGGREGATE_PRODUCT_CHARGE_SUM ';
    const INCORRECT_PRODUCT_FEE_CALCULATION_PRODUCT_FEE_AMOUNT_SUMMARY = 'NCORRECT_PRODUCT_FEE_CALCULATION_PRODUCT_FEE_AMOUNT_SUMMARY';
    const INCORRECT_SUMMARY_CALCULATION_VAT_RATE_NET_AMOUNT_LINE = 'INCORRECT_SUMMARY_CALCULATION_VAT_RATE_NET_AMOUNT_LINE';
    const INCORRECT_SUMMARY_CALCULATION_VAT_RATE_NET_AMOUNT_SUMMARY = 'INCORRECT_SUMMARY_CALCULATION_VAT_RATE_NET_AMOUNT_SUMMARY';
    const INCORRECT_SUMMARY_CALCULATION_INVOICE_VAT_AMOUNT_HUF_SUMMARY = 'INCORRECT_SUMMARY_CALCULATION_INVOICE_VAT_AMOUNT_HUF_SUMMARY';
    const CORRECT_SUMMARY_CALCULATION_VAT_RATE_GROSS_AMOUNT_SUMMARY = 'CORRECT_SUMMARY_CALCULATION_VAT_RATE_GROSS_AMOUNT_SUMMARY';
    const INCORRECT_SUMMARY_CALCULATION_INVOICE_GROSS_AMOUNT_SUMMARY = 'INCORRECT_SUMMARY_CALCULATION_INVOICE_GROSS_AMOUNT_SUMMARY';
    const INCORRECT_SUMMARY_CALCULATION_INVOICE_VAT_AMOUNT_SUMMARY = 'INCORRECT_SUMMARY_CALCULATION_INVOICE_VAT_AMOUNT_SUMMARY';
    const INCORRECT_SUMMARY_CALCULATION_INVOICE_GROSS_AMOUNT_LINE = 'INCORRECT_SUMMARY_CALCULATION_INVOICE_GROSS_AMOUNT_LINE';
    const INCORRECT_SUMMARY_CALCULATION_VAT_CONTENT_SUMMARY_SIMPLIFIED = 'INCORRECT_SUMMARY_CALCULATION_VAT_CONTENT_SUMMARY_SIMPLIFIED';
    const INCORRECT_SUMMARY_CALCULATION_VAT_CONTENT_GROSS_AMOUNT_SUMMARY_SIMPLIFIED = 'INCORRECT_SUMMARY_CALCULATION_VAT_CONTENT_GROSS_AMOUNT_SUMMARY_SIMPLIFIED';
    const INCORRECT_SUMMARY_CALCULATION_INVOICE_VAT_AMOUNT = 'INCORRECT_SUMMARY_CALCULATION_INVOICE_VAT_AMOUNT';
    const INCORRECT_SUMMARY_CALCULATION_INVOICE_NET_AMOUNT = 'INCORRECT_SUMMARY_CALCULATION_INVOICE_NET_AMOUNT';
    const INCORRECT_SUMMARY_CALCULATION_VAT_CONTENT_GROSS_AMOUNT = 'INCORRECT_SUMMARY_CALCULATION_VAT_CONTENT_GROSS_AMOUNT';
    const LINE_SUMMARY_TYPE_MISMATCH_SUMMARY_SIMPLIFIED = 'LINE_SUMMARY_TYPE_MISMATCH_SUMMARY_SIMPLIFIED';
    const LINE_SUMMARY_TYPE_MISMATCH_LINE_SIMPLIFIED = 'LINE_SUMMARY_TYPE_MISMATCH_LINE_SIMPLIFIED';
    const LINE_SUMMARY_TYPE_MISMATCH_SUMMARY_NORMAL = 'LINE_SUMMARY_TYPE_MISMATCH_SUMMARY_NORMAL';
    const LINE_SUMMARY_TYPE_MISMATCH_LINE_NORMAL = 'LINE_SUMMARY_TYPE_MISMATCH_LINE_NORMAL';
    const SUPPLIER_CUSTOMER_MATCH_NAME = 'SUPPLIER_CUSTOMER_MATCH_NAME';
    const MISSING_LINE_PRODUCT_FEE_CONTENT = 'MISSING_LINE_PRODUCT_FEE_CONTENT';
    const MISSING_LINE_DATA_LINE_EXCHANGE_RATE = 'MISSING_LINE_DATA_LINE_EXCHANGE_RATE';
    const INCORRECT_SUMMARY_DATA_INVOICE_VAT_AMOUNT_HUF = 'INCORRECT_SUMMARY_DATA_INVOICE_VAT_AMOUNT_HUF';
    const INCORRECT_SUMMARY_DATA_AGGREGATE_INVOICE_VAT_AMOUNT_HUF = 'INCORRECT_SUMMARY_DATA_AGGREGATE_INVOICE_VAT_AMOUNT_HUF';
    const INCORRECT_SUMMARY_CALCULATION_VAT_RATE_VAT_AMOUNT_SUMMARY = 'INCORRECT_SUMMARY_CALCULATION_VAT_RATE_VAT_AMOUNT_SUMMARY';
    const INCORRECT_PRODUCT_CODE_VALUE_OWN = 'INCORRECT_PRODUCT_CODE_VALUE_OWN';
    const INCORRECT_DATE_MODIFICATION_ISSUE_DATE_EARLY = 'INCORRECT_DATE_MODIFICATION_ISSUE_DATE_EARLY';
    const INCORRECT_DATE_INVOICE_MODIFICATION_ISSUE_DATE_LATE = 'INCORRECT_DATE_INVOICE_MODIFICATION_ISSUE_DATE_LATE';
    const INCORRECT_DATE_INVOICE_MODIFICATION_ISSUE_DATE_EARLY = 'INCORRECT_DATE_INVOICE_MODIFICATION_ISSUE_DATE_EARLY';
    const INCORRECT_DATE_INVOICE_ISSUE_DATE_LATE = 'INCORRECT_DATE_INVOICE_ISSUE_DATE_LATE';
    const INCORRECT_DATE_INVOICE_ISSUE_DATE_EARLY = 'INCORRECT_DATE_INVOICE_ISSUE_DATE_EARLY';
    const INCORRECT_DATE_INVOICE_DELIVERY_DATE_LATE = 'INCORRECT_DATE_INVOICE_DELIVERY_DATE_LATE';
    const INCORRECT_DATE_INVOICE_DELIVERY_DATE_EARLY = 'INCORRECT_DATE_INVOICE_DELIVERY_DATE_EARLY';
    const INCORRECT_DATE_AGGREGATE_INVOICE_DELIVERY_DATE = 'INCORRECT_DATE_AGGREGATE_INVOICE_DELIVERY_DATE';
    const INCORRECT_LINE_REFERENCE = 'INCORRECT_LINE_REFERENCE';
    const INCORRECT_SUMMARY_DATA_INVOICE_NET_AMOUNT = 'INCORRECT_SUMMARY_DATA_INVOICE_NET_AMOUNT';
    const INCORRECT_SUMMARY_DATA_INVOICE_GROSS_AMOUNT = 'INCORRECT_SUMMARY_DATA_INVOICE_GROSS_AMOUNT';
    const INCORRECT_LINE_CALCULATION_LINE_NET_AMOUNT_HUF = 'INCORRECT_LINE_CALCULATION_LINE_NET_AMOUNT_HUF';
    const INCORRECT_LINE_CALCULATION_AGGREGATE_LINE_NET_AMOUNT_HUF = 'INCORRECT_LINE_CALCULATION_AGGREGATE_LINE_NET_AMOUNT_HUF';
    const INCORRECT_LINE_CALCULATION_LINE_VAT_AMOUNT_HUF = 'INCORRECT_LINE_CALCULATION_LINE_VAT_AMOUNT_HUF';
    const INCORRECT_LINE_CALCULATION_AGGREGATE_LINE_VAT_AMOUNT_HUF = 'INCORRECT_LINE_CALCULATION_AGGREGATE_LINE_VAT_AMOUNT_HUF';
    const INCORRECT_LINE_CALCULATION_LINE_UNIT_PRICE_HUF = 'INCORRECT_LINE_CALCULATION_LINE_UNIT_PRICE_HUF';
    const INCORRECT_LINE_CALCULATION_AGGREGATE_LINE_UNIT_PRICE_HUF = 'INCORRECT_LINE_CALCULATION_AGGREGATE_LINE_UNIT_PRICE_HUF';
    const INCORRECT_LINE_CALCULATION_LINE_GROSS_AMOUNT_NORMAL_HUF = 'INCORRECT_LINE_CALCULATION_LINE_GROSS_AMOUNT_NORMAL_HUF';
    const INCORRECT_LINE_CALCULATION_AGGREGATE_LINE_GROSS_AMOUNT_NORMAL_HUF = 'INCORRECT_LINE_CALCULATION_AGGREGATE_LINE_GROSS_AMOUNT_NORMAL_HUF';
    const INCORRECT_LINE_CALCULATION_LINE_GROSS_AMOUNT_SIMPLIFIED_HUF = 'INCORRECT_LINE_CALCULATION_LINE_GROSS_AMOUNT_SIMPLIFIED_HUF';
    const INCORRECT_LINE_CALCULATION_LINE_GROSS_AMOUNT_NORMAL_SUM = 'INCORRECT_LINE_CALCULATION_LINE_GROSS_AMOUNT_NORMAL_SUM';
    const INCORRECT_SUMMARY_DATA_INVOICE_NET_AMOUNT_HUF = 'INCORRECT_SUMMARY_DATA_INVOICE_NET_AMOUNT_HUF';
    const INCORRECT_SUMMARY_DATA_INVOICE_VAT_CONTENT_GROSS_AMOUNT_HUF = 'INCORRECT_SUMMARY_DATA_INVOICE_VAT_CONTENT_GROSS_AMOUNT_HUF';
    const INCORRECT_SUMMARY_DATA_INVOICE_GROSS_AMOUNT_HUF = 'INCORRECT_SUMMARY_DATA_INVOICE_GROSS_AMOUNT_HUF';
    const INCORRECT_SUMMARY_DATA_INVOICE_VAT_RATE_NET_AMOUNT_HUF = 'INCORRECT_SUMMARY_DATA_INVOICE_VAT_RATE_NET_AMOUNT_HUF';
    const INCORRECT_SUMMARY_DATA_INVOICE_VAT_RATE_VAT_AMOUNT_HUF = 'INCORRECT_SUMMARY_DATA_INVOICE_VAT_RATE_VAT_AMOUNT_HUF';
    const INCORRECT_SUMMARY_CALCULATION_VAT_RATE_NET_AMOUNT_HUF_LINE = 'INCORRECT_SUMMARY_CALCULATION_VAT_RATE_NET_AMOUNT_HUF_LINE';
    const INCORRECT_SUMMARY_CALCULATION_INVOICE_NET_AMOUNT_HUF = 'INCORRECT_SUMMARY_CALCULATION_INVOICE_NET_AMOUNT_HUF';
    const INCORRECT_SUMMARY_CALCULATION_INVOICE_GROSS_AMOUNT_HUF_SUMMARY = 'INCORRECT_SUMMARY_CALCULATION_INVOICE_GROSS_AMOUNT_HUF_SUMMARY';
    const INCORRECT_SUMMARY_CALCULATION_VAT_RATE_VAT_AMOUNT_HUF_SUMMARY = 'INCORRECT_SUMMARY_CALCULATION_VAT_RATE_VAT_AMOUNT_HUF_SUMMARY';
    const INCORRECT_SUMMARY_CALCULATION_INVOICE_GROSS_AMOUNT_HUF_LINE = 'INCORRECT_SUMMARY_CALCULATION_INVOICE_GROSS_AMOUNT_HUF_LINE';
    const INCORRECT_SUMMARY_CALCULATION_VAT_CONTENT_GROSS_AMOUNT_HUF_SUMMARY_SIMPLIFIED = 'INCORRECT_SUMMARY_CALCULATION_VAT_CONTENT_GROSS_AMOUNT_HUF_SUMMARY_SIMPLIFIED';
    const INCORRECT_SUMMARY_CALCULATION_INVOICE_VAT_AMOUNT_HUF = 'INCORRECT_SUMMARY_CALCULATION_INVOICE_VAT_AMOUNT_HUF';
    const INCORRECT_SUMMARY_CALCULATION_INVOICE_NET_AMOUNT_LINE_HUF = 'INCORRECT_SUMMARY_CALCULATION_INVOICE_NET_AMOUNT_LINE_HUF';
    const INCORRECT_HEAD_DATA_SUPPLIER_GROUPMEMBER_TAXPAYERID = 'INCORRECT_HEAD_DATA_SUPPLIER_GROUPMEMBER_TAXPAYERID';
    const INCORRECT_HEAD_DATA_CUSTOMER_TAXPAYERID = 'INCORRECT_HEAD_DATA_CUSTOMER_TAXPAYERID';
    const INCORRECT_HEAD_DATA_CUSTOMER_GROUPMEMBER_TAXPAYERID = 'INCORRECT_HEAD_DATA_CUSTOMER_GROUPMEMBER_TAXPAYERID';
    const INCORRECT_HEAD_DATA_PERIODICAL_SETTLEMENT = 'INCORRECT_HEAD_DATA_PERIODICAL_SETTLEMENT';
    const INCORRECT_LINE_DATA_UOM = 'INCORRECT_LINE_DATA_UOM';
    const INCORRECT_LINE_DATA_VAT_EXEMPTION_NORMAL = 'INCORRECT_LINE_DATA_VAT_EXEMPTION_NORMAL';
    const INCORRECT_LINE_DATA_VAT_OUT_OF_SCOPE_NORMAL = 'INCORRECT_LINE_DATA_VAT_OUT_OF_SCOPE_NORMAL';
    const INCORRECT_LINE_DATA_VAT_DOMESTIC_REVERSE_CHARGE_NORMAL = 'INCORRECT_LINE_DATA_VAT_DOMESTIC_REVERSE_CHARGE_NORMAL';
    const INCORRECT_LINE_DATA_MARGIN_SCHEME_INDICATOR_NORMAL = 'INCORRECT_LINE_DATA_MARGIN_SCHEME_INDICATOR_NORMAL';
    const INCORRECT_LINE_DATA_AGGREGATE_INVOICE_LINE_DATA = 'INCORRECT_LINE_DATA_AGGREGATE_INVOICE_LINE_DATA';
    const INCORRECT_SUMMARY_DATA_VAT_EXEMPTION_NORMAL = 'INCORRECT_SUMMARY_DATA_VAT_EXEMPTION_NORMAL';
    const INCORRECT_SUMMARY_DATA_VAT_OUT_OF_SCOPE_NORMAL = 'INCORRECT_SUMMARY_DATA_VAT_OUT_OF_SCOPE_NORMAL';
    const INCORRECT_SUMMARY_DATA_VAT_DOMESTIC_REVERSE_CHARGE_NORMAL = 'INCORRECT_SUMMARY_DATA_VAT_DOMESTIC_REVERSE_CHARGE_NORMAL';
    const INCORRECT_SUMMARY_DATA_MARGIN_SCHEME_INDICATOR = 'INCORRECT_SUMMARY_DATA_MARGIN_SCHEME_INDICATOR';
    const INCORRECT_SUMMARY_DATA_MARGIN_SCHEME_INDICATOR_NORMAL = 'INCORRECT_SUMMARY_DATA_MARGIN_SCHEME_INDICATOR_NORMAL';
    const INCORRECT_SUMMARY_DATA_VAT_AMOUNT_MISMATCH_NORMAL = 'INCORRECT_SUMMARY_DATA_VAT_AMOUNT_MISMATCH_NORMAL';
    const INCORRECT_SUMMARY_CALCULATION_VAT_EXEMPTION_SUMMARY_SIMPLIFIED = 'INCORRECT_SUMMARY_CALCULATION_VAT_EXEMPTION_SUMMARY_SIMPLIFIED';
    const INCORRECT_SUMMARY_CALCULATION_VAT_OUT_OF_SCOPE_SUMMARY_SIMPLIFIED = 'INCORRECT_SUMMARY_CALCULATION_VAT_OUT_OF_SCOPE_SUMMARY_SIMPLIFIED';
    const INCORRECT_SUMMARY_CALCULATION_VAT_DOMESTIC_REVERSE_CHARGE_SUMMARY_SIMPLIFIED = 'INCORRECT_SUMMARY_CALCULATION_VAT_DOMESTIC_REVERSE_CHARGE_SUMMARY_SIMPLIFIED';
    const INCORRECT_SUMMARY_CALCULATION_VAT_MARGIN_SCHEME_INDICATOR_SUMMARY_SIMPLIFIED = 'INCORRECT_SUMMARY_CALCULATION_VAT_MARGIN_SCHEME_INDICATOR_SUMMARY_SIMPLIFIED';
    const INCORRECT_SUMMARY_CALCULATION_VAT_AMOUNT_MISMATCH_SUMMARY_SIMPLIFIED = 'INCORRECT_SUMMARY_CALCULATION_VAT_AMOUNT_MISMATCH_SUMMARY_SIMPLIFIED';
}
