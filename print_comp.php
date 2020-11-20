<?php
require_once 'conexion.php';

$id = $_GET['id'];

$query = "SELECT enc_compra.numero, DATE_FORMAT(enc_compra.fecha, '%d/%m/%Y') AS fecha, enc_compra.id_proveedor, proveedor.nombre_proveedor, proveedor.direccion_proveedor, proveedor.telefono_proveedor, articulo.codigo_articulo, articulo.nombre_articulo, det_compra.cantidad, det_compra.precio, det_compra.descuento, det_compra.total, enc_compra.activa FROM enc_compra INNER JOIN det_compra ON det_compra.id_enc_compra = enc_compra.id INNER JOIN proveedor ON enc_compra.id_proveedor = proveedor.id INNER JOIN articulo ON det_compra.id_articulo = articulo.id WHERE enc_compra.id = ".$id;

$res = $cnn->query($query);

$det = $res->fetch_assoc();

?>
<!DOCTYPE HTML>
<html>
<head>
<title>eFact :: <?php echo $EMPRESA; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords"
	content="Easy Admin Panel Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/print.css" rel='stylesheet' media='print' />
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
<link href="css/animate.css" rel="stylesheet" type="text/css"
	media="all">
<script src="js/wow.min.js"></script>
<script>
		 new WOW().init();
</script>
<!--//end-animate-->
<!----webfonts--->
<link
	href='//fonts.googleapis.com/css?family=Cabin:400,400italic,500,500italic,600,600italic,700,700italic'
	rel='stylesheet' type='text/css'>
<!---//webfonts--->
<!-- Meters graphs -->
<script src="js/jquery-1.10.2.min.js"></script>
<!-- Placed js at the end of the document so the pages load faster -->
<link rel="shortcut icon" href="images/favicon.png">
</head>
<body>
	<div class='container' style='margin-top: 50px;'>
		<table class='table'>
				<td colspan='2' style='text-align: center;'>
					<h2><?php echo $EMPRESA; ?></h2>
					Salud y Econom&iacute;a a su alcance<br />Direcci&oacute;n: Reparto Villas de Sandino.  Bloque E-3.  Lote 4<br />Tel&eacute;fonos: 8916-0697 | 8608-7521 | Oficina: 2231-2577<br />E-mail: distribuidorajazmin@gmail.com<br />
					<h4>RUC: 287-190358-0001N</h4>
				</td>
			<tr>
				<td style='text-align: left;'>
					FACTURA No. <strong><?php echo $det["numero"]; ?></strong><br />
					<strong>COMPRA</strong>
				</td>
				<td style='text-align: right;'>FECHA: <strong><?php echo $det["fecha"]; ?></strong></td>
			</tr>
			<tr>
				<td colspan='2'>
					PROVEEDOR: <strong><?php echo $det['nombre_proveedor']; ?></strong><br />
					DIRECCI&Oacute;N: <?php echo $det['direccion_proveedor']; ?><br />
					TEL&Eacute;FONO: <?php echo $det['telefono_proveedor']; ?>
				</td>
		</table>
		<table class='table table-bordered'>
			<tr>
				<th style='width: 10%; text-align: right;'>CODIGO</th>
				<th style='width: 10%; text-align: right;'>CANTIDAD</th>
				<th style='width: 50%; text-align: left;'>DESCRIPCION</th>
				<th style='width: 15%; text-align: right;'>PRECIO U.</th>
				<th style='width: 15%; text-align: right;'>TOTAL C$</th>
			</tr>
			<?php
				$res2 = $cnn->query($query);
				$total = 0;
				while ($det = $res2->fetch_assoc()) {
					echo "<tr>";
					echo "<td style='width: 10%; text-align: right;'>".$det['codigo_articulo']."</td>";
					echo "<td style='width: 10%; text-align: right;'>".$det['cantidad']."</td>";
					echo "<td style='width: 50%; text-align: left;'>".$det['nombre_articulo']."</td>";
					echo "<td style='width: 15%; text-align: right;'>".number_format($det['precio'],2)."</td>";
					echo "<td style='width: 15%; text-align: right;'>".number_format($det['total'], 2)."</td>";
					echo "</tr>";
					$total = $total + $det['total'];
				}
			?>
			<tr>
				<td style='text-align: right;' colspan="4"><strong>TOTAL C$: </strong></td>
				<td style='text-align: right;' colspan="1"><?php echo number_format($total, 2); ?></td>
			</tr>
			<tr>
				<td colspan='5' id='ocultar'><button type='button' onclick='window.print();'>Imprimir</button></td>
			</tr>
		</table>
	</div>
</body>
</html>