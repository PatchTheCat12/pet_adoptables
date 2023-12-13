<?php

//Load the adoptables XML file
$adoptxml=simplexml_load_file("hamburger.xml");

require("key.php");

function encrypt_variation($id) {

	global $encrypt_key;
	
	$key=rand(0, 0xFFFF);
	
	return ((($id ^ $key) << 16) | $key) ^ $encrypt_key;
}

function decrypt_variation($id) {

	global $encrypt_key;

	$id^= $encrypt_key;

	return (($id >> 16) & 0xFFFF) ^ ($id & 0xFFFF);
}

//Find the adoptable from adoptables.xml which has the right id
function find_adoptable($id) {
	global $adoptxml;

	//For each 'adoptable' tag which is available
	foreach ($adoptxml->adoptable as $adoptable) {
	
		//Is this adoptable's id the same as the one that the user wants to see?
		if ($adoptable['id']==$id) {
			//Yes, it is
			return $adoptable;
		}
	}
	
	return NULL; //We couldn't find an adoptable with that ID
}

//Find the variation with the given adoptable id and variation id
function find_variation($adoptid, $varid) {

	$adoptable=find_adoptable($adoptid);

	//For each 'variation' tag which is available
	foreach ($adoptable->variation as $variation) {
	
		//Is this variation's id the same as the one that the user wants to see?
		if ($variation['id']==$varid) {
			//Yes, it is
			return $variation;
		}
	}
	
	return NULL; //We couldn't find the variation with that ID
}

?>