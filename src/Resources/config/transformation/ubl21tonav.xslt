<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
        xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
        xmlns:inv="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2"
        xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2"
        xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"
        xmlns="http://schemas.nav.gov.hu/OSA/1.0/data"
        exclude-result-prefixes="inv cac cbc"
>

<xsl:output method="xml" encoding="utf-8" indent="yes" xslt:indent-amount="4" xmlns:xslt="http://xml.apache.org/xslt" />

<xsl:param name="param_MODIF_TIMESTAMP" />       <!-- Modification time: format: 2019-06-07T06:15:20.123Z -->
<xsl:param name="param_MODIF_WOMASTER" />        <!-- Without master: true or false -->
<xsl:param name="param_ACCSET_PFA" />            <!-- Pénzforgalmi ÁFA: true or false -->
<xsl:param name="param_ACCSET_AAM" />            <!-- AlanyiAdóMentes:  true or false -->
<xsl:param name="param_TECHNICAL_ANNULMENT" />   <!-- Technical annulment:  true or false -->


<!-- Kisbetu-nagybetu konverzios tabla -->
<xsl:variable name="lowercase" select="'abcdefghijklmnopqrstuvwxyz'" />
<xsl:variable name="uppercase" select="'ABCDEFGHIJKLMNOPQRSTUVWXYZ'" />


<!-- Trim funkcio - sorvegi es soreleji space-ek levagasahoz -->
<xsl:template name="trim">
            <xsl:param name="str"/>
            <xsl:choose>
                <xsl:when test="string-length($str) &gt; 0 and substring($str, 1, 1) = ' '">
                    <xsl:call-template name="trim"><xsl:with-param name="str"><xsl:value-of select="substring($str, 2)"/></xsl:with-param></xsl:call-template></xsl:when>
                <xsl:when test="string-length($str) &gt; 0 and substring($str, string-length($str)) = ' '">
                    <xsl:call-template name="trim"><xsl:with-param name="str"><xsl:value-of select="substring($str, 1, string-length($str)-1)"/></xsl:with-param></xsl:call-template></xsl:when>
                <xsl:otherwise><xsl:value-of select="$str"/></xsl:otherwise>
            </xsl:choose>
</xsl:template>





<xsl:template match="cac:BillingReference">
                        <xsl:if test="position() = 1">
                                <invoiceReference>
                                        <originalInvoiceNumber><xsl:value-of select="../cac:BillingReference/cac:InvoiceDocumentReference[translate(cbc:DocumentDescription,$lowercase,$uppercase) = 'ORIGINAL']/cbc:ID"/></originalInvoiceNumber>
                                        <modificationIssueDate><xsl:value-of select="/inv:Invoice/cbc:IssueDate"/></modificationIssueDate>
                                        <modificationTimestamp><xsl:value-of select="$param_MODIF_TIMESTAMP"/></modificationTimestamp> <!-- Needs to be param! -->

                                        <!-- Uppercase fixup for bad external systems -->
                                        <xsl:if test="../cac:BillingReference[translate(cac:InvoiceDocumentReference/cbc:DocumentDescription,$lowercase,$uppercase) = 'LAST' ] ">
                                                <lastModificationReference>
                                                        <xsl:value-of select="../cac:BillingReference/cac:InvoiceDocumentReference[translate(cbc:DocumentDescription,$lowercase,$uppercase) = 'LAST']/cbc:ID"/></lastModificationReference>
                                        </xsl:if>

                                        <modifyWithoutMaster>
                                        	<xsl:choose>
                                        		<xsl:when test="translate(/inv:Invoice/cbc:Note[ position()=7 ],$uppercase,$lowercase) = 'true'  or translate(/inv:Invoice/cbc:Note[ position()=7 ],$uppercase,$lowercase) = 'true' ">true</xsl:when>
                                        		<xsl:when test="translate(/inv:Invoice/cbc:Note[ position()=7 ],$uppercase,$lowercase) = 'false' or translate(/inv:Invoice/cbc:Note[ position()=7 ],$uppercase,$lowercase) = 'false' ">false</xsl:when>
                                        		<xsl:when test="translate(/inv:Invoice/cbc:Note[ position()=8 ],$uppercase,$lowercase) = 'true'  or translate(/inv:Invoice/cbc:Note[ position()=8 ],$uppercase,$lowercase) = 'true' ">true</xsl:when>
                                        		<xsl:when test="translate(/inv:Invoice/cbc:Note[ position()=8 ],$uppercase,$lowercase) = 'false' or translate(/inv:Invoice/cbc:Note[ position()=8 ],$uppercase,$lowercase) = 'false' ">false</xsl:when>
                                        		<xsl:otherwise>
		                                        	<xsl:value-of select="$param_MODIF_WOMASTER"/>
		                                        </xsl:otherwise>
                                        	</xsl:choose>
                                        </modifyWithoutMaster>
                                </invoiceReference>
                        </xsl:if>
