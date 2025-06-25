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

if (isset($_POST["URL"])) {  // Modtager indhold fra formular
	$authCode = $_POST["authcode"];
  if ($authCode == '1928') {
  	$shortFile = get_string_after_first($_POST["URL"], '/Opskrifter/');
  	echo "Sletter opskriftsfilen $shortFile...";
  	unlink('./'.$shortFile); // Sletter den angivne fil
  	// rename('./'.$shortFile, './deleted_files/'.$shortFile); // Flytter filen til deleted_files mappen
  	// echo "renamer ".'./'.$shortFile.'|||'.'/deleted_files/'.$shortFile;
  	echo '<BR><BR><A class="editlink" href="/Opskrifter/index.php">Hjem</A>';
  } else {
  	echo '<b>Forkert eller manglende godkendelseskode!</b><BR><BR><a href="javascript:history.go(-1)">[Tilbage]</a>';
  
  }
} else {  // plain kald - vis formular
 echo '<H2>Slet opskrift</H2>
 <form accept-charset="UTF-8" action="deleteRecipe.php" method="post" autocomplete="off">
 
 
 <B>Web-adresse på opskrift (kopiér fra browserens adresselinje):</B><BR/>
 <input type="text" name="URL" size="75"/><BR/><BR/>
 
 <B>Godkendelseskode:</B><BR/>
 <input type="text" name="authcode" size="5"/>

 <p><input type= "submit" value="Slet opskrift" /></p>
</form><BR><BR>';
 echo '<BR><BR><A class="editlink" href="/Opskrifter/index.php">Hjem</A>';
}


// Gets the substring after the first occurrence of a separator. If no match for separator is found returns false.
function get_string_after_first($string, $separator) {
	$firstpos = mb_strpos($string, $separator, 0, 'UTF-8');
	if ($firstpos === false) { return false; }
	return mb_substr($string, $firstpos + mb_strlen($separator, 'UTF-8'), null, 'UTF-8');
}
?>

</body></html>