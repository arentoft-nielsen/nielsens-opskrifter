<html>
<head> 
<title>Nielsens opskrifter</title> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../mystyle.css">
</head> 
<body class="ix"> 
<H2>Oprettelse af søgeindeks</H2>

<?
error_reporting(E_ALL);

/**
 *           RiSearch PHP
 * 
 * web search engine, version 0.2
 * (c) Sergej Tarasov, 2000-2004
 * 
 * Homepage: http://risearch.org/
 * email: risearch@risearch.org
 */

include "config.php";
include "common_lib.php";

print "Starter indeksering...<BR><BR>\n";


print "\$base_dir: $base_dir<BR>\n";
print "\$base_url: $base_url<HR>\n";

#DEFINE CONSTANTS
$cfn = 0;
$cwn = 0;
$kbcount = 0;

if(!is_dir("db")) {
	mkdir("db",0755) or die("Kan ikke oprette undermappen 'db'!<BR>");
	echo "Undermappen 'db' er oprettet.";
}

$fp_FINFO = fopen ("$FINFO", "wb") or die("Kan ikke åbne indeksfilen FINFO!<BR><BR>");
fwrite($fp_FINFO, "\x0A");
$fp_SITEWORDS = fopen ("$SITEWORDS", "wb") or die("Kan ikke åbne indeksfilen SITEWORDS!<BR><BR>");
$fp_WORD_IND = fopen ("$WORD_IND", "wb") or die("Kan ikke åbne indeksfilen  fileWORD_IND!<BR><BR>");

$time1 = getmicrotime();
scan_files($base_dir);
$time2 = getmicrotime();
$time = round($time2-$time1,2);
print "<BR>Scanning tog $time sek.<BR>";


if ($cfn == 0) {
    print "Ingen filer er blevet indekseret<BR>\n\n";
    die;
}

print "Skriver til SITEWORDS...<BR>\n";
    $pos_sitewords = ftell($fp_SITEWORDS);
    $pos_word_ind  = ftell($fp_WORD_IND);
    $to_print_sitewords = "";
    $to_print_word_ind  = "";
    foreach($words as $word=>$value) {
        $cwn++;
        $words_word_dum = pack("NN",$pos_sitewords+strlen($to_print_sitewords),
    	                        $pos_word_ind+strlen($to_print_word_ind));
    	$to_print_sitewords .= "$word\x0A";
    	$to_print_word_ind .= pack("N",strlen($value)/4).$value;
    	$words[$word] = $words_word_dum;
    	if (strlen($to_print_word_ind) > 32000) {
    	    fwrite($fp_SITEWORDS, $to_print_sitewords);
    	    fwrite($fp_WORD_IND, $to_print_word_ind);
    	    $to_print_sitewords = "";
    	    $to_print_word_ind  = "";
    	    $pos_sitewords = ftell($fp_SITEWORDS);
    	    $pos_word_ind  = ftell($fp_WORD_IND);
    	}

    }
    fwrite($fp_SITEWORDS, $to_print_sitewords);
    fwrite($fp_WORD_IND, $to_print_word_ind);
fclose($fp_SITEWORDS);
fclose($fp_WORD_IND);

print "Bygger indeks...<BR>\n";

build_hash();

print "$cfn filer er blevet indekseret<BR>\n";

#=====================================================================
#
#    Function scan_files ($dir)
#    Last modified: 05.04.2005 16:41
#
#=====================================================================

function  scan_files ($dir) {

    global $base_dir, $base_url, $cfn;
    global $no_index_dir, $file_ext, $cut_default_filenames, $default_filenames, $url_to_lower_case, $no_index_files;

    $dir_h = opendir($dir) or die("Can't open $dir");
    
    while (false !== ($file = readdir($dir_h))) { 
        if ($file != "." && $file != "..") {
            $new_dir = $dir."/".$file;
            if ( is_dir($new_dir)) {
                if (preg_match ("'$no_index_dir'i", $new_dir)) { continue; }
                scan_files($new_dir);
            } else {
                if (preg_match ("'$file_ext'i", $new_dir)) {
                    $url = preg_replace ("'^$base_dir/'", "$base_url", $new_dir);
                    if (preg_match ("'$no_index_files'i", $url)) { continue; };
                    if ($cut_default_filenames == "YES") {
                        $url = preg_replace ("'$default_filenames'i", "/", $url);
                    }
                    if ($url_to_lower_case == "YES") {
                        $url = strtolower($url);
                    }
                    if ($fd = fopen ($new_dir, "rb") or print "Can't open file: $new_dir<BR>\n") {
                        $size = filesize($new_dir);
                        $html_text = @fread ($fd, $size);
                        fclose ($fd);
                        index_file($html_text,$url);
                    }
                }
                
            }
        }
    }
    closedir($dir_h);

}
#=====================================================================


?>
<HR>
<A href="/Opskrifter/index.php">Hjem</A>
</body>
</html> 