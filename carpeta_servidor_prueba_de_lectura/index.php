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
		var numMotores = 6;
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
						if (xmlhttp.overrideMimeType) xmlhttp.overrideMimeType('text/xml');

						var xmlDoc = xmlhttp.responseXML;

					    if (!xmlDoc) xmlDoc = (new DOMParser()).parseFromString(xmlhttp.responseText, 'text/xml');
					    
					    var tempMotores = xmlDoc.getElementsByTagName('motor');
						
						var canvas = document.getElementById('temperatura');

						if (canvas.getContext){
    						var ctx = canvas.getContext('2d');
					        for (var i = 0; i < numMotores; i++) {
					        	ctx.fillStyle = "#BF5000"; // color temporal
						       	ctx.fillRect (20, 110 + i*anchoDivisiones + offset, 112, anchoBarras);
						       	ctx.clearRect(20, 110 + i*anchoDivisiones + offset, 112*(1 - (tempMotores[i].childNodes[0].nodeValue)/90), anchoBarras);
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