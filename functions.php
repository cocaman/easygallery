<?php
/**
* My Easy Gallery v.2010
* 
* Author: Corsin Camichel, http://camichel.com/
* Information: http://cocaman.ch/wp/tag/easygallery/
*
* License: GPL 2.0, see gpl-2.0.txt
*/
function createRandomPassword() {

    $chars = "abcdefghijkmnopqrstu";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;

    while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }

    return $pass;

}


function cleanme($m) {
	$m = htmlentities($m);
	$m = str_replace("_", " ", $m);
	

	return $m;

}

function uglyname($m) {
	$m = htmlentities($m);
	$m = str_replace(" ", "_", $m);
	

	return $m;

}

function doThumbnail($galfolder, $thisimage) {
	global $gallery;

	$src_img = imagecreatefromjpeg($gallery["path"] . $galfolder . "/" . $thisimage);
					
	$old_x = imagesx($src_img);
	$old_y = imagesy($src_img);
	
	$ratio = $old_x / $old_y;
	
	if ($old_x > $old_y) {
		$thumb_w = $gallery["width"] * $ratio;
		$thumb_h = $gallery["height"];
	}
	if ($old_x < $old_y) {
		$thumb_w = $gallery["width"] * $ratio;
		$thumb_h = $gallery["height"];
	}
	if ($old_x == $old_y) {
		$thumb_w = $gallery["width"];
		$thumb_h = $gallery["height"];
	}
	
	$dst_img = imagecreatetruecolor($thumb_w,$thumb_h);
	imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
	
	imagejpeg($dst_img,$gallery["path"] . $galfolder . "/thumb/" . $thisimage); 
	imagedestroy($dst_img); 
	imagedestroy($src_img);

}

function doBigImage($galfolder, $thisimage) {
	global $gallery;

	$src_img = imagecreatefromjpeg($gallery["path"] . $galfolder . "/" . $thisimage);
					
	$old_x = imagesx($src_img);
	$old_y = imagesy($src_img);
	
	$ratio = $old_x / $old_y;
	
	if ($old_x > $old_y) {
		$thumb_w = ($gallery["width"]*5) * $ratio;
		$thumb_h = ($gallery["height"]*5);
	}
	if ($old_x < $old_y) {
		$thumb_w = ($gallery["width"]*5) * $ratio;
		$thumb_h = ($gallery["height"]*5);
	}
	if ($old_x == $old_y) {
		$thumb_w = ($gallery["width"]*5);
		$thumb_h = ($gallery["height"]*5);
	}
	
	$dst_img = imagecreatetruecolor($thumb_w,$thumb_h);
	imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
	
	imagejpeg($dst_img,$gallery["path"] . $galfolder . "/prev/" . $thisimage); 
	imagedestroy($dst_img); 
	imagedestroy($src_img);

}

?>