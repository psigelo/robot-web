<?php
	function lector(){
	
		$archivo = 	$_GET["archivo"];
		
		$file = fopen( $archivo ,'r');

		if ($line = fgets($file)) {
			$temp = explode("	", $line);	
			fclose($file);
			for ( $i = 0 ; $i < count($temp) ; $i++)
				echo $temp[$i];
		}
		else {
			echo 'Error: No se pudo cargar archivo <i>', $archivo, '</i>';		
		}
	}

	lector();
?>