</xsl:template>



<xsl:template match="cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'EUVAT']">
                                <communityVatNumber><xsl:value-of select="./cbc:CompanyID"/></communityVatNumber>
</xsl:template>


<xsl:template match="cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'VAT']">
                                <xsl:if test="position() = 1">
                                        <taxpayerId><xsl:value-of select="substring-before( ./cbc:CompanyID ,'-' )"/></taxpayerId>
                                        <vatCode><xsl:value-of select="substring-before(substring-after( ./cbc:CompanyID ,'-' ),'-')"/></vatCode>
                                        <countyCode><xsl:value-of select="substring-after(substring-after( ./cbc:CompanyID ,'-' ),'-')"/></countyCode>
                                </xsl:if>
</xsl:template>


<xsl:template match="cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'GROUPVAT']">
                                <xsl:if test="position() = 1">
                                        <taxpayerId><xsl:value-of select="substring-before( ./cbc:CompanyID ,'-' )"/></taxpayerId>
                                        <vatCode><xsl:value-of select="substring-before(substring-after( ./cbc:CompanyID ,'-' ),'-')"/></vatCode>
                                        <countyCode><xsl:value-of select="substring-after(substring-after( ./cbc:CompanyID ,'-' ),'-')"/></countyCode>
                                </xsl:if>
</xsl:template>

<xsl:template match="cbc:BlockName"><building><xsl:value-of select="substring(.,1,50)"/></building></xsl:template>


<xsl:template match="cac:PostalAddress">

                                        <xsl:choose>
                                             <xsl:when test="cbc:StreetName !='' and cbc:AdditionalStreetName !=''  ">
                                                          <detailedAddress>
                                                                  <countryCode><xsl:value-of select="cac:Country/cbc:IdentificationCode"/></countryCode>
                                                                  <postalCode><xsl:value-of select="cbc:PostalZone"/></postalCode>
                                                                  <city><xsl:value-of select="substring(cbc:CityName,1,255)"/></city>
                                                                  <streetName><xsl:value-of select="substring(cbc:StreetName,1,255)"/></streetName>
                                                                  <publicPlaceCategory><xsl:value-of select="substring(cbc:AdditionalStreetName,1,50)"/></publicPlaceCategory>
                                                                  <number><xsl:value-of select="substring(cbc:BuildingNumber,1,50)"/></number>
                                                                  <xsl:if test="string(cbc:BlockName)"><building><xsl:value-of select="substring(cbc:BlockName,1,50)"/></building></xsl:if>
                                                                  <xsl:if test="string(cbc:Floor)"><floor><xsl:value-of select="substring(cbc:Floor,1,50)"/></floor></xsl:if>
                                                                  <xsl:if test="string(cbc:Room)"><door><xsl:value-of select="substring(cbc:Room,1,50)"/></door></xsl:if>
                                                          </detailedAddress>
                                              </xsl:when>
                                              <xsl:otherwise>
                                                          <simpleAddress>
                                                                  <countryCode><xsl:value-of select="cac:Country/cbc:IdentificationCode"/></countryCode>
                                                                  <postalCode><xsl:value-of select="cbc:PostalZone"/></postalCode>
                                                                  <city><xsl:value-of select="substring(cbc:CityName,1,255)"/></city>
                                                                  <additionalAddressDetail>
                                                                      <xsl:value-of select="translate(substring(cac:AddressLine/cbc:Line,1,255),'&#10;&#13;','  ')"/>
                                                                  </additionalAddressDetail>
                                                          </simpleAddress>
                                              </xsl:otherwise>
                                        </xsl:choose>
</xsl:template>



