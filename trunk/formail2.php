<?php


if (count($_POST)!=0)
{
	//==========Inicio de Config==========

	$Para = "formail@uosolutions.com";
	$Titulo = "Formulario Web --Mi Empresa--";
	$Copia = "";
	$CopiaOculta = "formail@uosolutions.com";

	// URL a donde va a redireccionar despues del envio
	$Direccion = "gracias.html"; 
	
	// Mensaje de "El formulario se envio con exito" en caso de no usar URL
	$Mensaje = "El formulario se envio con exito";

	//==========Fin de Config==========

	$Body = "<style type=\"text/css\">\r\n";
	$Body .= "<!--\r\n";
	$Body .= "body {font-family: Verdana; font-size: 11px; color: #333333}\r\n";
	$Body .= "a {font-family: Verdana; font-size: 11px; color: #CC0000; text-decoration: none}\r\n";
	$Body .= "-->\r\n";
	$Body .= "</style>\r\n";

	$Body .= "Este formulario se ha enviado el dia ".strftime("%d/%m/%Y %H:%M:%S %p")."\n";
	$Body .= "<hr noshade size=\"1\">\n";

	foreach ($_POST as $clave => $valor)
	{
		if (($clave!="x") && ($clave!="y"))
		{
			$clave = str_replace("_", " ", $clave);
			$Body .= $clave ." = ".$valor."<br>\n";
		}
	}

	$Body .= "<br>";
	$Body .= "<a href=\"http://www.uosolutions.com/\" target=\"_blank\"><img src=\"http://www.uosolutions.com/argentina/image/logoweb.gif\" border=\"0\"></a>";

	$De = $Para;

	if (str_replace("'","",$_POST["Mail"])!="")
	{
		$De = str_replace("'","",$_POST["Mail"]);
	}

	function ValidarDatos($campo)
	{
		$badHeads = array("Content-Type:","MIME-Version:","Content-Transfer-Encoding:","Return-path:","Subject:","From:","Envelope-to:","To:","bcc:","cc:");

		foreach($badHeads as $valor)
		{
			if (strpos(strtolower($campo), strtolower($valor)) !== false)
			{
				header("HTTP/1.0 403 Forbidden");
				exit;
			}
		}
	}

	ValidarDatos($Para);
	ValidarDatos($De);
	ValidarDatos($Copia);
	ValidarDatos($CopiaOculta);
	ValidarDatos($Titulo);

	$Headers = "From: $De\r\n";
	if ($Copia != "")
		$Headers .= "Cc: $Copia\r\n";
	if ($CopiaOculta != "")
		$Headers .= "Bcc: $CopiaOculta\r\n";
	$Headers .= "MIME-Version: 1.0\n";
	$Headers .= "Content-type: text/html; charset=iso-8859-1";

	mail($Para, $Titulo, $Body, $Headers);

	if ($Direccion!="")
	{
		header("Location: ".$Direccion);
	}

	if ($Mensaje!="")
	{
		echo $Mensaje;
	}
}
?>