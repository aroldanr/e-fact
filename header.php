<?php
header('Content-Type: text/html; charset=utf-8');
include_once 'conexion.php';
?>
<!DOCTYPE HTML>
<html>

<head>

	<title>eFact: <?php

					echo $EMPRESA;
					?></title>
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
	<link rel="shortcut icon" href="images/favicon.png">

	<!-- Select2 -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

	<!--DAtatable-->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>

</head>

<body class="sticky-header left-side-collapsed">
	<section>
		<!-- left side start-->
		<div class="left-side sticky-left-side">

			<!--logo and iconic logo start-->
			<div class="logo">
				<h1>
					<a href="main.php">e<span>Fact</span></a>
				</h1>
			</div>
			<div class="logo-icon text-center">
				<a href="main.php"><i class="lnr lnr-home"></i> </a>
			</div>

			<!--logo and iconic logo end-->
			<div class="left-side-inner">

				<!--sidebar nav start-->
				<ul class="nav nav-pills nav-stacked custom-nav">
					<li class="menu-list"><a href="#"><i class="lnr lnr-list"></i> <span>Cat&aacute;logos</span></a>
						<ul class="sub-menu-list">
							<li><a href="vendedor.php">Vendedores</a></li>
							<li><a href="cliente.php">Clientes</a></li>
							<li><a href="proveedor.php">Proveedores</a></li>
							<li><a href="categoria.php">Categor&iacute;as</a></li>
							<li><a href="articulo.php">Productos</a></li>
						</ul>
					</li>
					<li class="menu-list"><a href="#"><i class="lnr lnr-cog"></i> <span>Procesos</span></a>
						<ul class="sub-menu-list">
							<li><a href="factura.php">Facturaci&oacute;n</a></li>
							<li><a href="registrofacturasadmin.php">Registro Factura</a></li>
							<li><a href="compra.php">Compras</a></li>
						</ul>
					</li>
					<li class="menu-list"><a href="#"><i class="lnr lnr-printer"></i> <span>Reportes</span></a>
						<ul class="sub-menu-list">
							<li><a href="pr01.php">Facturaci&oacute;n por per&iacute;odos</a></li>
							<li><a href="r02.php">Listado de Clientes</a></li>
							<li><a href="r03.php">Listado de Proveedores</a></li>
							<li><a href="r04.php">Listado de Vendedores</a></li>
						</ul>
					</li>
					<li><a href="usuario.php"><i class="lnr lnr-users"></i> <span>Usuarios</span></a></li>
					<li><a href="logout.php"><i class="lnr lnr-exit"></i> <span>Salir</span></a></li>
				</ul>
				<!--sidebar nav end-->
			</div>
		</div>
		<!-- left side end-->

		<!-- main content start-->
		<div class="main-content">
			<!-- header-starts -->
			<div class="header-section">

				<!--toggle button start-->
				<a class="toggle-btn  menu-collapsed"><i class="fa fa-bars"></i></a>
				<!--toggle button end-->

				<!--notification menu start -->
				<div class="menu-right">
					<div class="user-panel-top">
						<div class="profile_details_left">
							<ul class="nofitications-dropdown">
								<li>
									<h2><?php

										echo $EMPRESA;
										?></h2>
								</li>
								<li class="login_box" id="loginContainer"></li>
								<div class="clearfix"></div>
							</ul>
						</div>
						<div class="profile_details">
							<ul>
								<li class="dropdown profile_details_drop"><a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<div class="profile_img">
											<span style="background: url(images/8.png) no-repeat center">
											</span>
											<div class="user-name">
												<p>
													<?php
													@session_start();
													//echo $_SESSION['usuario'];
													?>
													<span>Administrador</span>
												</p>
											</div>
											<i class="lnr lnr-chevron-down"></i> <i class="lnr lnr-chevron-up"></i>
											<div class="clearfix"></div>
										</div>
									</a>
									<ul class="dropdown-menu drp-mnu">
										<li><a href="usuario.php"><i class="fa fa-cog"></i> Perfiles</a></li>
										<li><a href="logout.php"><i class="fa fa-sign-out"></i> Salir</a></li>
									</ul>
								</li>
								<div class="clearfix"></div>
							</ul>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<!--notification menu end -->
			</div>
			<!-- //header-ends -->