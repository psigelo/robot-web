<?php
	function lector(){
	
		$archivo = 	$_GET["archivo"];
		
		$file = fopen( $archivo ,'r');

		if ($line = fgets($file)) {
			$temp = explode("	", $line);	
			fclose($file);
			echo '[', $temp[0] ;
			for ( $i = 1 ; $i < count($temp) -1 ; $i++)
				echo ',', $temp[$i];
			echo ']';
		}
	}

	lector();
?>
