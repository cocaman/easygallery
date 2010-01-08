<?php
/**
* My Easy Gallery v.2010
* 
* Author: Corsin Camichel, http://camichel.com/
* Information: http://cocaman.ch/wp/tag/easygallery/
*
* License: GPL 2.0, see gpl-2.0.txt
*/

ini_set("max_execution_time", "320");
//set_time_limit(320);

require_once("config.php");
include_once("functions.php");

$doAdminWork = false;

if($_GET['action'] == "admin") {
	$doAdminWork = true;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= SITENAME; ?> &raquo; MyEasyPhotoGallery</title>
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<link href="css/gallery.css" rel="stylesheet" type="text/css" />

<script src="js/rating.js" type="text/javascript"></script>
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js?load=effects" type="text/javascript"></script>
<script src="js/lightbox.js" type="text/javascript"></script>
<?php
if($_GET['view'] == "refl") {
	echo '<script type="text/javascript" src="js/reflection.js"></script>';
}
?>
<script type="text/javascript" language="javascript">
	var hsm = location.hash;
	hsm = hsm.replace("#", "").toLowerCase();
</script>
</head>

<body>
<div id="logo"></div>
<?php
if(DEBUG) {
	echo "<pre>";
	print_r($gallery);
	echo "</pre>";
}
?>
<h1><?= SITENAME; ?> Gallery</h1>
<?php
$dir = opendir($gallery["path"]);

echo "<div class=\"galnav\">View Gallery: ";
while ($fs = readdir($dir)) {
	if(($fs != ".") && ($fs != "..")) {
		echo "<a class=\"galnav\" href=\"#". uglyname($fs) ."\">". cleanme($fs) ." &raquo; &rsaquo;</a> ";
	}
}
echo "</div>";

$dir = opendir($gallery["path"]);

while ($f = readdir($dir)) {
	if(($f != ".") && ($f != "..")) {
		//echo "<h2>Gallery: <a href='index.php?show=photos&gal=" . $f. "'>" . cleanme($f). "</a></h2>\n";
		echo "<a name=\"".uglyname($f)."\"></a>";
		echo "<div class=\"gallerystyle\">\n";
		echo "<h2>" . cleanme($f). " (<small><a href=\"". $_SERVER['PHP_SELF'] ."\" class=\"\">to the top</a></small>)</h2>\n";
	
		// Check if the Thumnails folder is there. If not, create it now!
		if($doAdminWork) {
			if(!is_dir($gallery["path"] . $f . "/thumb/")) {
				if(($f != ".") && ($f != "..")) {
					$thum = $gallery["path"] . $f . "/thumb/";
					echo $thum;
					if(mkdir($thum, 0777)) {
						echo "Thumbnail folder has been created";	
					} else {
						echo "Error: We could not create a Thumbnail folder. Please chmod the gallery folder with 777";
					}
				}
			}
		}
		
		// Check if the Thumnails folder is there. If not, create it now!
		if($doAdminWork) {
			if(!is_dir($gallery["path"] . $f . "/prev/")) {
				if(($f != ".") && ($f != "..")) {
					$thum = $gallery["path"] . $f . "/prev/";
					echo $thum;
					if(mkdir($thum, 0777)) {
						echo "Preview folder has been created";	
					} else {
						echo "Error: We could not create a Preview folder. Please chmod the gallery folder with 777";
					}
				}
			}
		}
		
		$curdir = opendir($gallery["path"] . $f);
		
		// get inside the directory and count the photos
		while($akt = readdir($curdir)) {
			if(!is_dir($akt)  && ((eregi("\.jpg",$akt)) || (eregi("\.JPG",$akt)) || (eregi("\.jpeg",$akt)) || (eregi("\.JPEG",$akt)))) {
				
				$thfile = $gallery["path"] . $f . "/thumb/" . $akt;

				if($doAdminWork) {
					if(!is_file($thfile)) {
						doThumbnail($f, $akt);
					}
					
					$prfile = $gallery["path"] . $f . "/prev/" . $akt;
	
					if(!is_file($prfile)) {
						doBigImage($f, $akt);
					}
				}
			}
		}
		
		$imgcounter = 0;
		$thumbis =  opendir($gallery["path"] . $f . "/thumb/");
		while($thu = readdir($thumbis)) {
			if(($thu != ".") && ($thu != "..")) {
				
				/*
				$phid = str_replace(".jpg", "", $thu);
				$phid = str_replace(".JPG", "", $phid);
				$phid = strtolower("phid" . $phid);
				*/
				
				$thisImageId = "/" . $f . "/thumb/" . $thu;

				echo "<div class='photo'>\n";
				echo "<a name='" . strtolower($thu) . "' href='" . $gallery["path"] . $f . "/prev/" . $thu . "' rel='lightbox[". uglyname($f) ."]' title='" . $thu . "'><img alt='" . $thu . "' src='" . $gallery["path"] . $f . "/thumb/" . $thu . "' class='photo reflect' height='" . $gallery["height"] . "' border='0' class='deactive' id='img" . strtolower($thu) . "' /></a>\n";
				echo "</div>\n";
				
				if($imgcounter == $gallery["max_row"]) {
					echo "<br clear='both' />\n";
					$imgcounter = 0;
				}
			}
		}
		
		echo "<br clear='both' />\n";
		echo "</div>\n";
	}
}

?>
<div id="copy">Script by <a href="http://camichel.com/">Corsin Camichel</a> | <a href="<?= $_SERVER['PHP_SELF']; ?>?action=admin">Do The Admin Job</a> | <a href="<?= $_SERVER['PHP_SELF']; ?>?view=refl">Show nicer images</a></div>
<script language="javascript" type="text/javascript">
for(i = 0; i < document.anchors.length; i++) {

	if((hsm > "") && (document.anchors[i].name != hsm)) {
		if(document.anchors[i].firstChild != null) {
			document.anchors[i].firstChild.className = document.anchors[i].firstChild.className + " deactive";
		}
	}	
}
</script>
</body>
</html>
