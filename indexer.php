<?php
  $adminIP = array('2.110.111.60','86.58.159.10'); // Array af admin IP'er
  $ip = $_SERVER['REMOTE_ADDR'];
  if (in_array($ip, $adminIP)) { $IsAdmin = TRUE; } else { $IsAdmin = FALSE; }
  // Vi overrider lige admin-tjek
  // $IsAdmin = TRUE;
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 

<html>
<head> 
<title>Nielsens opskrifter</title> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="image/png" sizes="16x16" href="../auxfiles/icon-bestik-16.png" />
		<link rel="icon" type="image/png" sizes="32x32" href="../auxfiles/icon-bestik-32.png" />
		<link rel="icon" type="image/png" sizes="96x96" href="../auxfiles/icon-bestik-96.png" />
<link rel="stylesheet" type="text/css" href="../mystyle.css">
</head> 

<body class="ix"> 
<table border=0>
<tr><td><A HREF="../index.php"><H2>Nielsens opskrifter</H2></A>

<?php
$dirname="."; 
$dh = opendir($dirname) or die ("Could not open this directory");
$dirFiles = array();

while (!(($file = readdir($dh)) === false )) {
//  if (is_dir("$dirname/$file"))
//  print "";
  if (preg_match("/(txt|pdf|html|xml|doc)/i", $file, $array )) {
  	$info = new SplFileInfo($file);
  	if ($info->getExtension() == 'xml') {
  		$title = get_string_between(file_get_contents($file),'<navn>','</navn>');
  	} else {
  		$title = $file;
  	}
    // $filesize = formatbytes("$file", "KB");  	
    // $dirFiles[] = "<A HREF=\"$file\">$title</A> ($filesize)<br><br>";
    
    $dirFiles[$title] = "<A HREF=\"$file\">$title</A> <br><br>";
  } else {
//    print "";
  }
}
closedir($dh);

// natcasesort($dirFiles);
setlocale(LC_COLLATE, 'da_DA');
ksort($dirFiles, SORT_LOCALE_STRING);
foreach($dirFiles as $entry) {
    echo "$entry\n";
}


function get_string_between($string, $start, $end) {
	$string = " ".$string;
	$ini = strpos($string,$start);
	if ($ini == 0) return "";
	$ini += strlen($start);
	$len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}

function formatbytes($file, $type) {
    switch($type) {
        case "KB":
            $filesize = filesize($file) * .0009765625; // bytes to KB
        break;
        case "MB":
            $filesize = (filesize($file) * .0009765625) * .0009765625; // bytes to MB
        break;
        case "GB":
            $filesize = ((filesize($file) * .0009765625) * .0009765625) * .0009765625; // bytes to GB
        break;
    }
    if ($filesize <= 0) {
        return $filesize = 'unknown file size';
    } else {
    	return round($filesize, 2).' '.$type;
    }
}

echo '</td><td valign="top">&nbsp;&nbsp;&nbsp;<img src="'.$vignet.'"></td></tr></table>';

?> 


<hr width="50%" align="left">
<A class="xlink" href="../index.php">Hjem</A> | <A class="xlink" href="../search/search.php">Søgning</A>

</body>
</html> 

