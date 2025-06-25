<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/">
  <html>
	<head>
		<title>Opskrift :: <xsl:value-of select="DOC/navn"/></title>
		<link rel="stylesheet" type="text/css" href="/Opskrifter/mystyle.css"/>
	</head>
  <body style="padding:15px; width:210mm; margin-left:auto; margin-right:auto; background-color: #FFF; color: #000;">
  <H3 class="udskriv"><xsl:value-of select="DOC/navn"/></H3>

    <div>
        <div class="subheading">Ingredienser:</div>
        <ul>
     			<xsl:for-each select="DOC/ingredienser/ing">
            <li class="ingredient"><xsl:value-of select="."/></li>
     			</xsl:for-each>
        </ul>
   			<xsl:if test="DOC/ingredienser2">
   				<ul>
   				<lh><B><xsl:value-of select="DOC/ingredienser2/subheader"/>:</B></lh>
     			<xsl:for-each select="DOC/ingredienser2/ing">
            <li class="ingredient"><xsl:value-of select="."/></li>
     			</xsl:for-each>
   				</ul>
   			</xsl:if>
    </div>
    
   <BR/>

    <div width="500px">
        <div class="subheading">Fremgangsmåde:</div>
        <ol>
     			<xsl:for-each select="DOC/metode/met">
            <li class="method"><xsl:value-of select="."/></li>
     			</xsl:for-each>
        </ol>
    </div>
    
   <xsl:if test="DOC/tips">
    <div>
        <div class="subheading">Tips:</div>
        <ul class="nobullet">
     			<xsl:for-each select="DOC/tips/tip">
            <li class="method"><xsl:value-of select="."/></li>
     			</xsl:for-each>
        </ul>
    </div>
   </xsl:if>

   </body>
   </html>
</xsl:template>

</xsl:stylesheet>