<html>
<head>
</head>

<body>
<?php

require("icecream.php");

/* Our visitor has picked an adoptable they want, its id is in $_REQUEST['id']. Find that
 * adoptable in adoptables.xml
 */
$adoptable=find_adoptable($_REQUEST['id']);

/* To randomly pick a variation from that adoptable, we're going have to do a little maths with
 * random numbers.
 *
 * First we find the sum of all the 'chance' attributes for this adoptable...
 */

$sum=0;
foreach ($adoptable->variation as $variation) {
	$sum=$sum + $variation['chance'];
}

/* Now we can generate a random number which goes from 0.0 to that sum. This will help us
 * pick a variation.
 */
$random=lcg_value()*$sum;

$sum=0;
foreach ($adoptable->variation as $variation) {
	$sum = $sum + $variation['chance'];
	
	if ($random <= $sum) {
		//Choose this variation
		$v_id= encrypt_variation($variation['id']);
		break;
	}
}

?>

<p><img src="simple.php?a=<?php echo $_REQUEST['id'];?>&amp;v=<?php echo $v_id;?>"></p>
<p>Thanks for adopting this pet! :). Here is the adoption code for your pet:</p>
<p><textarea cols="60" rows="2"><img src="http://www.mywebsite.com/simple.php?a=<?php echo $_REQUEST['id'];?>&amp;v=<?php echo $v_id;?>"></textarea></p>
</body>
</html>
