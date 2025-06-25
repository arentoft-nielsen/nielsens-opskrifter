<!DOCTYPE HTML>
<?php
  $adminIP = array('86.58.159.10'); // Array af admin IP'er
  $ip = $_SERVER['REMOTE_ADDR'];

	if (in_array($ip, $adminIP) || (isset($_GET['ShowAll']) && $_GET['ShowAll'])) {
    	$IsAdmin = TRUE;
	} else {
    	$IsAdmin = FALSE;
	}
  
  // Vi overrider lige admin-tjek
  // $IsAdmin = TRUE;
?>
<html>
<head> 
<title>Nielsens opskrifter</title> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="mystyle.css">
<link rel="icon" type="image/png" sizes="16x16" href="./auxfiles/icon-bestik-16.png">
<link rel="icon" type="image/png" sizes="32x32" href="./auxfiles/icon-bestik-32.png">
<link rel="icon" type="image/png" sizes="96x96" href="./auxfiles/icon-bestik-96.png">
</head> 
<body class="ix"> 
<H2>Nielsens opskrifter</H2>

<table>
<tr>
<td><img src="./auxfiles/cooking-man2.png" align="right"></td>
<td><UL>
<li><a href="./Mad/index.php">Middagsretter</a></li>
<li><a href="./Tilbehoer/index.php">Diverse tilbehør</a></li>
<li><a href="./Kage-Dessert/index.php">Kage, dessert, søde ting</a></li>
<li><a href="./Broed/index.php">Brød, müsli</a></li>
<li><a href="./Poelser/index.php">Pølser</a></li>
<li><a href="./Roegning/index.php">Røgning</a></li>
<li><a href="./Drikke/index.php">Drikke</a></li>
<!-- Tilføjes flere grupper, så husk at ændre også i EditRecipe.php -->
</UL></td>
</tr>	
</table>

<?php
if ($IsAdmin === TRUE) {
echo '<table>
<tr>
<td valign="top"><H4>E-bøger:</H4></td>
<td><UL>
<li><a href="./Charcuterie/">Charcuterie - The Craft of Salting, Smoking and Curing</a></li>
<li><a href="./River_Cottage_Curing_Smoking/">The River Cottage Curing &amp; Smoking Handbook</a></li>
<li><a href="./Joy_of_Smoking_Curing/">The Joy of Smoking and Salt Curing</a></li>
<li><a href="./Hunters_Guide_Curing_Smoking/">The Hunter\'s Guide to Butchering, Smoking &amp; Curing Wild Game and Fish</a></li>
</UL></td>
</tr>	
</table>';
}
?>

<BR><BR><BR>

<table border=0>
<tr><td><a href="DoRecipe.php"><IMG src="./auxfiles/_active__copy.png"></a></td><td>Du kan <a href="DoRecipe.php">gemme nye opskrifter</a> herfra</td></tr>
<tr><td><a href="./search/search.php"><IMG src="./auxfiles/_active__preview.png"></a></td><td>Du kan <a href="./search/search.php">søge i opskrifterne</a> her</td></tr>
<tr><td></td><td><font size="-1">(og dokumenter kan lægges i søgeindeks <a href="./search/index.php">her</a>, hvis der er kommet nye til)</font></td></tr>
<tr><td><a href="deleteRecipe.php"><IMG src="./auxfiles/app_delete.png"></a></td><td>Du kan <a href="deleteRecipe.php">slette</a> en opskrift her</td></tr>
</table>

</body> 
</html> 

