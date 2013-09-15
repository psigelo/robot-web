<!DOCTYPE html>
<html>
<head>
	<title>Lectura del servidor</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="./css/style.css"/>
	<script src="./lib/ConstructorXMLHttpRequest.js"></script>	
	<script>
		// Creamos la variable para el objeto XMLHttpRequest
		var xmlhttp = ConstructorXMLHttpRequest();		

		// Datos generales del robot (valores temporales de prueba)
		var numMotores = 3;
		var anchoDivisiones = 240/numMotores;
		var anchoBarras = anchoDivisiones/2; 
		var offset = anchoBarras/2;

		//Función Coger, en esta caso le entra una dirección relativa al documento actual
		function Coger(archivo)
		{
			var url = 'lector.php?archivo=' + archivo;

			if(xmlhttp)
			{
				xmlhttp.onreadystatechange = function() {
					if(xmlhttp.readyState == 4)
					{
						// Necesario para recibir la respuesta en formato XML
						if (xmlhttp.overrideMimeType) xmlhttp.overrideMimeType('text/xml');

						// Verifica si la sintaxis de la respuesta está en XML, sino retorna nulo
						var xmlDoc = xmlhttp.responseXML;

						// Genera un objeto DOM a partir de la respuesta interpretada como XML
					    if (!xmlDoc) xmlDoc = (new DOMParser()).parseFromString(xmlhttp.responseText, 'text/xml');

					    var children = xmlDoc.getElementsByTagName('child');

					    // Especifica el objeto CANVAS a utilizar
						var canvas = document.getElementById(archivo);

						if (canvas.getContext){
							
    						var ctx = canvas.getContext('2d');
    						var temperatura;

					        for (var i = 0; i < numMotores; i++) {
					        	temperatura = children[i].childNodes[0].nodeValue;

					        	//hexString = temperatura.toString(16) + (90 - temperatura).toString(16);
					        	
					        	ctx.fillStyle = 'rgb(' + temperatura*(51/18) + ',' + (255 - temperatura*(51/18)) + ',00)'; 
						       	ctx.fillRect (20, 110 + i*anchoDivisiones + offset, 112, anchoBarras);
						       	ctx.clearRect (20, 110 + i*anchoDivisiones + offset, 112*(1 - temperatura/90), anchoBarras);

						       	//document.getElementById('resultado').innerHTML = 'rgb(' + temperatura*(51/18) + ',' + (255 - temperatura*(51/18)) + ',00)'; 
					        };
				    	}
				    	else alert('Error: No se pudo obtener el contexto [canvas.getContext()]');
					}
				}
				xmlhttp.open('GET', url, true);
				xmlhttp.send(null);
			}
			else alert('Error: No se pudo crear el objeto XMLHttpRequest');
		}

		// Loop infinito cada 1000ms = 1s
		var temp = setInterval(function(){Coger('temperatura')}, 1000);
		//var temp = setInterval(function(){Coger('corriente')}, 1000); 
		

	</script>
</head>

<body>
<div id="contenedor">
	<div id="visualizador"> 
		<div id="info-izquierda">
			<canvas id="temperatura" width="140" height="400">¡Canvas no está funcionando!</canvas>
		</div>
		<div id="video-stream"> 
			<h1>video steam<br>here</h1><br> 
		</div>
		<div id="info-derecha">
		</div>
	</div>
	<div id="controlador">
		<div></div>
	</div>
</div>
<div id="resultado"></div>
</body>
</html>