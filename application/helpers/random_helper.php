<?php

	function generateRandomString($length)
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_";
		srand((double)microtime()*1000000);

		$i = 0;
		$pass = '' ;

		while ($i <= $length) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$pass = $pass . $tmp;
			$i++;
		}
		
		return $pass;
	}
	
	
	function time_since($original) {
		// array of time period chunks
		$chunks = array(
			array(60 * 60 * 24 * 365 , 'año'),
			array(60 * 60 * 24 * 30 , 'mes'),
			array(60 * 60 * 24 * 7, 'semana'),
			array(60 * 60 * 24 , 'dia'),
			array(60 * 60 , 'hora'),
			array(60 , 'minuto'),
		);
		
		$today = time(); /* Current unix time  */
		$since = $today - $original;
		
		// $j saves performing the count function each time around the loop
		for ($i = 0, $j = count($chunks); $i < $j; $i++) {
			
			$seconds = $chunks[$i][0];
			$name = $chunks[$i][1];
			
			// finding the biggest chunk (if the chunk fits, break)
			if (($count = floor($since / $seconds)) != 0) {
				// DEBUG print "<!-- It's $name -->\n";
				break;
			}
		}
		
        if ($name == "mes") {
            $print = ($count ==1) ? "1 ". $name : "$count {$name}es";
        }
        else {    
            $print = ($count == 1) ? "1 ". $name : "$count {$name}s";
        }

		if ($i + 1 < $j) {
			// now getting the second item
			$seconds2 = $chunks[$i + 1][0];
			$name2 = $chunks[$i + 1][1];
			
			// add second item if it's greater than 0
			if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) {
				$print .= ($count2 == 1) ? ', 1 '. $name2 : ", $count2 {$name2}s";
			}
		}
		return $print;
	}	
?>