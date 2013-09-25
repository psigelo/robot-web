<!DOCTYPE html>
<html>
<head>
	<title>Lectura del servidor</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="./css/style.css"/>
	<script src="./lib/ConstructorXMLHttpRequest.js"></script>
	<script>

		// ESTANDAR: camelCase

//==============================================================================

		// Rutas de archivos
		var rutaPrincipal = ''; // Posición relativa
		var rutaConfig = rutaPrincipal + 'config';
		var rutaLector = rutaPrincipal + 'lector.php';
		var rutaTemperatura = rutaPrincipal + 'temperatura';
		var rutaCorriente = rutaPrincipal + 'corriente';
		//var rutaLectorJSON = rutaPrincipal + 'lectorJSON.php';

//==============================================================================

		// Configuración General Robot
		var nombre;
		var descripcion;
		var autores = new Array();
		var titulo = new Array();
		var descripcion = new Array();
		var numMotores;
		var numPatas;
		var numArticulaciones;

//==============================================================================

		// Configuración General Gráficas

		var izquierdaTipo = 1; // Tipo: 0 Barra | 1 Torta 
		var derechaTipo = 0;
		var izquierdaEscalar = 0; // Escalar: 0 Temperatura | 1 Corriente
		var derechaEscalar = 1;

		// Nombre de los archivos contenedores de datos
		var archivos = new Array();
		archivos[0] = rutaTemperatura;
		archivos[1] = rutaCorriente;

		// Tiempo de refresco de la pantalla [ms]
		var tiempoLoop = 1000; // Por defecto 1000[ms]

//==============================================================================

		// Configuración General Canvas
		var anchoCanvas = 300; 									// Ancho canvas [px]
		var altoCanvas = anchoCanvas * 4 / 3; 					// Alto canvas [px]

		// Configuración Tipo Barra
		var paddingLR = 40; 									// Padding Left-Right
		var paddingT = 70; 										// Padding Top
		var paddingB = 30; 										// Padding Bottom
		var anchoGrilla = anchoCanvas - 2 * paddingLR; 			// Ancho Grilla [px]
		var altoGrilla = altoCanvas - (paddingT + paddingB);	// Alto Grilla [px]
		var numeroDivisiones = 3; 								// Número Divisiones Grilla (>= 1)
		var diferenciaLargo = anchoGrilla/numeroDivisiones;
		var anchoDivisiones;
		var anchoBarras;  
		var offset;

		// Configuración Tipo Torta
		var radioMax = anchoCanvas * 0.4; 

		// Otros
		var valorMaximo = new Array();
		var valorMinimo = new Array();
		var diferenciaValor = new Array();
		var unidad = new Array();

//==============================================================================

		// Lee los datos de 'archivo' y genera una gráfica con los mismo en
		// posición: 0 izquierda | 1 derecha
		function Coger(pos)
		{
			var xmlhttp = ConstructorXMLHttpRequest();
			if(!xmlhttp) alert('Error: No se pudo crear el objeto XMLHttpRequest');
			else {
				// Entra si se pudo crear el objeto XMLHttpRequest
				xmlhttp.onreadystatechange = function() {

					// Una vez cargados todo ...
					if(xmlhttp.readyState == 4)
					{
						if(pos == 0) {
							dibujarGrafica(JSON.parse(xmlhttp.responseText), pos, izquierdaEscalar, izquierdaTipo);
						}
						else if (pos == 1) {
							dibujarGrafica(JSON.parse(xmlhttp.responseText), pos, derechaEscalar, derechaTipo);
						}
					}
				}
				xmlhttp.open('GET', rutaLector + '?archivo=' + archivos[pos], true); // true: Asincrónico | false: Sincrónico 
				xmlhttp.send(null);			
			}
		}

