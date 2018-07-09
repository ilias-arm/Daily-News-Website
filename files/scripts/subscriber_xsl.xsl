<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" >
<xsl:output method = "html"/>
<xsl:template match="/">
<body>
    <!-- Αν το element list_sindromiti περιέχει ένα ή περισσότερα στοιχεία, δηλαδή υπάρχουν συνδρομητές-->
    <xsl:if test = "count(/lista_sindromiti/sindromitis) &gt; 0">
        <!-- Δημιουργούμε table -->
        <table id="xml_table">
            <tr style="background-color: #777">
                <!-- Μετράμε με τη συνάρτηση "count" πόσα element sindromitis περιέχει το element lista_sindromiti -->
                <td><b><p style="color: #f2f2f2">Σύνολο συνδρομητών: <xsl:value-of select="count(lista_sindromiti/sindromitis)"/></p></b></td>
            </tr>    
            <!-- Για κάθε συνδρομητή -->
            <xsl:for-each select="lista_sindromiti/sindromitis">
            <tr style="background-color: #777">
                <!-- Εμφανίζουμε το ονοματεπώνυμο του -->
                <td><p style="color: #f2f2f2">Όνοματεπώνυμο: <xsl:value-of select="stoixeia_sindromiti/eponimo"/><xsl:text> </xsl:text><xsl:value-of select="stoixeia_sindromiti/onoma"/></p></td>
            </tr>
                <!-- Για κάθε κατηγορία του συνδρομητή -->
                <xsl:for-each select="sindromi/katigories_sindromiti">
                <tr>
                    <!-- Εμφανίζουμε το όνομα της -->
                    <td><p style="color: #800000">Κατηγορία: <xsl:value-of select="stoixeia_katigorias/titlos"/></p></td>
                </tr>
                </xsl:for-each>
            <tr>
                <!-- Και εμφανίζουμε και το ετήσιο κόστος του συνδρομητή -->
                <td><p style="color: #000099">Ετήσιο κόστος: <xsl:value-of select="etisio_kostos/timi"/></p></td>
            </tr>
            </xsl:for-each>
        </table>
    </xsl:if>
</body>
</xsl:template>
</xsl:stylesheet>