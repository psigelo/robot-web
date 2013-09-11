<?php
if(is_numeric($_GET["x"]) and is_numeric($_GET["y"]) and is_numeric($_GET["z"]) and is_numeric($_GET["v"])){	
	echo "./lib/mover 127.0.0.1 51800 w".$_GET["x"].",".$_GET["y"].",".$_GET["z"].",".$_GET["v"];
}
?>

<html>
<head>
<title>Z-Arm.</title>
<link rel="stylesheet" type="text/css" href="./css/css.css" />
<meta charset="UTF-8">
<script language="javascript" src="./lib/ConstructorXMLHttpRequest.js"></script>
<script language="JavaScript" type="text/javascript">


var peticion01 = null; //Creamos la variable para el objeto XMLHttpRequest
//Este ejemplo emplea un constructor, debería funcionar en cualquier navegador.
peticion01 = new ConstructorXMLHttpRequest();
function Coger(url) //Función coger, en esta caso le entra una dirección relativa al documento actual.
{
if(peticion01) //Si tenemos el objeto peticion01
{
peticion01.open('GET', url, true); //Abrimos la url, false=forma síncrona
peticion01.send(null); //No le enviamos datos al servidor
//Escribimos la respuesta en el campo con ID=resultado
document.getElementById('resultado').innerHTML = peticion01.responseText;
}
}
</script>
</head>

<body>
<center>
<IMG SRC="zbot.png" WIDTH=60% BORDER=0 ALT="Zbot">
<h3>Z-Arm, brazo de pruebas.</h3>
<br />


<form action="moverMotor.php" method="get">
	X[mm]: <input type="text" name="x"><br>
	Y[mm]: <input type="text" name="y"><br>
	Z[mm]: <input type="text" name="z"><br>
	V[mm/s]: <input type="text" name="v"><br>
	<input type="submit" value="Submit">
</form>


</body>
</html>
