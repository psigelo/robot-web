<?php
	exec("./lib/mover 127.0.0.1 51800 w".$_GET["direccion"]);
?>

<html>
<head>
	<title>Lectura del servidor</title>
	<meta charset="UTF-8">
	<script>


	var peticion01 = null; //Creamos la variable para el objeto XMLHttpRequest
	//Este ejemplo emplea un constructor, debería funcionar en cualquier navegador.
	peticion01 = new ConstructorXMLHttpRequest();
	function Coger(url) //Función coger, en esta caso le entra una dirección relativa al documento actual.
	{
		if(peticion01) //Si tenemos el objeto peticion01
		{
			peticion01.open('GET', url, true); //Abrimos la url, false=forma síncrona
			peticion01.send(null); //No le enviamos datos al servidor
		}
	}

	</script>
</head>

<body>
<center>

<h3>información</h3>
<br />


<div id="flecha_arriba" style="background-color:green; width:80px; height:60px;" onMouseOver="this.style.backgroundColor='brown';" onMouseOut="this.style.backgroundColor='green';" OnClick="Coger('index.php?direccion=subir')"></div></td>



</body>
</html>
