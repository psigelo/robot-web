
//==============================================================================

		// Rutas de archivos

		var rutaConfig = 'config';
		var rutaLector = 'lector.php';
		var rutaTemperatura = 'temperatura';
		var rutaCorriente = 'corriente';
		//var rutaLectorJSON = 'lectorJSON.php';

//==============================================================================

		// Configuración General Robot

		var nombreRobot;
		var descripcionRobot = new Array();
		var autores = new Array();
		var titulo = new Array();
		var numeroMotores;
		var numeroPatas;
		var numeroArticulaciones;

//==============================================================================

		// Configuración General Gráficas

		// Distribución
		var izquierdaTipo = 1; 		// Tipo: 0 Barra | 1 Torta | ...
		var derechaTipo = 0;
		var izquierdaEscalar = 0; 	// Escalar: 0 Temperatura | 1 Corriente | ...
		var derechaEscalar = 1;

		// Archivos de lectura de datos
		var archivos = new Array();
		archivos[0] = rutaTemperatura;
		archivos[1] = rutaCorriente;

		// Tiempo de refresco de la pantalla ( Por defecto 1000[ms] )
		var tiempoLoop = 1000; 

//==============================================================================

		// Configuración General Canvas

		var anchoCanvas = 300; 									
		var altoCanvas = anchoCanvas * 4 / 3; 					

		// Configuración Tipo Barra
		var paddingLR = anchoCanvas * 4 / 30; 					// Padding Left-Right
		var paddingT = anchoCanvas * 7 / 30; 					// Padding Top
		var paddingB = anchoCanvas / 10; 						// Padding Bottom
		var anchoGrilla = anchoCanvas - 2 * paddingLR; 			
		var altoGrilla = altoCanvas - (paddingT + paddingB);	
		var numeroDivisiones = 3; 								// Número Divisiones Grilla (>= 1)
		var diferenciaLargo = anchoGrilla / numeroDivisiones;
		var anchoDivisiones;
		var anchoBarras;  
		var offset;

		// Configuración Tipo Torta
		var radioMax = anchoCanvas * 0.4; 
		var anchoLeyenda = paddingB / 2; // Por defecto "paddingB/2"
		var numeroSubDivisiones = 3; // Degrade entre dos términos de la leyenda
		var anchoSubDivisiones = anchoGrilla / (numeroDivisiones * numeroSubDivisiones);

		// Otros
		var valorMaximo = new Array();
		var valorMinimo = new Array();
		var diferenciaValor = new Array();
		var unidad = new Array();

		// Angulo actual de dirección (con el controlador 360º)
    	var anguloActual = 0;

