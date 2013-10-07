
function ConstructorXMLHttpRequest()
{
	if(window.XMLHttpRequest) /* Chrome, Mozilla y Safari */
	{
		return new XMLHttpRequest();
	}
	else if(window.ActiveXObject) /* IE */
	{
		var versionesObj = new Array(
			'Msxml2.XMLHTTP.5.0',
			'Msxml2.XMLHTTP.4.0',
			'Msxml2.XMLHTTP.3.0',
			'Msxml2.XMLHTTP',
			'Microsoft.XMLHTTP'
			);
		
		for (var i = 0; i < versionesObj.length; i++)
		{
			try
			{
				return new ActiveXObject(versionesObj[i]);
			}

			catch (errorControlado) 
			{
				// no hacer nada
			}
		}
	}
	throw new Error("No se pudo crear el objeto XMLHttpRequest");
}

