<?php
	exec("./lib/mover 127.0.0.1 51800 w".$_GET["direccion"]);
?>



<html>
<head>
<title>Arm.</title>
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

<h3>brazo de pruebas.</h3>
<br />

<table border="0">
<tr>
<td><center><h5>Cambiar Nivel y Rotar:</h5></center>
<table>
<tr>

<td></td>
<td><div id="flecha_arriba" style="background-color:green; width:80px; height:60px;" onMouseOver="this.style.backgroundColor='brown';" onMouseOut="this.style.backgroundColor='green';" OnClick="Coger('index.php?direccion=subir')"></div></td>
<td></td>
</tr>
<tr>
<td><div id="flecha_izq" style="background-color:green; width:80px; height:60px;" onMouseOver="this.style.backgroundColor='brown';" onMouseOut="this.style.backgroundColor='green';" OnClick="Coger('index.php?direccion=girar-izquierda')"></div></td>
<td></td>
<td><div id="flecha_der" style="background-color:green; width:80px; height:60px;" onMouseOver="this.style.backgroundColor='brown';" onMouseOut="this.style.backgroundColor='green';" OnClick="Coger('index.php?direccion=girar-derecha')"></div></td>
</tr><br/>
<tr>
<td></td>
<td><div id="flecha_abajo" style="background-color:green; width:80px; height:60px;" onMouseOver="this.style.backgroundColor='brown';" onMouseOut="this.style.backgroundColor='green';" OnClick="Coger('index.php?direccion=bajar')"></div></td>
<td></td>
</tr><br/>
</table></td>

<td><center><h5>Dirija:</h5></center>
<table>
<tr>
<td></td>
<td><div id="flecha_arriba" style="background-color:green; width:80px; height:60px;" onMouseOver="this.style.backgroundColor='brown';" onMouseOut="this.style.backgroundColor='green';" OnClick="Coger('index.php?direccion=adelante')"></div></td>
<td></td>
</tr>
<tr>
<td><div id="flecha_izq" style="background-color:green; width:80px; height:60px;" onMouseOver="this.style.backgroundColor='brown';" onMouseOut="this.style.backgroundColor='green';" OnClick="Coger('index.php?direccion=izquierda')"></div></td>
<td></td>
<td><div id="flecha_der" style="background-color:green; width:80px; height:60px;" onMouseOver="this.style.backgroundColor='brown';" onMouseOut="this.style.backgroundColor='green';" OnClick="Coger('index.php?direccion=derecha')"></div></td>
</tr><br/>
<tr>
<td></td>
<td><div id="flecha_abajo" style="background-color:green; width:80px; height:60px;" onMouseOver="this.style.backgroundColor='brown';" onMouseOut="this.style.backgroundColor='green';" OnClick="Coger('index.php?direccion=atras')"></div></td>
<td></td>
</tr><br/>
</table></td>



</tr>
</table>
<h5>Detener:</h5>
<div id="flecha_abajo" style="background-color:green; width:280px; height:60px;" onMouseOver="this.style.backgroundColor='brown';" onMouseOut="this.style.backgroundColor='green';" OnClick="Coger('index.php?direccion=detener')"></div>
</center>


</body>
</html>
