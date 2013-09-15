<?php
	function lector(){
	
		$archivo = 	$_GET["archivo"];
		
		$file = fopen( $archivo ,'r');

		if ($line = fgets($file)) {
			$temp = explode("	", $line);	
			fclose($file);
			echo '<?xml version="1.0" ?>';
			echo '<root>';
			for ( $i = 0 ; $i < count($temp) ; $i++)
				echo '<child id="', $i, '">', $temp[$i], '</child>';
			echo '</root>';
		}
		else {
			echo 'Error: No se pudo cargar archivo <i>', $archivo, '</i>';		
		}
	}

	lector();
?>
