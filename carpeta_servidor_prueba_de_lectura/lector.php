<?php
	
	function lector(){
	
		$archivo = 	$_GET["archivo"];
		
		$file = fopen( $archivo ,'r');

		if ($line = fgets($file)) {
			$temp = explode("	", $line);	
			fclose($file);  
			//return $temp;
			
			for ( $i = 0 ; $i < count($temp) ; $i++){	
				echo $temp[$i], "<br>";
			}
		}
		else {
			echo "Error al cargar archivo";		
		}
	}
	
	lector();
?>
