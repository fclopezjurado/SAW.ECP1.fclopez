<HTML>
	<HEAD>
		<title>Matrícula de asignaturas</title>
		<meta charset="UTF-8">
	</HEAD>
	<body>

		<?php
//		session_start();
//		include ("includes/autenticado.php");

		if (isset($_POST['Envio'])) {

			// GUARDAR EN UN FICHERO LA FIRMA JUNTO CON EL CERTIFICADO (FORMATO PKCS7)
			$numero = uniqid();
			$nombreFirma = "firmas/firma_" . $numero . ".pem";
			$fp = fopen($nombreFirma, "w");
			fwrite($fp, "-----BEGIN PKCS7-----\n");
			fwrite($fp, $_POST['firma']);
			fwrite($fp, "\n-----END PKCS7-----");
			fclose($fp);

			// GUARDAR EN UN FICHERO EL MENSAJE RECIBIDO EN EL FORMULARIO
			$texto = "";
			if (isset($_POST['IWVG'])) {
				$texto = $texto . "IWVG=" . $_POST['IWVG'];
			}
			if (isset($_POST['APAW'])) {
				$texto = $texto . "APAW=" . $_POST['APAW'];
			}
			if (isset($_POST['FEM'])) {
				$texto = $texto . "FEM=" . $_POST['FEM'];
			}
			if (isset($_POST['FENW'])) {
				$texto = $texto . "FENW=" . $_POST['FENW'];
			}
			if (isset($_POST['PHP'])) {
				$texto = $texto . "PHP=" . $_POST['PHP'];
			}
			if (isset($_POST['SAW'])) {
				$texto = $texto . "SAW=" . $_POST['SAW'];
			}

			$nombreTexto = "firmas/texto_" . $numero . ".txt";
			$ft = fopen($nombreTexto, "w");
			fwrite($ft, $texto);
			fclose($ft);

			// TODO 12: comprobar firma con el comando smime DE OpenSSL
			// OJO, cuidado con los slash(/). Si utilizas '\' lo considera como
			// un carácter de escape dentro de las cadenas y tendrás problemas.
			
			// TODO 13: Si la firma es correcta, comprobar que el usuario firmante
			//  coincide con el usuario autenticado.

			
			
			// SI LA FIRMA ES CORRECTA, HACER EFECTIVA LA MATRICULA (ya hecho a continuación)
					if (isset($_POST['IWVG'])) {
						$_SESSION['permisos'][0] = 'S';
					}
					if (isset($_POST['APAW'])) {
						$_SESSION['permisos'][1] = 'S';
					}
					if (isset($_POST['FEM'])) {
						$_SESSION['permisos'][2] = 'S';
					}
					if (isset($_POST['FENW'])) {
						$_SESSION['permisos'][3] = 'S';
					}
					if (isset($_POST['PHP'])) {
						$_SESSION['permisos'][4] = 'S';
					}
					if (isset($_POST['SAW'])) {
						$_SESSION['permisos'][5] = 'S';
					}
					include ("includes/abrirbd.php");
					$permisos = implode($_SESSION['permisos']);
					$sql = "UPDATE usuarios SET permisos = '{$permisos}' WHERE user ='{$_SESSION['user']}'";
					$resultado = mysqli_query($link, $sql);

					echo ("<h3><b>Matrícula realizada correctamente:</h3></b>");
					if (isset($_POST['IWVG'])) {
						echo ("Ingeniería Web: Visión General <br>");
					}
					if (isset($_POST['APAW'])) {
						echo ("Arquitectura y Patrones para Aplicaciones Web <br>");
					}
					if (isset($_POST['FEM'])) {
						echo ("Front-end para Móviles <br>");
					}
					if (isset($_POST['FENW'])) {
						echo ("Front-end para Navegadores Web <br>");
					}
					if (isset($_POST['PHP'])) {
						echo ("Back-end con Tecnologías de Libre Distribución <br>");
					}
					if (isset($_POST['SAW'])) {
						echo ("Seguridad en Aplicaciones Web <br>");
					}
				
			
			?>
			<br><br><A href= 'MasterWeb.php'> Volver a inicio </A>

			<?php
			
			
		} else {
			?>
			<SCRIPT type="text/JavaScript">
				function firmarFormulario(){
				var texto="";
				if (matricula.IWVG.checked) texto = texto + "IWVG=" + matricula.IWVG.value;
				if (matricula.APAW.checked) texto = texto + "APAW=" + matricula.APAW.value;
				if (matricula.FEM.checked) texto = texto + "FEM=" + matricula.FEM.value;
				if (matricula.FENW.checked) texto = texto + "FENW=" + matricula.FENW.value;
				if (matricula.PHP.checked) texto = texto + "PHP=" + matricula.PHP.value;
				if (matricula.SAW.checked) texto = texto + "SAW=" + matricula.SAW.value;
				firma = window.crypto.signText (texto, "ask");
				matricula.firma.value = firma;
				return true;
				}
			</SCRIPT>
		<center>
			<img src="logo.png" width= 120 height= 60>
			<br><br><br>
			<H2> Selecciona las asignaturas en que quieres matricularte </H2><BR><BR>
			<FORM name="matricula" method=post action=matricula.php onSubmit="firmarFormulario()">
				<TABLE>
					<TR>
						<TD align=right><INPUT type="checkbox" name="IWVG" value="Si"></TD>
						<TD align=left> Ingeniería Web: Visión General (IWVG)</TD>
					</TR>
					<TR>
						<TD align=right><INPUT type="checkbox" name="APAW" value="Si"></TD>
						<TD align=left> Arquitectura y Patrones para Aplicaciones Web (APAW)</TD>
					</TR>
					<TR>
						<TD align=right><INPUT type="checkbox" name="FEM" value="Si"></TD>
						<TD align=left> Front-end para Móviles (FEM)</TD>
					</TR>
					<TR>
						<TD align=right><INPUT type="checkbox" name="FENW" value="Si"></TD>
						<TD align=left> Front-end para Navegadores Web (FENW)</TD>
					</TR><TR>
						<TD align=right><INPUT type="checkbox" name="PHP" value="Si"></TD>
						<TD align=left> Back-end con Tecnologías de Libre Distribución (PHP)</TD>
					</TR><TR>
						<TD align=right><INPUT type="checkbox" name="SAW" value="Si"></TD>
						<TD align=left> Seguridad en Aplicaciones Web (SAW)</TD>
					</TR>
				</TABLE><BR>
				<INPUT type="hidden" name="firma">
				<INPUT type="submit" name="Envio" value="Firmar y Enviar">
			</FORM>
		</CENTER>
		<?php
	}
	?>
</BODY>
</HTML>

