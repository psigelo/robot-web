<?php
	
	function lector(){
	
		$file = fopen($_GET["archivo"],'r');

		if ($line = fgets($file)) {
			$temp = explode("	", $line);	
			fclose($file);  
			
			
			for ( $i = 0 ; $i < count($temp) ; $i++){	
				echo $temp[$i], "<br>";
			}
			return $temp;
		}
		else {
			echo "Error al cargar archivo";		
		}
	}
	lector();
?>
