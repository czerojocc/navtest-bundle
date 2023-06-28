<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:xs="http://www.w3.org/2001/XMLSchema"
                xmlns="http://schemas.nav.gov.hu/OSA/3.0/annul"
                exclude-result-prefixes="xs"
>
    <xsl:output method="xml" encoding="utf-8" indent="yes" xslt:indent-amount="4"
                xmlns:xslt="http://xml.apache.org/xslt"/>

    <xsl:template match="/">
        <InvoiceAnnulment xmlns="http://schemas.nav.gov.hu/OSA/3.0/annul"
                          xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                          xsi:schemaLocation="http://schemas.nav.gov.hu/OSA/3.0/annul invoiceAnnulment.xsd">
            <annulmentReference>
                <xsl:value-of select="//BavInvoice/InvoiceAnnulmentType/annulmentReference"/>
            </annulmentReference>
            <annulmentTimestamp>
                <xsl:value-of select="//BavInvoice/InvoiceAnnulmentType/annulmentTimestamp"/>
            </annulmentTimestamp>
            <annulmentCode>
                <xsl:value-of select="//BavInvoice/InvoiceAnnulmentType/annulmentCode"/>
            </annulmentCode>
            <annulmentReason>
                <xsl:value-of select="//BavInvoice/InvoiceAnnulmentType/annulmentReason"/>
            </annulmentReason>
        </InvoiceAnnulment>
    </xsl:template>
</xsl:stylesheet>