//==============================================================================

		// Dibuja la gráfica deseada (barras, torta, etc) en la posición 
		// deseada (izquierda, derecha, etc)
		function dibujarGrafica(datos, pos, esc, tipo){

			// Datos, Posición, Escalar, Tipo

			// Especifica el objeto CANVAS a utilizar
			var canvas = document.getElementById('canvas_' + pos);

			if (canvas.getContext){

				// Requerimiento de canvas
				var ctx = canvas.getContext('2d');

				// Limpia las gráficas previas
				ctx.clearRect(0,0,canvas.offsetWidth,canvas.offsetHeight);

				// Título
	  			ctx.shadowBlur = 20;
	  			ctx.shadowColor = '#00C6FF';
				ctx.font = '17px Arial';
	  			ctx.fillStyle = 'White';
	  			ctx.textAlign = 'center';
	  			ctx.fillText(titulo[esc],canvas.offsetWidth/2, 40);
	  			ctx.shadowColor = 'rgba(0,0,0,0)';

	  			// TIPO BARRA
				if (tipo == 0 ) {

					// Re-definimos valores para la sombra y el texto
	  				ctx.shadowBlur = 0;	
	  				ctx.strokeStyle = '#464646';
	  				ctx.fillStyle = '#6B6B6B';
	  				ctx.font = '7px Arial';  

					// Grilla de referencia
					for (var i = 0 ; i < numeroDivisiones ; i++) {
						ctx.fillText(diferenciaValor[esc] * (numeroDivisiones - i) + valorMinimo[esc] + unidad[esc], diferenciaLargo * i + paddingLR, paddingT - 5);	
						ctx.strokeRect(diferenciaLargo * i + paddingLR, paddingT, diferenciaLargo, altoGrilla);
					}
	  				ctx.fillText(Math.floor(valorMinimo[esc]) + unidad[esc], anchoCanvas-paddingLR, paddingT - 5);

	  				// Tamaño de fuentes para ID de motores
	  				if 		(numMotores >= 24) 	ctx.font = '7px Arial';
	  				else if (numMotores >= 15) 	ctx.font = '10px Arial';
	  				else if (numMotores > 0) 	ctx.font = '15px Arial';
	  						
  					var largoBarra; 
  					var rojo;
  					var verde;
  					var azul = 0;

	  				// Dibujar barras + IDs
					for (var i = 0 ; i < numMotores ; i++) {
						largoBarra = anchoGrilla * (datos[i] - valorMinimo[esc]) / (valorMaximo[esc] - valorMinimo[esc]);
						rojo = Math.floor(255 * (datos[i] - valorMinimo[esc]) / (valorMaximo[esc] - valorMinimo[esc]));
						verde = 255-rojo;
						ctx.fillStyle = 'rgb(' + rojo + ',' + verde + ', ' + azul + ')';
						ctx.fillText(i + 1, (pos) ? paddingLR - 10 : anchoGrilla + paddingLR + 10, paddingT + i * anchoDivisiones + 2 * anchoBarras);
						ctx.fillRect((pos) ? paddingLR : anchoGrilla - largoBarra + paddingLR, paddingT+i*anchoDivisiones+anchoBarras, largoBarra, anchoBarras);
					}
				}

				// TIPO TORTA
				else if(tipo == 1) { 					

  					var rojo;
  					var verde;
  					var azul = 0;

					ctx.save();
					ctx.translate(canvas.offsetWidth/2,canvas.offsetHeight/2);
					ctx.strokeStyle = '#202020';

					for (var j = numArticulaciones, k = 0 ; j > 0 ; j--) {
							
						ctx.save();
						for (var i = 0; i < numPatas ; i++){ 
							rojo = Math.floor(255*(datos[k++] - valorMinimo[esc])/(valorMaximo[esc]-valorMinimo[esc]));
							verde = 255 - rojo;
							ctx.fillStyle = 'rgb(' + rojo + ',' + verde + ',' + azul + ')'; 

							ctx.beginPath();
							ctx.moveTo(0,0);
							ctx.lineTo(radioMax*j/numArticulaciones,0);
							ctx.arc(0,0,radioMax*j/numArticulaciones,0,Math.PI*2/numPatas,false);
							ctx.closePath();
							ctx.fill();
							ctx.stroke();

							ctx.rotate(Math.PI*2/numPatas);
						}
						ctx.restore();
					}
					ctx.restore();
				}
			}
			else alert('Error: No se pudo cargar el objeto canvas');
		}

//==============================================================================

		// Configuración inicial de las variables globales.
		function config(){

			// Creamos un objeto con todos los datos del archivo
			var config = <?php echo file_get_contents('config'); ?>; // TMP -- Cambiar!

			// Datos Generales Robot
			nombre = config.nombre;
			descripcion = config.descripcion;
			numPatas = config.numPatas;
			numArticulaciones = config.numArticulaciones;
			numMotores = numPatas*numArticulaciones;

			for (var i = 0; i < config.autores.length; i++) {
				autores[i] = config.autores[i];
			};

			// Configuración Tipo Barra
			anchoDivisiones = altoGrilla/numMotores;
			anchoBarras = anchoDivisiones/2; 
			offset = anchoBarras/2;

			// Configuración General Gráfica
			for (var i = 0 ; i < config.grafico.length ; i++) {
				valorMaximo[i] = config.grafico[i].valorMax;
				valorMinimo[i] = config.grafico[i].valorMin;
				diferenciaValor[i] = Math.floor((valorMaximo[i] - valorMinimo[i]) / numeroDivisiones);
				unidad[i] = config.grafico[i].unidad;
				titulo[i] = config.grafico[i].titulo;
				descripcion[i] = config.grafico[i].descripcion;
			};
		}

		var temp_izquierda = setInterval(function(){Coger(0)}, tiempoLoop);
		var temp_derecha = setInterval(function(){Coger(1)}, tiempoLoop);

	//==============================================================================
	// TEST TMP
		function test(tipo, posicion){
			if(posicion == 0) izquierdaTipo = tipo; 
			else if(posicion == 1) derechaTipo = tipo;
		}
	//==============================================================================

	</script>
</head>

<!-- RESPONSIVO WideScreen hasta 300x400 canvas -->

<body onload="config()">
<div id="contenedor">
	<nav>
		<ul><li>Home</li>
			<li>About</li>
			<li>Vista
			    <ul>Visor Izquierdo
			    	<li onclick='test(0,0)'>Barra</li>
			    	<li onclick='test(1,0)'>Torta</li>
			    	Visor Derecho
			    	<li onclick='test(0,1)'>Barra</li>
			    	<li onclick='test(1,1)'>Torta</li>
			    </ul>
			</li>
			<li>Ayuda</li>
			<li>Contacto</li>
		</ul>
	</nav>
	<div class="visualizador">
		<div class="contenedor info-izquierda">
			<canvas id="canvas_0" width="300" height="400">¡Canvas no está soportado!</canvas>
		</div>
		<div class="contenedor video-stream"> 
			<video width="0" height="0" controls poster="test.jpg"  >
				<source src="http://content.bitsontherun.com/videos/nfSyO85Q-27m5HpIu.webm" type="video/webm" />
			</video>
		</div>
		<div class="contenedor info-derecha">
			<canvas id="canvas_1" width="300" height="400">¡Canvas no está soportado!</canvas>
		</div>
	</div>
	<div class="controlador">
		<div></div>
	</div>
</div>

<!-- TMP Borrar -->
<div id="resultado"></div>


</body>
</html>