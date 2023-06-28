<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:xs="http://www.w3.org/2001/XMLSchema"
                xmlns="http://schemas.nav.gov.hu/OSA/3.0/data"
                xmlns:base="http://schemas.nav.gov.hu/OSA/3.0/base"
                exclude-result-prefixes="xs"
>
    <xsl:output method="xml" encoding="utf-8" indent="yes" xslt:indent-amount="4"
                xmlns:xslt="http://xml.apache.org/xslt"/>

    <xsl:param name="param_MODIF_TIMESTAMP"/>            <!-- Modification time: format: 2019-06-07T06:15:20.123Z -->
    <xsl:param name="param_MODIF_WOMASTER"/>             <!-- Without master: true or false -->
    <xsl:param name="param_ACCSET_PFA"/>                 <!-- Pénzforgalmi ÁFA: true or false -->
    <xsl:param name="param_ACCSET_AAM"/>                 <!-- AlanyiAdóMentes:  true or false -->
    <xsl:param name="param_TECHNICAL_ANNULMENT"/>        <!-- Technical annulment:  true or false -->
    <xsl:param name="param_ACCSET_SELF_BILLING"/>        <!-- Self billing:  true or false -->
    <xsl:param name="param_MODIFICATION_INDEX"/>         <!-- Modification index:  number or false -->
    <xsl:param name="param_LINE_REFERENCE_MAX"/>         <!-- Line reference max:  number or false -->
    <xsl:param name="param_CUSTOMER_IS_DOMESTIC"/>       <!-- Customer company is domestic: true or false -->
    <xsl:param name="param_CUSTOMER_IS_PRIVATE_PERSON"/> <!-- Customer company is private person: true or false -->
    <xsl:param name="param_CUSTOMER_IS_FOREIGN_LAND"/>   <!-- Customer company is a foreign land company: true or false -->
    <xsl:param name="param_CUSTOMER_IS_EU_COMPANY"/>     <!-- Customer company is EU company or third state company -->

    <!-- Lowercase - uppercase convert table -->
    <xsl:variable name="lowercase" select="'abcdefghijklmnopqrstuvwxyz'"/>
    <xsl:variable name="uppercase" select="'ABCDEFGHIJKLMNOPQRSTUVWXYZ'"/>

    <!-- Trim function - to trim spaced from row start end end  -->
    <xsl:template name="trim">
        <xsl:param name="str"/>
        <xsl:choose>
            <xsl:when test="string-length($str) &gt; 0 and substring($str, 1, 1) = ' '">
                <xsl:call-template name="trim">
                    <xsl:with-param name="str">
                        <xsl:value-of select="substring($str, 2)"/>
                    </xsl:with-param>
                </xsl:call-template>
            </xsl:when>
            <xsl:when test="string-length($str) &gt; 0 and substring($str, string-length($str)) = ' '">
                <xsl:call-template name="trim">
                    <xsl:with-param name="str">
                        <xsl:value-of select="substring($str, 1, string-length($str)-1)"/>
                    </xsl:with-param>
                </xsl:call-template>
            </xsl:when>
            <xsl:otherwise>
                <xsl:value-of select="$str"/>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="PartyTaxScheme[TaxScheme/ID = 'EUVAT']">
        <communityVatNumber>
            <xsl:value-of select="./CompanyID"/>
        </communityVatNumber>
    </xsl:template>

    <xsl:template match="PartyTaxScheme[TaxScheme/ID = 'THIRDSTATEVAT']">
        <thirdStateTaxId>
            <xsl:value-of select="./CompanyID"/>
        </thirdStateTaxId>
    </xsl:template>

    <xsl:template match="PartyTaxScheme[TaxScheme/ID = 'GROUPVAT']">
        <xsl:if test="position() = 1">
            <xsl:if test="substring-before(substring-after( ./CompanyID ,'-' ),'-') > 0">
                <base:taxpayerId>
                    <xsl:value-of select="substring-before( ./CompanyID ,'-' )"/>
                </base:taxpayerId>
                <base:vatCode>
                    <xsl:value-of select="substring-before(substring-after( ./CompanyID ,'-' ),'-')"/>
                </base:vatCode>
                <base:countyCode>
                    <xsl:value-of select="substring-after(substring-after( ./CompanyID ,'-' ),'-')"/>
                </base:countyCode>
            </xsl:if>
            <xsl:if test="not(substring-before(substring-after( ./CompanyID ,'-' ),'-'))">
                <base:taxpayerId>
                    <xsl:value-of select="./CompanyID"/>
                </base:taxpayerId>
            </xsl:if>
        </xsl:if>
    </xsl:template>

    <xsl:template match="PartyTaxScheme[TaxScheme/ID = 'VAT']">
        <xsl:if test="position() = 1">
            <xsl:if test="substring-before(substring-after( ./CompanyID ,'-' ),'-') > 0">
                <base:taxpayerId>
                    <xsl:value-of select="substring-before( ./CompanyID ,'-' )"/>
                </base:taxpayerId>
                <base:vatCode>
                    <xsl:value-of
                        select="substring-before(substring-after( ./CompanyID ,'-' ),'-')"/>
                </base:vatCode>
                <base:countyCode>
                    <xsl:value-of
                        select="substring-after(substring-after( ./CompanyID ,'-' ),'-')"/>
                </base:countyCode>
            </xsl:if>
            <xsl:if test="not(substring-before(substring-after( ./CompanyID ,'-' ),'-'))">
                <base:taxpayerId>
                    <xsl:value-of select="./CompanyID"/>
                </base:taxpayerId>
            </xsl:if>
        </xsl:if>
    </xsl:template>

    <xsl:template match="PostalAddress">
        <xsl:choose>
            <xsl:when test="./StreetName !='' and ./AdditionalStreetName !=''">
                <base:detailedAddress>
                    <base:countryCode>
                        <xsl:value-of select="./Country/IdentificationCode"/>
                    </base:countryCode>
                    <base:postalCode>
                        <xsl:value-of select="normalize-space(./PostalZone)"/>
                    </base:postalCode>
                    <base:city>
                        <xsl:value-of select="substring(./CityName,1,255)"/>
                    </base:city>
                    <base:streetName>
                        <xsl:value-of select="substring(./StreetName,1,255)"/>
                    </base:streetName>
                    <base:publicPlaceCategory>
                        <xsl:value-of select="substring(./AdditionalStreetName,1,50)"/>
                    </base:publicPlaceCategory>
                    <base:number>
                        <xsl:value-of select="substring(./BuildingNumber,1,50)"/>
                    </base:number>
                    <xsl:if test="string(./BlockName)">
                        <base:building>
                            <xsl:value-of select="substring(./BlockName,1,50)"/>
                        </base:building>
                    </xsl:if>
                    <xsl:if test="string(./Floor)">
                        <base:floor>
                            <xsl:value-of select="substring(./Floor,1,50)"/>
                        </base:floor>
                    </xsl:if>
                    <xsl:if test="string(./Room)">
                        <base:door>
                            <xsl:value-of select="substring(./Room,1,50)"/>
                        </base:door>
                    </xsl:if>
                </base:detailedAddress>
            </xsl:when>
            <xsl:otherwise>
                <base:simpleAddress>
                    <base:countryCode>
                        <xsl:value-of select="./Country/IdentificationCode"/>
                    </base:countryCode>
                    <base:postalCode>
                        <xsl:value-of select="normalize-space(./PostalZone)"/>
                    </base:postalCode>
                    <base:city>
                        <xsl:value-of select="substring(./CityName,1,255)"/>
                    </base:city>
                    <base:additionalAddressDetail>
                        <xsl:value-of select="translate(substring(./AddressLine,1,255),'&#10;&#13;','  ')"/>
                    </base:additionalAddressDetail>
                </base:simpleAddress>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="InvoiceLine">
        <line>
            <lineNumber>
                <xsl:call-template name="trim">
                    <xsl:with-param name="str" select="./ID"/>
                </xsl:call-template>
            </lineNumber>
            <xsl:if test="./BillingReference/BillingReferenceLine/ID !='' and //BavInvoice/BillingReference/InvoiceDocumentReference/ID !='' and //BavInvoice/InvoiceTypeCode != 'FinalInvoice'">
                <lineModificationReference>
                    <lineNumberReference>
                        <xsl:call-template name="trim">
                            <xsl:with-param name="str" select="./BillingReference/BillingReferenceLine/ID"/>
                        </xsl:call-template>
                    </lineNumberReference>
                    <xsl:choose>
                        <xsl:when test="./BillingReference/BillingReferenceLine/ID &gt; $param_LINE_REFERENCE_MAX">
                            <lineOperation>CREATE</lineOperation>
                        </xsl:when>
                        <xsl:otherwise>
                            <lineOperation>MODIFY</lineOperation>
                        </xsl:otherwise>
                    </xsl:choose>
                </lineModificationReference>
            </xsl:if>
            <advanceData>
                <advanceIndicator>
                    <xsl:value-of select="./AdvanceIndicator"/>
                </advanceIndicator>
            </advanceData>
            <lineExpressionIndicator>true</lineExpressionIndicator>
            <lineDescription>
                <xsl:value-of select="translate(substring(./Item/Name,1,512),'&#10;&#13;','  ')"/>
            </lineDescription>
            <quantity>
                <xsl:value-of select="format-number(./InvoicedQuantity,'#.000000')"/>
            </quantity>
            <unitOfMeasure>
                <xsl:value-of select="./UnitCode"/>
            </unitOfMeasure>
            <xsl:if test="./OwnUnitCode and string-length(./OwnUnitCode) &gt; 0 ">
                <unitOfMeasureOwn>
                    <xsl:value-of select="./OwnUnitCode"/>
                </unitOfMeasureOwn>
            </xsl:if>
            <unitPrice>
                <xsl:value-of select="format-number(./Price/PriceAmount,'#.000000')"/>
            </unitPrice>
            <unitPriceHUF>
                <xsl:value-of select="format-number((./Price/PriceAmount * //BavInvoice/PricingExchangeRate/CalculationRate),'#.000000')"/>
            </unitPriceHUF>
            <lineDiscountData>
                <xsl:if test="./discountDescription and string-length(./discountDescription) &gt; 0">
                    <discountDescription><xsl:value-of select="./discountDescription"/></discountDescription>
                </xsl:if>
                <xsl:if test="./discountValue and ./discountValue &gt; 0 ">
                    <discountValue><xsl:value-of select="format-number(./discountValue, '#.00')"/></discountValue>
                </xsl:if>
            </lineDiscountData>
            <lineAmountsNormal>
                <lineNetAmountData>
                    <lineNetAmount>
                        <xsl:value-of select="format-number(./LineExtensionAmount,'0.##')"/>
                    </lineNetAmount>
                    <lineNetAmountHUF>
                        <xsl:value-of select="format-number((./LineExtensionAmount * //BavInvoice/PricingExchangeRate/CalculationRate),'0.##')"/>
                    </lineNetAmountHUF>
                </lineNetAmountData>
                <lineVatRate>
                    <xsl:choose>
                        <xsl:when test="./Item/ClassifiedTaxCategory/Percent = 0">
                            <xsl:choose>
                                <xsl:when test="
                                        ./Item/ClassifiedTaxCategory/NavCase = 'TRAVEL_AGENCY'
                                        or ./Item/ClassifiedTaxCategory/NavCase = 'SECOND_HAND'
                                        or ./Item/ClassifiedTaxCategory/NavCase = 'ARTWORK'
                                        or ./Item/ClassifiedTaxCategory/NavCase = 'ANTIQUES'
                                    ">
                                    <marginSchemeIndicator><xsl:value-of select="./Item/ClassifiedTaxCategory/NavCase"/></marginSchemeIndicator>
                                </xsl:when>
                                <xsl:when test="
                                        ./Item/ClassifiedTaxCategory/NavCase = 'ATK'
                                        or ./Item/ClassifiedTaxCategory/NavCase = 'EUFAD37'
                                        or ./Item/ClassifiedTaxCategory/NavCase = 'EUFADE'
                                        or ./Item/ClassifiedTaxCategory/NavCase = 'EUE'
                                        or ./Item/ClassifiedTaxCategory/NavCase = 'HO'
                                    ">
                                    <vatOutOfScope>
                                        <case><xsl:value-of select="./Item/ClassifiedTaxCategory/NavCase"/></case>
                                        <reason>
                                            <xsl:choose>
                                                <xsl:when test="./Item/ClassifiedTaxCategory/NavCase ='ATK'">tárgyi hatályon kívüli</xsl:when>
                                                <xsl:when test="./Item/ClassifiedTaxCategory/NavCase ='EUFAD37'">közösségi adóalanynak nyújtott, az áfatörvény 37. paragrafusa alapján (főszabály) szerint, a megrendelő gazdasági letelepedettsége országában teljesített szolgáltatás</xsl:when>
                                                <xsl:when test="./Item/ClassifiedTaxCategory/NavCase ='EUFADE'">közösségi adóalanynak nyújtott, nem főszabály szerint, fordítottan adózó szolgáltatás</xsl:when>
                                                <xsl:when test="./Item/ClassifiedTaxCategory/NavCase ='EUE'">más tagállami, nem fordított adózású ügylet</xsl:when>
                                                <xsl:when test="./Item/ClassifiedTaxCategory/NavCase ='HO'">harmadik országban teljesített ügylet</xsl:when>
                                            </xsl:choose>
                                        </reason>
                                    </vatOutOfScope>
                                </xsl:when>
                                <xsl:when test="./Item/ClassifiedTaxCategory/NavCase = 'FAD'">
                                    <vatDomesticReverseCharge>true</vatDomesticReverseCharge>
                                </xsl:when>
                                <xsl:otherwise>
                                    <vatExemption>
                                        <case><xsl:value-of select="./Item/ClassifiedTaxCategory/NavCase"/></case>
                                        <reason>
                                            <xsl:choose>
                                                <xsl:when test="./Item/ClassifiedTaxCategory/NavCase ='AAM'">alanyi adómentes</xsl:when>
                                                <xsl:when test="./Item/ClassifiedTaxCategory/NavCase ='TAM'">tárgyi adómentes</xsl:when>
                                                <xsl:when test="./Item/ClassifiedTaxCategory/NavCase ='KBAET'">közösségen belüli adómentes értékesítés</xsl:when>
                                                <xsl:when test="./Item/ClassifiedTaxCategory/NavCase ='KBAUK'">adómentes, közösségen belüli új közlekedési eszköz értékesítés</xsl:when>
                                                <xsl:when test="./Item/ClassifiedTaxCategory/NavCase ='NAM'">egyéb nemzetközi ügylethez kapcsoldó jogcímen mentes ügylet</xsl:when>
                                            </xsl:choose>
                                        </reason>
                                    </vatExemption>
                                </xsl:otherwise>
                            </xsl:choose>
                        </xsl:when>
                        <xsl:otherwise>
                            <vatPercentage>
                                <xsl:value-of select="./Item/ClassifiedTaxCategory/Percent div 100"/>
                            </vatPercentage>
                        </xsl:otherwise>
                    </xsl:choose>
                </lineVatRate>
                <lineVatData>
                    <lineVatAmount>
                        <xsl:value-of select="format-number(./TaxAmount,'0.##')"/>
                    </lineVatAmount>
                    <lineVatAmountHUF>
                        <xsl:value-of select="format-number((./TaxAmount * //BavInvoice/PricingExchangeRate/CalculationRate),'0.##')"/>
                    </lineVatAmountHUF>
                </lineVatData>
                <lineGrossAmountData>
                    <lineGrossAmountNormal>
                        <xsl:value-of select="format-number(./LineExtensionAmount + ./TaxAmount, '#.00')"/>
                    </lineGrossAmountNormal>
                    <lineGrossAmountNormalHUF>
                        <xsl:value-of select="format-number(((./LineExtensionAmount + ./TaxAmount) * //BavInvoice/PricingExchangeRate/CalculationRate), '#.00')"/>
                    </lineGrossAmountNormalHUF>
                </lineGrossAmountData>
            </lineAmountsNormal>
        </line>
    </xsl:template>

    <xsl:template match="TaxSubtotal">
        <xsl:for-each select=".">
        <summaryByVatRate>
            <vatRate>
                <xsl:choose>
                    <xsl:when test="./Percent = 0">
                        <xsl:choose>
                            <xsl:when test="
                                    ./TaxCategory/NavCase = 'TRAVEL_AGENCY'
                                    or ./TaxCategory/NavCase = 'SECOND_HAND'
                                    or ./TaxCategory/NavCase = 'ARTWORK'
                                    or ./TaxCategory/NavCase = 'ANTIQUES'
                                ">
                                <marginSchemeIndicator><xsl:value-of select="./TaxCategory/NavCase"/></marginSchemeIndicator>
                            </xsl:when>
                            <xsl:when test="
                                    ./TaxCategory/NavCase = 'ATK'
                                    or ./TaxCategory/NavCase = 'EUFAD37'
                                    or ./TaxCategory/NavCase = 'EUFADE'
                                    or ./TaxCategory/NavCase = 'EUE'
                                    or ./TaxCategory/NavCase = 'HO'
                                ">
                                <vatOutOfScope>
                                    <case><xsl:value-of select="./TaxCategory/NavCase"/></case>
                                    <reason>
                                        <xsl:choose>
                                            <xsl:when test="./TaxCategory/NavCase ='ATK'">tárgyi hatályon kívüli</xsl:when>
                                            <xsl:when test="./TaxCategory/NavCase ='EUFAD37'">közösségi adóalanynak nyújtott, az áfatörvény 37. paragrafusa alapján (főszabály) szerint, a megrendelő gazdasági letelepedettsége országában teljesített szolgáltatás</xsl:when>
                                            <xsl:when test="./TaxCategory/NavCase ='EUFADE'">közösségi adóalanynak nyújtott, nem főszabály szerint, fordítottan adózó szolgáltatás</xsl:when>
                                            <xsl:when test="./TaxCategory/NavCase ='EUE'">más tagállami, nem fordított adózású ügylet</xsl:when>
                                            <xsl:when test="./TaxCategory/NavCase ='HO'">harmadik országban teljesített ügylet</xsl:when>
                                        </xsl:choose>
                                    </reason>
                                </vatOutOfScope>
                            </xsl:when>
                            <xsl:when test="./TaxCategory/NavCase = 'FAD'">
                                <vatDomesticReverseCharge>true</vatDomesticReverseCharge>
                            </xsl:when>
                            <xsl:otherwise>
                                <vatExemption>
                                    <case><xsl:value-of select="./TaxCategory/NavCase"/></case>
                                    <reason>
                                        <xsl:choose>
                                            <xsl:when test="./TaxCategory/NavCase ='AAM'">alanyi adómentes</xsl:when>
                                            <xsl:when test="./TaxCategory/NavCase ='TAM'">tárgyi adómentes</xsl:when>
                                            <xsl:when test="./TaxCategory/NavCase ='KBAET'">közösségen belüli adómentes értékesítés</xsl:when>
                                            <xsl:when test="./TaxCategory/NavCase ='KBAUK'">adómentes, közösségen belüli új közlekedési eszköz értékesítés</xsl:when>
                                            <xsl:when test="./TaxCategory/NavCase ='NAM'">egyéb nemzetközi ügylethez kapcsoldó jogcímen mentes ügylet</xsl:when>
                                        </xsl:choose>
                                    </reason>
                                </vatExemption>
                            </xsl:otherwise>
                        </xsl:choose>
                    </xsl:when>
                    <xsl:otherwise>
                        <vatPercentage>
                            <xsl:value-of select="./Percent div 100"/>
                        </vatPercentage>
                    </xsl:otherwise>
                </xsl:choose>
            </vatRate>
            <vatRateNetData>
                <vatRateNetAmount>
                    <xsl:value-of select="format-number(./TaxableAmount,'0.##')"/>
                </vatRateNetAmount>
                <vatRateNetAmountHUF>
                    <xsl:value-of select="format-number((./TaxableAmount * //BavInvoice/PricingExchangeRate/CalculationRate),'0.##')"/>
                </vatRateNetAmountHUF>
            </vatRateNetData>
            <vatRateVatData>
                <vatRateVatAmount>
                    <xsl:value-of select="format-number(./TaxAmount, '0.##')"/>
                </vatRateVatAmount>
                <vatRateVatAmountHUF>
                    <xsl:value-of select="format-number((./TaxAmount * //BavInvoice/PricingExchangeRate/CalculationRate), '0.##')"/>
                </vatRateVatAmountHUF>
            </vatRateVatData>
            <vatRateGrossData>
                <vatRateGrossAmount>
                    <xsl:value-of select="format-number(./TaxableAmount + ./TaxAmount, '0.##')"/>
                </vatRateGrossAmount>
                <vatRateGrossAmountHUF>
                    <xsl:value-of select="format-number(((./TaxableAmount + ./TaxAmount) * //BavInvoice/PricingExchangeRate/CalculationRate), '0.##')"/>
                </vatRateGrossAmountHUF>
            </vatRateGrossData>
        </summaryByVatRate>
        </xsl:for-each>
    </xsl:template>

    <xsl:template match="BillingReference">
        <xsl:if test="position() = 1">
            <invoiceReference>
                <originalInvoiceNumber>
                    <xsl:value-of select="./InvoiceDocumentReference[translate(DocumentDescription,$lowercase,$uppercase) = 'ORIGINAL']/ID"/>
                </originalInvoiceNumber>
                <modifyWithoutMaster>
                    <xsl:choose>
                        <xsl:when test="//BavInvoice/ModifyWithoutMaster = 'true'">
                            true
                        </xsl:when>
                        <xsl:when test="//BavInvoice/ModifyWithoutMaster = 'false'">
                            false
                        </xsl:when>
                        <xsl:otherwise>
                            <xsl:value-of select="$param_MODIF_WOMASTER"/>
                        </xsl:otherwise>
                    </xsl:choose>
                </modifyWithoutMaster>
                <xsl:if test="$param_MODIFICATION_INDEX != 'false'">
                    <modificationIndex>
                        <xsl:value-of select="$param_MODIFICATION_INDEX"/>
                    </modificationIndex>
                </xsl:if>
            </invoiceReference>
        </xsl:if>
    </xsl:template>

    <xsl:template match="/">
        <InvoiceData xmlns="http://schemas.nav.gov.hu/OSA/3.0/data"
                     xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                     xsi:schemaLocation="http://schemas.nav.gov.hu/OSA/3.0/data invoiceData.xsd"
                     xmlns:common="http://schemas.nav.gov.hu/NTCA/1.0/common"
                     xmlns:base="http://schemas.nav.gov.hu/OSA/3.0/base">
            <invoiceNumber>
                <xsl:value-of select="//BavInvoice/ID"/>
            </invoiceNumber>
            <invoiceIssueDate>
                <xsl:value-of select="//BavInvoice/IssueDate"/>
            </invoiceIssueDate>
            <completenessIndicator>false</completenessIndicator>
            <invoiceMain>
                <invoice>
                    <xsl:if test="//BavInvoice/BillingReference[InvoiceDocumentReference/ID != ''] and //BavInvoice/InvoiceTypeCode != 'FinalInvoice'">
                        <xsl:apply-templates select="//BavInvoice/BillingReference"/>
                    </xsl:if>
                    <invoiceHead>
                        <supplierInfo>
                            <xsl:choose>
                                <xsl:when test="string(//BavInvoice/AccountingSupplierParty/PartyTaxScheme[TaxScheme/ID = 'GROUPVAT']/CompanyID)">
                                    <xsl:if test="string(//BavInvoice/AccountingSupplierParty/PartyTaxScheme[TaxScheme/ID = 'GROUPVAT']/CompanyID)">
                                        <supplierTaxNumber>
                                            <xsl:apply-templates select="//BavInvoice/AccountingSupplierParty/PartyTaxScheme[TaxScheme/ID = 'GROUPVAT']"/>
                                        </supplierTaxNumber>
                                    </xsl:if>
                                    <xsl:if test="string(//BavInvoice/AccountingSupplierParty/PartyTaxScheme[TaxScheme/ID = 'VAT']/CompanyID)">
                                        <groupMemberTaxNumber>
                                            <xsl:apply-templates select="//BavInvoice/AccountingSupplierParty/PartyTaxScheme[TaxScheme/ID = 'VAT']"/>
                                        </groupMemberTaxNumber>
                                    </xsl:if>
                                </xsl:when>

                                <xsl:otherwise>
                                    <xsl:if test="string(//BavInvoice/AccountingSupplierParty/PartyTaxScheme[TaxScheme/ID = 'VAT']/CompanyID)">
                                        <supplierTaxNumber>
                                            <xsl:apply-templates select="//BavInvoice/AccountingSupplierParty/PartyTaxScheme[TaxScheme/ID = 'VAT']"/>
                                        </supplierTaxNumber>
                                    </xsl:if>
                                </xsl:otherwise>
                            </xsl:choose>
                            <xsl:if test="string(//BavInvoice/AccountingSupplierParty/PartyTaxScheme[TaxScheme/ID = 'EUVAT']/CompanyID)">
                                <xsl:apply-templates select="//BavInvoice/AccountingSupplierParty/PartyTaxScheme[TaxScheme/ID = 'EUVAT']"/>
                            </xsl:if>
                            <supplierName>
                                <xsl:value-of select="substring(//BavInvoice/AccountingSupplierParty/PartyName, 1, 512)"/>
                            </supplierName>
                            <supplierAddress>
                                <xsl:apply-templates select="//BavInvoice/AccountingSupplierParty/PostalAddress"/>
                            </supplierAddress>
                            <!-- TODO - should add bank account for supplier -->
                            <!--<supplierBankAccountNumber>88888888-66666666-12345678</supplierBankAccountNumber>-->
                            <xsl:if test="$param_ACCSET_AAM='true'">
                                <individualExemption>true</individualExemption>
                            </xsl:if>
                        </supplierInfo>
                        <customerInfo>
                            <customerVatStatus>
                                <xsl:choose>
                                    <xsl:when test="$param_CUSTOMER_IS_DOMESTIC='true'">DOMESTIC</xsl:when>
                                    <xsl:when test="$param_CUSTOMER_IS_PRIVATE_PERSON='true'">PRIVATE_PERSON</xsl:when>
                                    <xsl:otherwise>OTHER</xsl:otherwise>
                                </xsl:choose>
                            </customerVatStatus>
                            <xsl:if test="$param_CUSTOMER_IS_PRIVATE_PERSON='false' and $param_CUSTOMER_IS_FOREIGN_LAND='false'">
                                <customerVatData>
                                    <xsl:if test="$param_CUSTOMER_IS_DOMESTIC='true'">
                                        <xsl:choose>
                                            <xsl:when test="string(//BavInvoice/AccountingCustomerParty/PartyTaxScheme[TaxScheme/ID = 'GROUPVAT']/CompanyID)">
                                                <xsl:if test="string(//BavInvoice/AccountingCustomerParty/PartyTaxScheme[TaxScheme/ID = 'GROUPVAT']/CompanyID)">
                                                    <customerTaxNumber>
                                                        <xsl:apply-templates select="//BavInvoice/AccountingCustomerParty/PartyTaxScheme[TaxScheme/ID = 'GROUPVAT']"/>
                                                        <xsl:if test="string(//BavInvoice/AccountingCustomerParty/PartyTaxScheme[TaxScheme/ID = 'VAT']/CompanyID)">
                                                            <groupMemberTaxNumber>
                                                                <xsl:apply-templates select="//BavInvoice/AccountingCustomerParty/PartyTaxScheme[TaxScheme/ID = 'VAT']"/>
                                                            </groupMemberTaxNumber>
                                                        </xsl:if>
                                                    </customerTaxNumber>
                                                </xsl:if>
                                            </xsl:when>
                                            <xsl:otherwise>
                                                <xsl:if test="string(//BavInvoice/AccountingCustomerParty/PartyTaxScheme[TaxScheme/ID = 'VAT']/CompanyID)">
                                                    <customerTaxNumber>
                                                        <xsl:apply-templates select="//BavInvoice/AccountingCustomerParty/PartyTaxScheme[TaxScheme/ID = 'VAT']"/>
                                                    </customerTaxNumber>
                                                </xsl:if>
                                            </xsl:otherwise>
                                        </xsl:choose>
                                    </xsl:if>
                                    <xsl:if test="
                                                $param_CUSTOMER_IS_DOMESTIC='false'
                                                and $param_CUSTOMER_IS_EU_COMPANY='true'
                                                and string(//BavInvoice/AccountingCustomerParty/PartyTaxScheme[TaxScheme/ID = 'EUVAT']/CompanyID)"
                                    >
                                        <xsl:apply-templates select="//BavInvoice/AccountingCustomerParty/PartyTaxScheme[TaxScheme/ID = 'EUVAT']"/>
                                    </xsl:if>
                                    <xsl:if test="
                                                $param_CUSTOMER_IS_DOMESTIC='false'
                                                and $param_CUSTOMER_IS_EU_COMPANY='false'
                                                and string(//BavInvoice/AccountingCustomerParty/PartyTaxScheme[TaxScheme/ID = 'THIRDSTATEVAT']/CompanyID)"
                                    >
                                        <xsl:apply-templates select="//BavInvoice/AccountingCustomerParty/PartyTaxScheme[TaxScheme/ID = 'THIRDSTATEVAT']"/>
                                    </xsl:if>
                                </customerVatData>
                            </xsl:if>
                            <xsl:if test="$param_CUSTOMER_IS_PRIVATE_PERSON='false'">
                                <customerName>
                                    <xsl:value-of select="substring(//BavInvoice/AccountingCustomerParty/PartyName, 1, 512)"/>
                                </customerName>
                                <customerAddress>
                                    <xsl:apply-templates select="//BavInvoice/AccountingCustomerParty/PostalAddress"/>
                                </customerAddress>
                            </xsl:if>
                        </customerInfo>
                        <invoiceDetail>
                            <invoiceCategory>
                                <xsl:choose>
                                    <xsl:when test="//BavInvoice/InvoiceTypeCode = 'SummaryInvoice'">AGGREGATE</xsl:when>
                                    <xsl:otherwise>NORMAL</xsl:otherwise>
                                </xsl:choose>
                            </invoiceCategory>
                            <invoiceDeliveryDate><xsl:value-of select="//BavInvoice/TaxPointDate"/></invoiceDeliveryDate>
                            <xsl:if test="//BavInvoice/InvoicePeriod/StartDate">
                                <invoiceDeliveryPeriodStart>
                                    <xsl:value-of select="//BavInvoice/InvoicePeriod/StartDate"/>
                                </invoiceDeliveryPeriodStart>
                            </xsl:if>
                            <xsl:if test="//BavInvoice/InvoicePeriod/EndDate">
                                <invoiceDeliveryPeriodEnd>
                                    <xsl:value-of select="//BavInvoice/InvoicePeriod/EndDate"/>
                                </invoiceDeliveryPeriodEnd>
                            </xsl:if>
                            <xsl:if test="$param_ACCSET_AAM='true'">
                                <smallBusinessIndicator>true</smallBusinessIndicator>
                            </xsl:if>
                            <currencyCode><xsl:value-of select="//BavInvoice/DocumentCurrencyCode"/></currencyCode>
                            <exchangeRate><xsl:value-of select="//BavInvoice/PricingExchangeRate/CalculationRate"/></exchangeRate>
                            <xsl:if test="$param_ACCSET_SELF_BILLING='true'">
                                <selfBillingIndicator>true</selfBillingIndicator>
                            </xsl:if>
                            <paymentMethod>
                                <xsl:choose>
                                    <xsl:when test="//BavInvoice/PaymentMeans/PaymentMeansCode = '10'">CASH</xsl:when>
                                    <xsl:when test="//BavInvoice/PaymentMeans/PaymentMeansCode = '20'">VOUCHER</xsl:when>
                                    <xsl:when test="//BavInvoice/PaymentMeans/PaymentMeansCode = '30'">TRANSFER</xsl:when>
                                    <xsl:when test="//BavInvoice/PaymentMeans/PaymentMeansCode = '48'">CARD</xsl:when>
                                    <xsl:otherwise>OTHER</xsl:otherwise>
                                </xsl:choose>
                            </paymentMethod>
                            <xsl:if test="//BavInvoice/DueDate">
                                <paymentDate>
                                    <xsl:value-of select="//BavInvoice/DueDate"/>
                                </paymentDate>
                            </xsl:if>
                            <xsl:if test="$param_ACCSET_PFA='true'">
                                <cashAccountingIndicator>true</cashAccountingIndicator>
                            </xsl:if>
                            <invoiceAppearance>
                                <xsl:choose>
                                    <xsl:when test="//BavInvoice/OutputType = 'E'">ELECTRONIC</xsl:when>
                                    <xsl:when test="//BavInvoice/OutputType = 'P'">PAPER</xsl:when>
                                    <!-- TODO We can't handle EDI type -->
                                    <!--<xsl:when test="//BavInvoice/OutputType = 'EDI'">EDI</xsl:when>-->
                                    <xsl:otherwise>UNKNOWN</xsl:otherwise>
                                </xsl:choose>
                            </invoiceAppearance>
                        </invoiceDetail>
                    </invoiceHead>
                    <invoiceLines>
                        <!-- We not support big invoices (upper 10Mb) because we can't merge items currently, so mergedItemIndicator always will be false -->
                        <mergedItemIndicator>false</mergedItemIndicator>
                        <xsl:apply-templates select="//BavInvoice/InvoiceLine"/>
                    </invoiceLines>
                    <invoiceSummary>
                        <summaryNormal>
                            <xsl:apply-templates select="//BavInvoice/TaxTotal/TaxSubtotal"/>
                            <invoiceNetAmount>
                                <xsl:value-of select="format-number(//BavInvoice/LegalMonetaryTotal/TaxExclusiveAmount,'0.##')"/>
                            </invoiceNetAmount>
                            <invoiceNetAmountHUF>
                                <xsl:value-of select="format-number((//BavInvoice/LegalMonetaryTotal/TaxExclusiveAmount * //BavInvoice/PricingExchangeRate/CalculationRate),'0.##')"/>
                            </invoiceNetAmountHUF>
                            <invoiceVatAmount>
                                <xsl:value-of select="format-number(//BavInvoice/TaxTotal/TaxAmountInOriginalCurrency,'0.##')"/>
                            </invoiceVatAmount>
                            <invoiceVatAmountHUF>
                                <xsl:value-of select="format-number((//BavInvoice/TaxTotal/TaxAmountInOriginalCurrency * //BavInvoice/PricingExchangeRate/CalculationRate),'0.##')"/>
                            </invoiceVatAmountHUF>
                        </summaryNormal>
                        <summaryGrossData>
                            <invoiceGrossAmount>
                                <xsl:value-of select="format-number(//BavInvoice/LegalMonetaryTotal/TaxInclusiveAmount,'0.##')"/>
                            </invoiceGrossAmount>
                            <invoiceGrossAmountHUF>
                                <xsl:value-of select="format-number((//BavInvoice/LegalMonetaryTotal/TaxInclusiveAmount * //BavInvoice/PricingExchangeRate/CalculationRate),'0.##')"/>
                            </invoiceGrossAmountHUF>
                        </summaryGrossData>
                    </invoiceSummary>
                </invoice>
            </invoiceMain>
        </InvoiceData>
    </xsl:template>
</xsl:stylesheet>
