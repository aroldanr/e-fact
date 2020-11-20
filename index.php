<?php
require_once 'conexion.php';

if ($_POST) {
	$query = "SELECT id, id_rol FROM usuario WHERE nombre_usuario = '" . $_POST['usuario'] . "'";

	$res = $cnn->query($query);

	if ($res->num_rows > 0) {
		$query2 = "SELECT id, id_rol FROM usuario WHERE clave_usuario = '" . md5($_POST['clave']) . "'";
		$res2 = $cnn->query($query2);
		if ($res2->num_rows > 0) {
			$fila = $res->fetch_array();
			if ($fila['id_rol'] == 1) {
				session_start();
				$_SESSION['id'] = $fila['id'];
				$_SESSION['usuario'] = $_POST['usuario'];
				header('Location: main.php');
			} else {
				$query3 = "SELECT id, nombre_vendedor FROM vendedor WHERE id_usuario = " . $fila['id'];
				$res2 = $cnn->query($query3);
				$fila2 = $res2->fetch_array();
				session_start();
				$_SESSION['id'] = $fila2['id'];
				$_SESSION['usuario'] = $fila2['nombre_vendedor'];
				header('Location: invoice.php');
			}
		} else {
			header('Location: index.php');
		}
	} else {
		header('Location: index.php');
	}
}
?>
<!DOCTYPE HTML>
<html>

<head>
	<title>eFact :: DISTRIBUIDORA JAZMÍN</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Easy Admin Panel Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
	<script type="application/x-javascript">
		addEventListener("load", function() {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
	<!-- Custom CSS -->
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<!-- Graph CSS -->
	<link href="css/font-awesome.css" rel="stylesheet">
	<!-- jQuery -->
	<!-- lined-icons -->
	<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
	<!-- //lined-icons -->
	<!-- chart -->
	<script src="js/Chart.js"></script>
	<!-- //chart -->
	<!--animate-->
	<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
	<script src="js/wow.min.js"></script>
	<script>
		new WOW().init();
	</script>
	<!--//end-animate-->
	<!----webfonts--->
	<link href='//fonts.googleapis.com/css?family=Cabin:400,400italic,500,500italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
	<!---//webfonts--->
	<!-- Meters graphs -->
	<script src="js/jquery-1.10.2.min.js"></script>
	<!-- Placed js at the end of the document so the pages load faster -->

</head>

<body class="sign-in-up">
	<section>
		<div id="page-wrapper" class="sign-in-wrapper">
			<div class="graphs">
				<div class="sign-in-form">
					<div class="sign-in-form-top">
						<p><span>Ingreso a </span> <a href="index.html">eFact</a></p>
					</div>
					<div class="signin">
						<form action="index.php" method="post">
							<div class="log-input">
								<div class="log-input-left">
									<input type="text" name="usuario" class="user" value="Tu Usuario" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Nombre de Usuario:';}" />
								</div>
								<div class="clearfix"> </div>
							</div>
							<div class="log-input">
								<div class="log-input-left">
									<input type="password" name="clave" class="lock" value="password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'password:';}" />
								</div>
								<div class="clearfix"> </div>
							</div>
							<input type="submit" value="Acceder a eFact">
						</form>
					</div>
				</div>
			</div>
		</div>
		<!--footer section start-->
		<footer>
			<p>&copy <?php echo date('Y'); ?> eFact. All Rights Reserved | Developed by <a href="http://www.anthony-palma.com/" target="_blank">APZ</a></p>
		</footer>
		<!--footer section end-->
	</section>

	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.min.js"></script>
</body>

</html>