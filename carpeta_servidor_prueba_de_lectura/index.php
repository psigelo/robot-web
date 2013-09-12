<!DOCTYPE html>

<head>
	<title>Lectura del servidor</title>
	<meta charset="UTF-8">
	<script src="./lib/ConstructorXMLHttpRequest.js"></script>	
	<script>
		//Creamos la variable para el objeto XMLHttpRequest
		var req = null; 

		req = new ConstructorXMLHttpRequest();

		//Función coger, en esta caso le entra una dirección relativa al documento actual.
		function Coger(archivo) 
		{
			url = 'lector.php?archivo=' + archivo;
			//Si tenemos el objeto req
			if(req) 
			{
				//Abrimos la url, false=forma síncrona
				req.open('GET', url, true); 
				req.onreadystatechange = function() {
					if(req.readyState == 4) {
						document.getElementById('resultado').innerHTML = req.responseText;
					}
				}
				req.send(); 
			}
			else
			{
				alert('Error: No se pudo crear el objeto XMLHttpRequest');
			}
		}
	</script>
</head>

<body>
	<center>

	<h3>información</h3>
	<br />


	<div id="flecha_arriba" style="background-color:green; width:80px; height:60px;" onMouseOver="this.style.backgroundColor='brown';" onMouseOut="this.style.backgroundColor='green';" OnClick="Coger('temperatura')"></div></td>

	<div id="resultado"></div>
</body>
