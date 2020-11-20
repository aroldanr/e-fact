<?php
require_once 'conexion.php';

$id = $_GET['id'];

$query = "SELECT enc_venta.numero, DATE_FORMAT(enc_venta.fecha, '%d/%m/%Y') AS fecha, enc_venta.id_cliente, CONCAT_WS(' ', cliente.nombre1_cliente, cliente.nombre2_cliente, cliente.apellido1_cliente, cliente.apellido2_cliente) AS nombre_cliente, cliente.direccion_cliente, cliente.telefono_cliente, enc_venta.id_vendedor, vendedor.nombre_vendedor, articulo.codigo_articulo, articulo.nombre_articulo, det_venta.cantidad, det_venta.precio, det_venta.descuento, det_venta.total, enc_venta.activa, (CASE WHEN enc_venta.estado = 0 THEN 'PENDIENTE' ELSE 'CANCELADA' END) AS estado FROM enc_venta INNER JOIN det_venta ON det_venta.id_enc_venta = enc_venta.id INNER JOIN cliente ON enc_venta.id_cliente = cliente.id INNER JOIN vendedor ON enc_venta.id_vendedor = vendedor.id INNER JOIN articulo ON det_venta.id_articulo = articulo.id WHERE enc_venta.id = ".$id;

$res = $cnn->query($query);

$fila = $res->fetch_assoc();

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
					Salud y Econom&iacute;a a su alcance<br />
					Direcci&oacute;n: Reparto Villas de Sandino.  Bloque E-3.  Lote 4<br />
					Tel&eacute;fonos: 8916-0697 | 8608-7521 | Oficina: 2231-2577<br />
					E-mail: distribuidorajazmin@gmail.com<br />
					<h4>RUC: 287-190358-0001N</h4>
				</td>
			<tr>
				<td style='text-align: left;'>
					FACTURA No. <strong><?php echo $fila["numero"]; ?></strong><br />
					<strong>VENTA</strong>
				</td>
				<td style='text-align: right;'>
					FECHA: <strong><?php echo $fila["fecha"]; ?></strong><br />
					<strong><?php echo $fila['estado']; ?></strong>
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					CLIENTE: <strong><?php echo $fila['nombre_cliente']; ?></strong><br />
					DIRECCI&Oacute;N: <?php echo $fila['direccion_cliente']; ?><br />
					TEL&Eacute;FONO: <?php echo $fila['telefono_cliente']; ?>
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
				while ($fila = $res2->fetch_assoc()) {
					echo "<tr>";
					echo "<td style='width: 10%; text-align: right;'>".$fila['codigo_articulo']."</td>";
					echo "<td style='width: 10%; text-align: right;'>".$fila['cantidad']."</td>";
					echo "<td style='width: 50%; text-align: left;'>".$fila['nombre_articulo']."</td>";
					echo "<td style='width: 15%; text-align: right;'>".number_format($fila['precio'],2)."</td>";
					echo "<td style='width: 15%; text-align: right;'>".number_format($fila['total'], 2)."</td>";
					echo "</tr>";
					$total = $total + $fila['total'];
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