//==============================================================================

		// Lee los datos de 'archivo' y genera una gráfica con los mismo en la
		// posición: 0 izquierda | 1 derecha
		function Cargar(pos)
		{
			var xmlhttp = ConstructorXMLHttpRequest();
			if(!xmlhttp) alert('Error: No se pudo crear el objeto XMLHttpRequest');
			else {
				xmlhttp.onreadystatechange = function() {
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
				ctx.clearRect(0, 0, canvas.offsetWidth,canvas.offsetHeight);

				// Título
	  			ctx.shadowBlur = 20;
	  			ctx.shadowColor = '#00C6FF';
				ctx.font = '17px Arial';
	  			ctx.fillStyle = 'White';
	  			ctx.textAlign = 'center';
	  			ctx.fillText(titulo[esc], canvas.offsetWidth / 2, 40);
	  			ctx.shadowBlur = 0;

	  			// TIPO BARRA
				if (tipo == 0 ) {

					// Re-definimos valores para la sombra y el texto
	  				ctx.strokeStyle = '#464646';
	  				ctx.fillStyle = '#6B6B6B';
	  				ctx.font = '7px Arial';  

					// Grilla de referencia
					for (var i = 0 ; i < numeroDivisiones ; i++) {
						ctx.fillText(diferenciaValor[esc] * (numeroDivisiones - i) + valorMinimo[esc] + unidad[esc], diferenciaLargo * i + paddingLR, paddingT - 5);	
						ctx.strokeRect(diferenciaLargo * i + paddingLR, paddingT, diferenciaLargo, altoGrilla);
					}
	  				ctx.fillText(valorMinimo[esc] + unidad[esc], anchoCanvas-paddingLR, paddingT - 5);

	  				// Tamaño de fuentes para ID de motores
	  				if 		(numeroMotores >= 24) 	ctx.font = '7px Arial';
	  				else if (numeroMotores >= 15) 	ctx.font = '10px Arial';
	  				else if (numeroMotores > 0) 	ctx.font = '15px Arial';
	  						
  					var largoBarra; 
  					var rojo;
  					var verde;
  					var azul = 0;

	  				// Dibujar barras + IDs
					for (var i = 0 ; i < numeroMotores ; i++) {

						largoBarra = anchoGrilla * (datos[i] - valorMinimo[esc]) / (valorMaximo[esc] - valorMinimo[esc]);
						rojo = Math.floor(255 * (datos[i] - valorMinimo[esc]) / (valorMaximo[esc] - valorMinimo[esc]));
						verde = 255 - rojo;
						ctx.fillStyle = 'rgb(' + rojo + ',' + verde + ', ' + azul + ')';
						ctx.fillText(i + 1, (pos) ? paddingLR - 10 : anchoGrilla + paddingLR + 10, paddingT + i * anchoDivisiones + 2 * anchoBarras);
						ctx.fillRect((pos) ? paddingLR : anchoGrilla - largoBarra + paddingLR, paddingT + i * anchoDivisiones + offset, largoBarra, anchoBarras);
					}
				}

				// TIPO TORTA
				else if(tipo == 1) { 					

  					var rojo;
  					var verde;
  					var azul = 0;

					ctx.save();

					// Traslada el eje de coordenadas del CANVAS al centro de éste
					ctx.translate(canvas.offsetWidth/2,canvas.offsetHeight/2);

					ctx.strokeStyle = '#202020';
					ctx.font = '60px Arial';

					for (var j = numeroArticulaciones, k = 0 ; j > 0 ; j--) {
							
						ctx.save();
						for (var i = 0 ; i < numeroPatas ; i++) {

							rojo = Math.floor(255 * (datos[k++] - valorMinimo[esc]) / (valorMaximo[esc] - valorMinimo[esc]));
							verde = 255 - rojo;
							ctx.fillStyle = 'rgb(' + rojo + ',' + verde + ',' + azul + ')'; 

							// Dibuja un pedazo de "torta"
							ctx.beginPath();
							ctx.moveTo(0, 0);
							ctx.arc(0, 0, radioMax * j / numeroArticulaciones, - Math.PI / 2, - Math.PI / 2 + Math.PI * 2 / numeroPatas, false);
							ctx.closePath();
							ctx.fill();
							ctx.stroke();

							ctx.rotate(Math.PI / numeroPatas);

							// Dibuja el ID de la pata actual
							if(j == 1) { 
								ctx.fillStyle = 'rgba(0,0,0,0.5)';
								ctx.fillText(i + 1, 0, - radioMax / 2.5);
							}

							ctx.rotate(Math.PI / numeroPatas);
						}
						ctx.restore();
					}

					ctx.restore();

					// Leyenda de Colores
					ctx.font = '7px Arial'; 

					for (var i = 0 ; i < numeroDivisiones * numeroSubDivisiones ; i++) {

						rojo = Math.floor(255 * (1 - i / (numeroSubDivisiones * numeroDivisiones)));
						verde = 255 - rojo;
						ctx.fillStyle = 'rgb(' + rojo + ',' + verde + ',' + azul + ')';

						// Escribe el valor del escalar actual
						if (i % numeroSubDivisiones == 0) {
							ctx.fillText(diferenciaValor[esc] * (numeroDivisiones - i / numeroSubDivisiones) + valorMinimo[esc] + unidad[esc], diferenciaLargo * i / numeroSubDivisiones + paddingLR, altoCanvas - paddingB - anchoLeyenda - 5);
						}

						// Dibuja el cuadrado de color acorde a la temperatura
						ctx.fillRect(paddingLR + anchoSubDivisiones * i, altoCanvas - paddingB - anchoLeyenda, anchoSubDivisiones, anchoLeyenda);
					}
					ctx.fillText(valorMinimo[esc] + unidad[esc], anchoGrilla + paddingLR, altoCanvas - paddingB - anchoLeyenda - 5);
				}
			}

			else alert('Error: No se pudo cargar el objeto canvas');
		}

//==============================================================================

		// Configuración inicial de las variables globales.
		function init(){

			// Configuraciones iniciales del robot y de los visualizadores
			var xmlhttp = ConstructorXMLHttpRequest();

			if(!xmlhttp) alert('Error: No se pudo crear el objeto XMLHttpRequest');
			else {
				
				xmlhttp.onreadystatechange = function() {
					if(xmlhttp.readyState == 4)
					{
						var config = JSON.parse(xmlhttp.responseText);

						// Datos Generales Robot
						nombreRobot = config.nombre;
						numeroPatas = config.numPatas;
						numeroArticulaciones = config.numArticulaciones;
						numeroMotores = numeroPatas * numeroArticulaciones;

						for (var i = 0 ; i < config.autores.length ; i++) {
							autores[i] = config.autores[i];
						}

						// Configuración Tipo Barra
						anchoDivisiones = altoGrilla/numeroMotores;
						anchoBarras = anchoDivisiones/2; 
						offset = anchoBarras/2;

						// Configuración General Gráfica
						for (var i = 0 ; i < config.grafico.length ; i++) {
							valorMaximo[i] = config.grafico[i].valorMax;
							valorMinimo[i] = config.grafico[i].valorMin;
							diferenciaValor[i] = Math.floor((valorMaximo[i] - valorMinimo[i]) / numeroDivisiones);
							unidad[i] = config.grafico[i].unidad;
							titulo[i] = config.grafico[i].titulo;
							descripcionRobot[i] = config.grafico[i].descripcion;
						}
					}
				}
				xmlhttp.open('GET', rutaLector + '?archivo=' + rutaConfig, false); // false: Sincrónico 
				xmlhttp.send(null);			
			}

			// Configuración inicial para los controles
	    	var canvas = document.getElementById("canvas_control");
	    	canvas.addEventListener("mousemove", function (evento) {dibujarDireccionador(evento, 0);}, false);
	    	canvas.addEventListener("click", function (evento) {dibujarDireccionador(evento, 1);}, false);
		}

		// Loop de funciones
		var tempIzquierda = setInterval(function(){Cargar(0)}, tiempoLoop);
		var tempDerecha = setInterval(function(){Cargar(1)}, tiempoLoop);

//==============================================================================

	// Dibuja la gráfica del controlador de direcciones 360º

   	function dibujarDireccionador(evento, click) {

    	var canvas = document.getElementById("canvas_control");

        if (canvas.getContext){

        	var arista = canvas.height;

	       	// Posición del mouse, considerando el plano cartesiano con origen en el centro del canvas.
	       	var x, y;

	       	// Angulo con respecto al eje positivo de las abscisas
	       	var angulo;

	       	// Radio máximo del control
	       	var radio = arista * 2 / 5;

	       	// Requerimiento de canvas
	       	var ctx = canvas.getContext('2d');

	       	// Obtiene la posición del puntero dentro del canvas  
	        if (evento.offsetX != undefined && evento.offsetY != undefined) {
	        	x = evento.offsetX;
	        	y = evento.offsetY;
	    	}
	        /*else { // Requerido sólo para Firefox
	        	x = evento.layerX; // + document.body.scrollLeft + document.documentElement.scrollLeft;
	        	y = evento.layerY; // + document.body.scrollTop + document.documentElement.scrollTop;
	        }*/

	        // Traslado de la posición obtenida hacia el centro del canvas
        	x -=  arista/2;
		    y = arista/2 - y; // Damos vuelta el eje de las ordenadas
		        
		    // Si el puntero está dentro radio del controlador ...
		    if (x * x + y * y <= radio * radio * 1.21 ) {

			    // Cálculo del angulo respecto al punto (x,y)
			    angulo = Math.atan(y/x);
			    if (x < 0)			angulo += Math.PI;
			    else if (y <= 0) 	angulo += 2 * Math.PI;

	        	// Limpia las gráficas previas
			   	ctx.clearRect(0, 0, canvas.width, arista);

		       	// Trasladamos el origen del canvas al centro del mismo
		       	ctx.save();
				ctx.translate(canvas.width/2, arista/2);
				ctx.rotate(-angulo);

				// Gradiente Circulo grande
		       	var gradiente1 = ctx.createRadialGradient(0, 0, radio, 0, 0, 0);
		       	gradiente1.addColorStop(0, 'rgba(0,160,255,0.7)');
		       	gradiente1.addColorStop(0.05, 'rgba(0,20,100,0.2)');
		       	gradiente1.addColorStop(1, 'rgba(0,0,0,0)');

		       	// Gráfica Circulo grande
		       	ctx.fillStyle = gradiente1;
		       	ctx.beginPath();
		       	ctx.arc(0, 0, radio, 0, 2*Math.PI, false);
		       	ctx.closePath();
		       	ctx.fill();

		       	// Gráfica Circulo pequeño
		       	ctx.fillStyle = 'rgba(0,160,255,0.5)';
		    	ctx.beginPath();
		       	ctx.arc(radio, 0, radio/10, 0, 2*Math.PI, false);
		       	ctx.closePath();
		       	ctx.fill();

		       	ctx.restore();

				// Angulo Actual actualizado
		       	if (click == 1) { anguloActual = angulo; }

		       	// Escritura de los ángulos
		       	ctx.strokeStyle = '#464646';
	  			ctx.fillStyle = '#6B6B6B';
				ctx.font = '65px Arial'; 
				ctx.textAlign = 'center';
		       	ctx.fillStyle = 'rgb(255,255,255,0.5)';
				ctx.fillText(Math.floor(anguloActual * 180 / Math.PI) + 'º', canvas.width * 0.52, canvas.height / 2);
				ctx.font = '30px Arial'; 
				ctx.fillText(Math.floor(angulo * 180 / Math.PI) + 'º', canvas.width * 0.52, canvas.height * 2 / 3 );
	        }
	    }
      }

//==============================================================================

		function cambiarTipo(tipo, posicion) {
			if(posicion == 0) izquierdaTipo = tipo; 
			else if(posicion == 1) derechaTipo = tipo;
		}

//==============================================================================



