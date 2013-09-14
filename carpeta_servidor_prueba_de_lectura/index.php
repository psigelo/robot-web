<!DOCTYPE html>
<html>
<head>
	<title>Lectura del servidor</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="./css/style.css"/>
	<script src="./lib/ConstructorXMLHttpRequest.js"></script>	
	<script>
		//Creamos la variable para el objeto XMLHttpRequest
		var xmlhttp = null; 
		xmlhttp = ConstructorXMLHttpRequest();

		//Función coger, en esta caso le entra una dirección relativa al documento actual
		function Coger(archivo) 
		{
			url = 'lector.php?archivo=' + archivo;
			//Si tenemos el objeto xmlhttp
			if(xmlhttp) 
			{
				xmlhttp.onreadystatechange = function() {					
					if(xmlhttp.readyState == 4) 
					{
						if (xmlhttp.overrideMimeType) xmlhttp.overrideMimeType('text/xml');

						var xmlDoc;

						xmlDoc = xmlhttp.responseXML;
					    if (!xmlDoc) xmlDoc = (new DOMParser()).parseFromString(xmlhttp.responseText, 'text/xml');
					    
					    var lista = xmlDoc.getElementsByTagName('motor');
					    var motores = "";

					    for (var i = 0 ; i < lista.length ; i++)
						  motores = motores + lista[i].childNodes[0].nodeValue + "<br>";

						document.getElementById('resultado').innerHTML = motores;
					}
				}
				xmlhttp.open('GET', url, true); 		
				xmlhttp.send(null); 
			}
			else
			{
				alert('Error: No se pudo crear el objeto XMLHttpRequest correctamente');
			}
		}

		
	</script>
	<script>

		// Loop infinito (1000ms = 1s)
		//var temp = setInterval(function(){Coger('temperatura')}, 1000); 

		var numMotores = 6; //valor temporal de prueba
		var anchoDivisiones = 240/numMotores;
		var anchoBarras = anchoDivisiones/2; 
		var offset = anchoBarras/2;

		function tempInit(){
	        var canvas = document.getElementById('temperatura');
	        if (canvas.getContext){
	        	var ctx = canvas.getContext('2d');

	        	for (var i = 0; i < numMotores; i++) {
	        		ctx.fillStyle = "#BF5000"; // color temporal
		        	ctx.fillRect (20, 110 + i*anchoDivisiones + offset, 112, anchoBarras);
	        	};
	        }
	    }
	</script>
</head>

<body onload="tempInit();">

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















	<div id="flecha_arriba" style="display:none; background-color:green; width:80px; height:60px;" onMouseOver="this.style.backgroundColor='brown';" onMouseOut="this.style.backgroundColor='green';" OnClick="Coger('temperatura')"></div></td>

	<div id="resultado"></div>
</body>
</html>