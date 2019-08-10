<?php
error_reporting(0);
$string = file_get_contents("linkedin-email.txt"); // Load text file contents

// don't need to preassign $matches, it's created dynamically

// this regex handles more email address formats like a+b@google.com.sg, and the i makes it case insensitive
$pattern = '/[a-z0-9_\-\+]+@[a-z0-9\-]+\.([a-z]{2,3})(?:\.[a-z]{2})?/i';

// preg_match_all returns an associative array
preg_match_all($pattern, $string, $matches);

// the data you want is in $matches[0], dump it with var_export() to see it
// var_export($matches[0]);
$data  = array_unique($matches[0]);

// echo '<br />'.print_r($data);
// $data  = asort($data);

for($i=1;$i<sizeof($data);$i+= 2){
	echo $data[$i].";\n";
}

?>