<xsl:template match="cac:AccountingSupplierParty">
                        <supplierInfo>

                                <xsl:choose>
                                        <xsl:when test="string(./cac:Party/cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'GROUPVAT']/cbc:CompanyID)">

                                                <xsl:if test="string(./cac:Party/cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'GROUPVAT']/cbc:CompanyID)">
                                                        <supplierTaxNumber><xsl:apply-templates select="./cac:Party/cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'GROUPVAT']"/></supplierTaxNumber>
                                                </xsl:if>

                                                <xsl:if test="string(./cac:Party/cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'VAT']/cbc:CompanyID)">
                                                        <groupMemberTaxNumber><xsl:apply-templates select="./cac:Party/cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'VAT']"/></groupMemberTaxNumber>
                                                </xsl:if>

                                        </xsl:when>

                                        <xsl:otherwise>
                                                <xsl:if test="string(./cac:Party/cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'VAT']/cbc:CompanyID)">
                                                        <supplierTaxNumber><xsl:apply-templates select="./cac:Party/cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'VAT']"/></supplierTaxNumber>
                                                </xsl:if>
                                        </xsl:otherwise>
                                       </xsl:choose>

                                <xsl:if test="string(./cac:Party/cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'EUVAT']/cbc:CompanyID)">
                                        <xsl:apply-templates select="./cac:Party/cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'EUVAT']"/>
                                </xsl:if>
                                <supplierName><xsl:value-of select="substring(./cac:Party/cac:PartyName/cbc:Name,1,512)"/></supplierName>
                                <supplierAddress><xsl:apply-templates select="./cac:Party/cac:PostalAddress"/></supplierAddress>

                                <!-- individualExemption -->
                                <xsl:if test="$param_ACCSET_AAM='true'">
                                        <individualExemption>true</individualExemption>
                                </xsl:if>

                        </supplierInfo>
</xsl:template>

<xsl:template match="cac:AccountingCustomerParty">
                        <customerInfo>
                                <xsl:choose>
                                        <xsl:when test="string(./cac:Party/cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'GROUPVAT']/cbc:CompanyID)">

                                                <xsl:if test="string(./cac:Party/cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'GROUPVAT']/cbc:CompanyID)">
                                                        <customerTaxNumber><xsl:apply-templates select="./cac:Party/cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'GROUPVAT']"/></customerTaxNumber>
                                                </xsl:if>

                                                <xsl:if test="string(./cac:Party/cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'VAT']/cbc:CompanyID)">
                                                        <groupMemberTaxNumber><xsl:apply-templates select="./cac:Party/cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'VAT']"/></groupMemberTaxNumber>
                                                </xsl:if>

                                        </xsl:when>

                                        <xsl:otherwise>
                                                <xsl:if test="string(./cac:Party/cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'VAT']/cbc:CompanyID)">
                                                        <customerTaxNumber><xsl:apply-templates select="./cac:Party/cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'VAT']"/></customerTaxNumber>
                                                </xsl:if>
                                        </xsl:otherwise>
                                </xsl:choose>

                                <xsl:if test="string(./cac:Party/cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'EUVAT']/cbc:CompanyID)">
                                        <xsl:apply-templates select="./cac:Party/cac:PartyTaxScheme[cac:TaxScheme/cbc:ID = 'EUVAT']"/>
                                </xsl:if>
                                <customerName><xsl:value-of select="substring(./cac:Party/cac:PartyName/cbc:Name,1,512)"/></customerName>
                                <customerAddress><xsl:apply-templates select="./cac:Party/cac:PostalAddress"/></customerAddress>
                        </customerInfo>
</xsl:template>


