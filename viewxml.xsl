<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0"
 xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/">
  <html>
	<head>
		<title>Opskrift :: <xsl:value-of select="DOC/navn"/></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="icon" type="image/png" sizes="16x16" href="/Opskrifter/auxfiles/icon-bestik-16.png" />
		<link rel="icon" type="image/png" sizes="32x32" href="/Opskrifter/auxfiles/icon-bestik-32.png" />
		<link rel="icon" type="image/png" sizes="96x96" href="/Opskrifter/auxfiles/icon-bestik-96.png" />
		<link rel="stylesheet" type="text/css" href="/Opskrifter/mystyle.css"/>
		<link rel="stylesheet" type="text/css" href="/Opskrifter/wl-switch.css"/>
	</head>
  <body>
  <H3><xsl:value-of select="DOC/navn"/></H3>
	
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

    <div>
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
            <xsl:choose>
            	<xsl:when test="starts-with(.,'http')"><xsl:variable name="url" select="."></xsl:variable><li class="method"><A href="{$url}" class="tiplink" target="_blank"><xsl:value-of select="."></xsl:value-of></A></li>
            	</xsl:when>
            	<xsl:otherwise><li class="method"><xsl:value-of select="."></xsl:value-of></li>
            	</xsl:otherwise>
            </xsl:choose>
     			</xsl:for-each>
        </ul>
    </div>
   </xsl:if>

	<div id="theSwitch"><table border="0"><tr><td valign="middle"><label class="switch"><input type="checkbox" id="toggleSwitch" /><span class="slider round"></span></label></td><td valign="middle"><font class="wakelock"> Hold skærmen tændt</font></td></tr></table></div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const switchElement = document.getElementById('theSwitch');
    if ('wakeLock' in navigator) {
      switchElement.style.display = 'inline-block';
    } else {
      switchElement.style.display = 'none';
    }
  });
</script>
	
	<BR/><BR/>
	<A class="editlink" href="/Opskrifter/index.php">Hjem</A> | <A class="editlink" href="index.php">Oversigt for emnet</A> | <A class="editlink" href="/Opskrifter/EditRecipe.php">Rediger</A> | <A class="editlink" href="/Opskrifter/doPrint.php">Udskriftsvenlig udgave</A>

  <script>
    let wakeLock = null;

    function requestWakeLock() {
      if ('wakeLock' in navigator) {
        // Request a screen wake lock
        navigator.wakeLock.request('screen').then((lock) => {
          wakeLock = lock;
          console.log('Screen wake lock activated');
        }).catch((err) => {
          console.error('Failed to activate wake lock: ', err);
        });
      } else {
        console.warn('Wake Lock API is not supported.');
      }
    }

    function releaseWakeLock() {
      if (wakeLock !== null) {
        wakeLock.release().then(() => {
          console.log('Screen wake lock released');
        }).catch((err) => {
          console.error('Failed to release wake lock: ', err);
        });
        wakeLock = null;
      }
    }

    // Event listener for switch toggle
    document.getElementById('toggleSwitch').addEventListener('change', function() {
      if (this.checked) {
        requestWakeLock();
      } else {
        releaseWakeLock();
      }
    });
  </script>

   </body>
   </html>
</xsl:template>

</xsl:stylesheet>