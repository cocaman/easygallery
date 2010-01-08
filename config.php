<?php
/**
* My Easy Gallery v.2010
* 
* Author: Corsin Camichel, http://camichel.com/
* Information: http://cocaman.ch/wp/tag/easygallery/
*
* License: GPL 2.0, see gpl-2.0.txt
*/

ini_set("memory_limit","12M"); // do not set to high! Server might get angry

define("SITENAME", "Demo Gallery");
define("DEBUG", false);


// set the name of your albums folder
$gallery["path"] = "albums/";	// default: albums/

// set the path to your albums.
$gallery["full_path"] = $_SERVER['DOCUMENT_ROOT'] . "/" . $gallery["path"];

// set the height of the thumbnail
$gallery["height"] = 120;

// set the width of the thumbnail
$gallery["width"] = 120;

// ...
$gallery["max_row"] = 1000;



?>