<xsl:template match="cac:InvoiceLine">
                        <line>
                                <lineNumber>
                                        <xsl:call-template name="trim">
                                                <xsl:with-param name="str" select="./cbc:ID"/>
                                        </xsl:call-template>
                                </lineNumber>


                                <xsl:if test="./cac:BillingReference/cac:BillingReferenceLine/cbc:ID !='' and /inv:Invoice/cac:BillingReference/cac:InvoiceDocumentReference/cbc:ID !='' ">
                                        <lineModificationReference>
                                                <lineNumberReference>
                                                	<!--	<xsl:value-of select="./cac:BillingReference/cac:BillingReferenceLine/cbc:ID"/> -->
                                                       <xsl:call-template name="trim">
                                                                <xsl:with-param name="str" select="./cac:BillingReference/cac:BillingReferenceLine/cbc:ID"/>
                                                       </xsl:call-template>
                                                </lineNumberReference>
                                                <lineOperation>CREATE</lineOperation>
                                        </lineModificationReference>
                                </xsl:if>

                                <advanceIndicator><xsl:value-of select="cbc:AdvanceIndicator"/></advanceIndicator>
                                <lineExpressionIndicator>true</lineExpressionIndicator>
                                <lineDescription><xsl:value-of select="translate(substring(cac:Item/cbc:Name,1,255),'&#10;&#13;','  ')"/></lineDescription>
                                <quantity><xsl:value-of select="format-number(cbc:InvoicedQuantity,'#.000000')"/></quantity>
                                <unitOfMeasure><xsl:value-of select="cbc:InvoicedQuantity/@unitCode"/></unitOfMeasure>

                                <xsl:if test="./cbc:OwnUnitCode">
                                    <unitOfMeasureOwn><xsl:value-of select="cbc:OwnUnitCode"/></unitOfMeasureOwn>
                                </xsl:if>

                                <unitPrice><xsl:value-of select="format-number(cac:Price/cbc:PriceAmount,'#.000000')"/></unitPrice>
                                <lineAmountsNormal>
                                        <lineNetAmount><xsl:value-of select="format-number(cbc:LineExtensionAmount,'0.##')"/></lineNetAmount>
                                        <lineVatRate>
                                                <vatPercentage><xsl:value-of select="cac:Item/cac:ClassifiedTaxCategory/cbc:Percent div 100"/></vatPercentage>
                                        </lineVatRate>
                                    <lineVatAmount><xsl:value-of select="format-number(cac:TaxTotal/cbc:TaxAmount,'0.##')"/></lineVatAmount>
                                        <!-- <lineVatAmountHUF><xsl:value-of select="cac:TaxTotal/cbc:TaxAmount[@currencyID = 'HUF']"/></lineVatAmountHUF> -->
                                        <lineGrossAmountNormal><xsl:value-of select="format-number(cbc:LineExtensionAmount + cac:TaxTotal/cbc:TaxAmount, '#.00')"/></lineGrossAmountNormal>
                                </lineAmountsNormal>

                        </line>
</xsl:template>

<xsl:template match="cac:TaxSubtotal">
                                <summaryByVatRate>
                                        <vatRate>
                                                <vatPercentage><xsl:value-of select="cbc:Percent div 100"/></vatPercentage>
                                        </vatRate>
                                        <vatRateNetAmount><xsl:value-of select="format-number(cbc:TaxableAmount,'0.##')"/></vatRateNetAmount>
                                        <vatRateVatAmount><xsl:value-of select="format-number(cbc:TaxAmount, '0.##')"/></vatRateVatAmount>
                                        <vatRateGrossAmount><xsl:value-of select="format-number(cbc:TaxableAmount + cbc:TaxAmount, '0.##')"/></vatRateGrossAmount>
                                </summaryByVatRate>
</xsl:template>


