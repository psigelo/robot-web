<!DOCTYPE html>
<html>
<head>
	<title>Lectura del servidor</title>
	<meta charset="UTF-8">
	<script src="./lib/ConstructorXMLHttpRequest.js"></script>	
	<script>
		//Creamos la variable para el objeto XMLHttpRequest
		var xmlhttp = null; 
		xmlhttp = new ConstructorXMLHttpRequest();

		//Función coger, en esta caso le entra una dirección relativa al documento actual
		function Coger(archivo) 
		{
			url = 'lector.php?archivo=' + archivo;
			//Si tenemos el objeto xmlhttp
			if(xmlhttp) 
			{
				//Abrimos la url, false=forma síncrona
				xmlhttp.onreadystatechange = function() {					
					if(xmlhttp.readyState == 4) 
						document.getElementById('resultado').innerHTML = xmlhttp.responseText;
				}
				xmlhttp.open('GET', url, true); 
				xmlhttp.send(null); 
			}
			else
			{
				alert('Error: No se pudo crear el objeto XMLHttpRequest correctamente');
			}
		}
		// Loop infinito (1000ms = 1s)
		var temp = setInterval(function(){Coger('temperatura')}, 1000); 
	</script>
</head>

<body>
	<center>

	<h3>información</h3>
	<br />


	<div id="flecha_arriba" style="background-color:green; width:80px; height:60px;" onMouseOver="this.style.backgroundColor='brown';" onMouseOut="this.style.backgroundColor='green';" OnClick="Coger('temperatura')"></div></td>

	<div id="resultado"></div>
</body>
</html>