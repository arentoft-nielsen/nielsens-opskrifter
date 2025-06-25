<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>

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

if (isset($_POST['FormOut'])) {

$xmlstr = "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>
<?xml-stylesheet type='text/xsl' href='../viewxml.xsl'?>
<DOC>
</DOC>";

$DOC = new SimpleXMLElement($xmlstr);

$DOC->navn = trim($_POST['title']);

$form_ing = $_POST['ingredients'];
$arr_ing = explode("\r\n",$form_ing);
foreach($arr_ing as $ing) {
	  $ing = str_replace("\r\n"," ",$ing);
	  if (trim($ing) != '') $DOC->ingredienser->ing[] = trim($ing);
}

$form_ing = $_POST['subingredients'];
if ($form_ing !== '') {
  $DOC->ingredienser2->subheader = trim($_POST['subheader']);
  $arr_ing = explode("\r\n",$form_ing);
  foreach($arr_ing as $ing) {    
	  $ing = str_replace("\r\n"," ",$ing);
    if (trim($ing) != '') $DOC->ingredienser2->ing[] = trim($ing);
  }
}

$form_met = $_POST['metode'];
$arr_met = explode("\r\n\r\n",$form_met);
foreach($arr_met as $met) {
	  $met = str_replace("\r\n"," ",$met);
    if (trim($met) != '') $DOC->metode->met[] = trim($met);
}

$form_tip = $_POST['tips'];
if ($form_tip !== '') {
  $arr_tip = explode("\r\n\r\n",$form_tip);
  foreach($arr_tip as $tip) {
	  $tip = str_replace("\r\n"," ",$tip);
    if (trim($tip) != '') $DOC->tips->tip[] = trim($tip);
  }
}


if ($_POST['gruppe'] == 'drikke') {
	$path = "./Drikke/";
} elseif ($_POST['gruppe'] == 'kage') {
	$path = "./Kage-Dessert/";
} elseif ($_POST['gruppe'] == 'broed') {
	$path = "./Broed/";
} elseif ($_POST['gruppe'] == 'poelser') {
	$path = "./Poelser/";
} elseif ($_POST['gruppe'] == 'roegning') {
	$path = "./Roegning/";
} elseif ($_POST['gruppe'] == 'tilbehoer') {
	$path = "./Tilbehoer/";
} else {
	$path = "./Mad/";
}

$filename = strtolower(trim($_POST['title']));
$sArr = array("æ","ø","å","Æ","Ø","Å"," ","ö","ü","é","è","/");
$rArr = array("ae","oe","aa","ae","oe","aa","_","oe","ue","e","e","_");
$filename = str_replace($sArr,$rArr,$filename).".xml";

//Format XML to save indented tree rather than one line
$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($DOC->asXML());


if (!strstr($_SERVER['HTTP_REFERER'],'EditRecipe.php') & file_exists($path.$filename)) {
	echo "<H3>Filnavnet ".$path.$filename." eksisterer allerede.<BR><BR>Afbryder...</H3>";
	exit;
} else {
  $dom->save($path.$filename);
  // $DOC->saveXML($path.$filename);
  echo '<H2>Opskrift på '.$_POST['title'].' er nu gemt</H2>Du kan se resultatet her: <A HREF="'.$path.$filename.'">'.$_POST['title'].'</A>';
  echo "\n<BR><BR>\n";
  echo "Indtast ny opskrift <A HREF=\"/Opskrifter/DoRecipe.php\">her</A>";
}


} else {

echo'
<H2>Opret opskrift</H2>
 <form accept-charset="UTF-8" action="DoRecipe.php" method="post">
 
 
 <B>Opskriftsgruppe:</B><BR/>
 <select name="gruppe">
   <option value="middag" selected>Middagsretter</option>
   <option value="tilbehoer">Diverse tilbehør</option>
   <option value="kage">Kage, dessert, søde ting</option>
   <option value="broed">Brød, müsli</option>
   <option value="poelser">Pølser</option>
   <option value="roegning">Røgning</option>
   <option value="drikke">Drikke</option>
</select>

<BR/><BR/>

 <input type="hidden" name="FormOut" value="1">
 <p><B>Opskriftens titel: <input type="text" name="title" size="25" /></B></p>

 <B>Liste med ingredienser (1 pr. linje):</B><BR/>
 <textarea rows="12" cols="50" name="ingredients"></textarea>

<BR/><BR/>

 <B>Undergruppe af ingredienser (1 pr. linje):</B><BR/>
 Underoverskrift: <input type="text" name="subheader" size="25" /><BR/>
 <textarea rows="4" cols="50" name="subingredients"></textarea>

<BR/><BR/>

 <B>Fremgangsmåde (hver sekvens adskilt af 2 linjeskift):</B><BR/>
 <textarea rows="12" cols="100" name="metode"></textarea>

<BR/><BR/>

 <B>Tips (adskilt af 2 linjeskift):</B><BR/>
 <textarea rows="3" cols="100" name="tips"></textarea>

 <p><input type= "submit" value="Gem opskrift" /></p>
</form>';

}
?>

<BR><BR><A href="/Opskrifter/index.php">Hjem</A>


</body></html>