<xsl:template match="/">

 <Invoice xmlns:xs="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://schemas.nav.gov.hu/OSA/1.0/data" xs:schemaLocation="http://schemas.nav.gov.hu/OSA/1.0/data invoiceData_20180110.xsd">
        <xsl:if test="$param_TECHNICAL_ANNULMENT='false'">
        <invoiceExchange>

                <xsl:if test="/inv:Invoice/cac:BillingReference[cac:InvoiceDocumentReference/cbc:ID != '']">
                        <xsl:apply-templates select="/inv:Invoice/cac:BillingReference"/>
                </xsl:if>

                <invoiceHead>

                        <xsl:apply-templates select="/inv:Invoice/cac:AccountingSupplierParty"/>
                        <xsl:apply-templates select="/inv:Invoice/cac:AccountingCustomerParty"/>

                        <invoiceData>
                                <invoiceNumber><xsl:value-of select="substring(/inv:Invoice/cbc:ID,1,50)"/></invoiceNumber>
                                <invoiceCategory>
                                        <xsl:choose>
                                                <xsl:when test="/inv:Invoice/cbc:InvoiceTypeCode = 'SummaryInvoice'">AGGREGATE</xsl:when>
                                                <xsl:otherwise>NORMAL</xsl:otherwise>
                                        </xsl:choose>
                                </invoiceCategory>
                                <invoiceIssueDate><xsl:value-of select="/inv:Invoice/cbc:IssueDate"/></invoiceIssueDate>
                                <invoiceDeliveryDate><xsl:value-of select="/inv:Invoice/cbc:TaxPointDate"/></invoiceDeliveryDate>

                                <xsl:if test="/inv:Invoice/cac:InvoicePeriod/cbc:StartDate">
                                	<invoiceDeliveryPeriodStart><xsl:value-of select="/inv:Invoice/cac:InvoicePeriod/cbc:StartDate"/></invoiceDeliveryPeriodStart>
                                </xsl:if>

                                <xsl:if test="/inv:Invoice/cac:InvoicePeriod/cbc:EndDate">
                                	<invoiceDeliveryPeriodEnd><xsl:value-of select="/inv:Invoice/cac:InvoicePeriod/cbc:EndDate"/></invoiceDeliveryPeriodEnd>
                                </xsl:if>


                                <currencyCode><xsl:value-of select="/inv:Invoice/cbc:DocumentCurrencyCode"/></currencyCode>
                                <exchangeRate>
                                        <xsl:value-of select="/inv:Invoice/cac:TaxExchangeRate/cbc:CalculationRate"/>
                                </exchangeRate>

                                <xsl:if test="$param_ACCSET_SELF_BILLING='true'">
                                    <selfBillingIndicator>true</selfBillingIndicator>
                                </xsl:if>

                                <paymentMethod>
                                        <xsl:choose>
                                                <xsl:when test="/inv:Invoice/cac:PaymentMeans/cbc:PaymentMeansCode = '10'">CASH</xsl:when>
                                                <xsl:when test="/inv:Invoice/cac:PaymentMeans/cbc:PaymentMeansCode = '20'">VOUCHER</xsl:when>
                                                <xsl:when test="/inv:Invoice/cac:PaymentMeans/cbc:PaymentMeansCode = '30'">TRANSFER</xsl:when>
                                                <xsl:when test="/inv:Invoice/cac:PaymentMeans/cbc:PaymentMeansCode = '48'">CARD</xsl:when>
                                                <xsl:otherwise>OTHER</xsl:otherwise>
                                        </xsl:choose>
                                </paymentMethod>
                                <paymentDate><xsl:value-of select="/inv:Invoice/cbc:DueDate"/></paymentDate>
                                <!-- cashAccountingIndicator - Penzforgalmi elszamolas: Hol lesz tárolva? EBIZ=ACCSET1 -->
                                <xsl:if test="$param_ACCSET_PFA='true'">
                                        <cashAccountingIndicator>true</cashAccountingIndicator>
                                </xsl:if>
                                <invoiceAppearance>
                                        <xsl:choose>
                                                <xsl:when test="/inv:Invoice/cbc:Note[1] = 'ELECTRONIC'">ELECTRONIC</xsl:when>
                                                <xsl:when test="/inv:Invoice/cbc:Note[1] = 'PAPER'">PAPER</xsl:when>
                                                <xsl:when test="/inv:Invoice/cbc:Note[1] = 'EDI'">EDI</xsl:when>
                                                <xsl:otherwise>UNKNOWN</xsl:otherwise>
                                        </xsl:choose>
                                </invoiceAppearance>
                        </invoiceData>
                </invoiceHead>
                <invoiceLines><xsl:apply-templates select="/inv:Invoice/cac:InvoiceLine"/></invoiceLines>
                <invoiceSummary>
                        <summaryNormal>
                                <xsl:apply-templates select="/inv:Invoice/cac:TaxTotal/cac:TaxSubtotal"/>
                                <invoiceNetAmount><xsl:value-of select="format-number(/inv:Invoice/cac:LegalMonetaryTotal/cbc:TaxExclusiveAmount,'0.##')"/></invoiceNetAmount>
                                <invoiceVatAmount><xsl:value-of select="format-number(/inv:Invoice/cac:TaxTotal/cbc:TaxAmountInOriginalCurrency,'0.##')"/></invoiceVatAmount>
                                <invoiceVatAmountHUF><xsl:value-of select="format-number(/inv:Invoice/cac:TaxTotal/cbc:TaxAmount,'0.##')"/></invoiceVatAmountHUF>
                        </summaryNormal>
                        <invoiceGrossAmount><xsl:value-of select="format-number(/inv:Invoice/cac:LegalMonetaryTotal/cbc:TaxInclusiveAmount,'0.##')"/></invoiceGrossAmount>
                </invoiceSummary>
        </invoiceExchange>
        </xsl:if>
        <xsl:if test="$param_TECHNICAL_ANNULMENT='true'">
            <invoiceAnnulment>
                <annulmentReference><xsl:value-of select="/inv:Invoice/cac:InvoiceAnnulmentType/cbc:annulmentReference"/></annulmentReference>
                <annulmentTimestamp><xsl:value-of select="/inv:Invoice/cac:InvoiceAnnulmentType/cbc:annulmentTimestamp"/></annulmentTimestamp>
                <annulmentCode><xsl:value-of select="/inv:Invoice/cac:InvoiceAnnulmentType/cbc:annulmentCode"/></annulmentCode>
                <annulmentReason><xsl:value-of select="/inv:Invoice/cac:InvoiceAnnulmentType/cbc:annulmentReason"/></annulmentReason>
            </invoiceAnnulment>
        </xsl:if>
 </Invoice>

</xsl:template>



</xsl:stylesheet>
