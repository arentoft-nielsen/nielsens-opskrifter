<?php
$referer = $_SERVER['HTTP_REFERER']; $dk = strpos($referer,".dk/Opskrifter/"); $reffile = substr($referer, $dk+15);
$xml = file_get_contents($reffile);
$xml = str_replace("<?xml-stylesheet type='text/xsl' href='../viewxml.xsl'?>","<?xml-stylesheet type='text/xsl' href='printxml.xsl'?>",$xml);

// Skriv til en temp-fil
$fp = fopen('tempPrint.xml', "w");
$fwrite = fwrite($fp, $xml);
fclose($fp);

usleep(200);

// .. som formateres med hvid baggrund og sort skrift
header("Location: tempPrint.xml");
die();
?>
