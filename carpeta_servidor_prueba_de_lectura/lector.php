<?php
	function lector(){
	
		$archivo = 	$_GET["archivo"];
		
		$file = fopen( $archivo ,'r');

		if ($line = fgets($file)) {
			$temp = explode("	", $line);	
			fclose($file);
			echo '<?xml version="1.0" ?>';
			echo '<motores>';
			for ( $i = 0 ; $i < count($temp) ; $i++)
				echo '<motor id="', $i, '">', $temp[$i], '</motor>';
			echo '</motores>';
		}
		else {
			echo 'Error: No se pudo cargar archivo <i>', $archivo, '</i>';		
		}
	}

	lector();
?>
