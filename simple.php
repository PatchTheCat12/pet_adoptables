<?php

//Tell the browser that we are sending it a PNG image to display
//header("Content-Type: image/png");

require("adopttools.php");

//Find the variation with the given adoptable id ('a') and variation id ('v')
$variation=find_variation($_REQUEST['a'], decrypt_variation($_REQUEST['v']));

//Decide which of the ages we want to show for the adoptable
		
$pickedAge=NULL; //We'll store the age we eventually pick into the variable $pickedAge
		
/* Check the ages in order. The age we end up picking will be the last age
 * in the file where the current date is after the 'date' attribute
 */
foreach ($variation->age as $age) {
	if (!isset($age['date']) || time() > strtotime($age['date'])) {
		$pickedAge=$age;
	}
}

//Now that we've picked the age, display the image that that age uses
readfile($pickedAge['image']);	

exit();

?>