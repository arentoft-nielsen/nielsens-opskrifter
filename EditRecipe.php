<html>
	<head>
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
		<style type="text/css">
			body { font-family: Arial, Helvetica, Geneva, Swiss; font-size: 12pt; color: white; background-color: #C91611; margin-left: 70pt; margin-right: 50pt }
			A { color: yellow }
			A:LINK  { color : #FFFF80; text-decoration: none; font-weight: bold; }
			A:VISITED  { color : #FFFF80; text-decoration: none; font-weight: bold  }
			A:HOVER  { color : yellow; text-decoration: underline; font-weight: bold }
		</style>
		<link rel="icon" type="image/png" sizes="16x16" href="./auxfiles/icon-bestik-16.png">
		<link rel="icon" type="image/png" sizes="32x32" href="./auxfiles/icon-bestik-32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="./auxfiles/icon-bestik-96.png">
	</head>
<body>
	
<?php
// hvilken xml kommer kaldet fra - den skal redigeres
$referer = $_SERVER['HTTP_REFERER'];
$reffile = get_string_after_first($referer,'/Opskrifter/');
$xml = file_get_contents('./'.$reffile);
// Sæt kategorien
$mselect = $tselect = $kselect = $bselect = $pselect = $rselect = $dselect = '';  // Sæt lige alle variabler her til nulstreng, så de ikke-valgte ikke trigger fejl
if (strstr($referer, 'Opskrifter/Mad')) { $mselect = " selected"; }
elseif (strstr($referer, 'Opskrifter/Tilbehoer')) { $tselect = " selected"; }
elseif (strstr($referer, 'Opskrifter/Kage-Dessert')) { $kselect = " selected"; }
elseif (strstr($referer, 'Opskrifter/Broed')) { $bselect = " selected"; }
elseif (strstr($referer, 'Opskrifter/Poelser')) { $pselect = " selected"; }
elseif (strstr($referer, 'Opskrifter/Drikke')) { $dselect = " selected"; }
elseif (strstr($referer, 'Opskrifter/Roegning')) { $rselect = " selected"; }
// Hent indhold
$name = get_string_between($xml,"<navn>","</navn>");
$ings = get_string_between($xml,"<ingredienser>","</ingredienser>");
$ingArr = explode("\n", $ings); $ings = ''; foreach ($ingArr as $i) { $i = get_string_between($i,"<ing>","</ing>"); $i=preg_replace('/\s+/', ' ', $i); $ings = $ings."\r\n".$i; } $ings = trim($ings);
$subhead = get_string_between($xml,"<subheader>","</subheader>");
$ings2 = get_string_between($xml,"<ingredienser2>","</ingredienser2>");
$ingArr2 = explode("\n", $ings2); $ings2 = ''; foreach ($ingArr2 as $i) { $i = get_string_between($i,"<ing>","</ing>"); $i=preg_replace('/\s+/', ' ', $i); $ings2 = $ings2."\r\n".$i; } $ings2 = trim($ings2);
$meth = get_string_between($xml,"<metode>","</metode>");
$meths = explode("\n", $meth); $meth = ''; foreach ($meths as $i) { $i = get_string_between($i,"<met>","</met>"); $i=preg_replace('/\s+/', ' ', $i); $meth = $meth."\r\n\r\n".$i; } $meth = trim($meth);
$tip = get_string_between($xml,"<tips>","</tips>");
$tips = explode("\n", $tip); $tip = ''; foreach ($tips as $i) { $i = get_string_between($i,"<tip>","</tip>"); $i=preg_replace('/\s+/', ' ', $i); $tip = $tip."\r\n\r\n".$i; } $tip = trim($tip);


echo '
<H2>Rediger</H2>
 <form accept-charset="UTF-8" action="DoRecipe.php" method="post">
 
 
 <B>Opskriftsgruppe:</B><BR/>
 <select name="gruppe">
   <option value="middag"'.$mselect.'>Middagsretter</option>
   <option value="tilbehoer"'.$tselect.'>Diverse tilbehør</option>
   <option value="kage"'.$kselect.'>Kage, dessert, søde ting</option>
   <option value="broed"'.$bselect.'>Brød, müsli</option>
   <option value="poelser"'.$pselect.'>Pølser</option>
   <option value="roegning"'.$rselect.'>Røgning</option>
   <option value="drikke"'.$dselect.'>Drikke</option>
</select>

<BR/><BR/>

 <input type="hidden" name="FormOut" value="1">
 <p><B>Opskriftens titel: <input type="text" name="title" size="25" value="'.$name.'" /></B></p>

 <B>Liste med ingredienser (1 pr. linje):</B><BR/>
 <textarea rows="12" cols="50" name="ingredients">'.$ings.'</textarea>

<BR/><BR/>

 <B>Undergruppe af ingredienser (1 pr. linje):</B><BR/>
 Underoverskrift: <input type="text" name="subheader" size="25" value="'.$subhead.'" /><BR/>
 <textarea rows="4" cols="50" name="subingredients">'.$ings2.'</textarea>

<BR/><BR/>

 <B>Fremgangsmåde (hver sekvens adskilt af 2 linjeskift):</B><BR/>
 <textarea rows="12" cols="100" name="metode">'.$meth.'</textarea>

<BR/><BR/>

 <B>Tips (adskilt af 2 linjeskift):</B><BR/>
 <textarea rows="3" cols="100" name="tips">'.$tip.'</textarea>

 <p><input type= "submit" value="Gem opskrift" /></p>
</form>';

function get_string_between($string, $start, $end) {
	$string = " ".$string;
	$ini = strpos($string,$start);
	if ($ini == 0) return "";
	$ini += strlen($start);
	$len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}

// Gets the substring after the first occurrence of a separator. If no match for separator is found returns false.
function get_string_after_first($string, $separator) {
	$firstpos = mb_strpos($string, $separator, 0, 'UTF-8');
	if ($firstpos === false) { return false; }
	return mb_substr($string, $firstpos + mb_strlen($separator, 'UTF-8'), null, 'UTF-8');
}

?>

<BR><BR><A class="editlink" href="/Opskrifter/index.php">Hjem</A>

</body></html>