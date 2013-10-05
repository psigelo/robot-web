<?php
	echo trim(preg_replace('/\s+/', '', file_get_contents($_GET["archivo"])));
?>
