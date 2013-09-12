<?php
	
	function lector(){
	
		$file = fopen('temperatura','r');

		if ($line = fgets($file)) {
			$temp = explode("	", $line);	
			fclose($file);  
			return $temp;
			
			//for ( $i = 0 ; $i < count($temp) ; $i++){	
			//	echo $temp[$i], "<br>";
			//}
		}
		else {
			echo "Error al cargar archivo";		
		}
	}
?>
