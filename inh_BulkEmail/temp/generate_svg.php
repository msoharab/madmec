<?php
	$arrray = array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e");
	for($i=0;$i<sizeof($arrray);$i++){
		for($j=0;$j<sizeof($arrray);$j++){
			for($k=0;$k<sizeof($arrray);$k++){
				// echo "<p class=\"fa f".$arrray[$i].$arrray[$j].$arrray[$k]."\"></p>";
				echo ".f".$arrray[$i].$arrray[$j].$arrray[$k]."{content: \"\\f".$arrray[$i].$arrray[$j].$arrray[$k]."\"}<br />";
			}
			// echo "<p> test case $j </p>";
		}
	}
	
?>