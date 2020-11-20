<?php
require_once 'conexion.php';

$dia_ini = substr($_POST['fec_ini'], 8);
$mes_ini = substr($_POST['fec_ini'], 5, 2);
$anio_ini = substr($_POST['fec_ini'], 0, 4);
$fec_ini = $dia_ini . '/' . $mes_ini . '/' . $anio_ini;

$dia_fin = substr($_POST['fec_fin'], 8);
$mes_fin = substr($_POST['fec_fin'], 5, 2);
$anio_fin = substr($_POST['fec_fin'], 0, 4);
$fec_fin = $dia_fin . '/' . $mes_fin . '/' . $anio_fin;

if ($_POST['estado'] == -1) {
    $query = "SELECT CAST(a.numero AS UNSIGNED INTEGER) AS numero, DATE_FORMAT(a.fecha,'%d/%m/%Y') AS fecha, CONCAT_WS(' ', c.nombre1_cliente, c.nombre2_cliente, c.apellido1_cliente, c.apellido2_cliente) AS nombre_cliente, d.nombre_vendedor, SUM(b.total) AS total, (CASE WHEN a.estado = 1 THEN 'Cancelada' ELSE 'Pendiente' END) AS estado FROM enc_venta AS a INNER JOIN det_venta AS b ON b.id_enc_venta = a.id INNER JOIN cliente AS c ON a.id_cliente = c.id INNER JOIN vendedor AS d ON a.id_vendedor = d.id WHERE a.activa = 'SI' AND a.fecha BETWEEN '" . $_POST['fec_ini'] . "' AND '" . $_POST['fec_fin'] . "' GROUP BY a.numero, a.fecha, c.nombre1_cliente, c.nombre2_cliente, c.apellido1_cliente, c.apellido2_cliente, d.nombre_vendedor, a.estado ORDER BY CAST(a.numero AS UNSIGNED INTEGER) DESC, a.fecha DESC";
} else {
    if ($_POST['vendedor'] == 0) {
        $query = "SELECT CAST(a.numero AS UNSIGNED INTEGER) AS numero, DATE_FORMAT(a.fecha,'%d/%m/%Y') AS fecha, CONCAT_WS(' ', c.nombre1_cliente, c.nombre2_cliente, c.apellido1_cliente, c.apellido2_cliente) AS nombre_cliente, d.nombre_vendedor, SUM(b.total) AS total, (CASE WHEN a.estado = 1 THEN 'Cancelada' ELSE 'Pendiente' END) AS estado FROM enc_venta AS a INNER JOIN det_venta AS b ON b.id_enc_venta = a.id INNER JOIN cliente AS c ON a.id_cliente = c.id INNER JOIN vendedor AS d ON a.id_vendedor = d.id WHERE a.activa = 'SI' AND a.fecha BETWEEN '" . $_POST['fec_ini'] . "' AND '" . $_POST['fec_fin'] . "' AND a.estado = " . $_POST['estado'] . " GROUP BY a.numero, a.fecha, c.nombre1_cliente, c.nombre2_cliente, c.apellido1_cliente, c.apellido2_cliente, d.nombre_vendedor, a.estado ORDER BY CAST(a.numero AS UNSIGNED INTEGER) DESC, a.fecha DESC";
    } else {
        $query = "SELECT CAST(a.numero AS UNSIGNED INTEGER) AS numero, DATE_FORMAT(a.fecha,'%d/%m/%Y') AS fecha, CONCAT_WS(' ', c.nombre1_cliente, c.nombre2_cliente, c.apellido1_cliente, c.apellido2_cliente) AS nombre_cliente, d.nombre_vendedor, SUM(b.total) AS total, (CASE WHEN a.estado = 1 THEN 'Cancelada' ELSE 'Pendiente' END) AS estado FROM enc_venta AS a INNER JOIN det_venta AS b ON b.id_enc_venta = a.id INNER JOIN cliente AS c ON a.id_cliente = c.id INNER JOIN vendedor AS d ON a.id_vendedor = d.id WHERE a.activa = 'SI' AND a.fecha BETWEEN '" . $_POST['fec_ini'] . "' AND '" . $_POST['fec_fin'] . "' AND a.id_vendedor = " . $_POST['vendedor'] . " AND a.estado = " . $_POST['estado'] . " GROUP BY a.numero, a.fecha, c.nombre1_cliente, c.nombre2_cliente, c.apellido1_cliente, c.apellido2_cliente, d.nombre_vendedor, a.estado ORDER BY CAST(a.numero AS UNSIGNED INTEGER) DESC, a.fecha DESC";
    }
}

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
                <tr><td colspan='2' style='text-align: center;'>
                        <h2><?php echo $EMPRESA; ?></h2>
                        Salud y Econom&iacute;a a su alcance<br />
                        Direcci&oacute;n: Reparto Villas de Sandino.  Bloque E-3.  Lote 4<br />
                        Tel&eacute;fonos: 8916-0697 | 8608-7521 | Oficina: 2231-2577<br />
                        E-mail: distribuidorajazmin@gmail.com<br />
                        <h4>RUC: 287-190358-0001N</h4>
                    </td></tr>
                <tr>
                    <td align='center'>
                        <h3>REPORTE DE FACTURACIÓN POR PERÍODOS</h3>
                        <p>
                            <?php
                            if ($_POST['estado'] == -1) {
                                $subtitulo = 'FACTURAS CANCELADAS Y PENDIENTES DE PAGO DEL ' . $fec_ini . ' AL ' . $fec_fin;
                            } else {
                                $subtitulo = 'FACTURAS ' . ($_POST['estado'] == 0 ? 'PENDIENTES DE PAGO ' : 'CANCELADAS ') . ' DEL ' . $fec_ini . ' AL ' . $fec_fin;
                            }
                            echo $subtitulo;
                            ?>
                        </p>
                    </td>
                </tr>
            </table>
            <table class='table table-bordered'>
                <tr style='background-color: lightsteelblue'>
                    <th style='width: 10%; text-align: right;'>FACT. No.</th>
                    <th style='width: 10%; text-align: center;'>FECHA</th>
                    <th style='width: 10%; text-align: left;'>ESTADO</th>
                    <th style='width: 25%; text-align: left;'>VENDEDOR</th>
                    <th style='width: 30%; text-align: left;'>CLIENTE</th>
                    <th style='width: 15%; text-align: right;'>TOTAL C$</th>
                </tr>
                <?php
                $res2 = $cnn->query($query);
                $total = 0;
                while ($fila = $res2->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='width: 10%; text-align: right;'>" . $fila['numero'] . "</td>";
                    echo "<td style='width: 10%; text-align: center;'>" . $fila['fecha'] . "</td>";
                    echo "<td style='width: 10%; text-align: left;'>" . $fila['estado'] . "</td>";
                    echo "<td style='width: 25%; text-align: left;'>" . $fila['nombre_vendedor'] . "</td>";
                    echo "<td style='width: 30%; text-align: left;'>" . $fila['nombre_cliente'] . "</td>";
                    echo "<td style='width: 15%; text-align: right;'>" . number_format($fila['total'], 2) . "</td>";
                    echo "</tr>";
                    $total = $total + $fila['total'];
                }
                ?>
                <tr style='background-color: lightsteelblue'>
                    <td style='text-align: right;' colspan="5"><strong>TOTAL C$: </strong></td>
                    <td style='text-align: right;' colspan="1"><?php echo '<strong>' . number_format($total, 2) . '</strong>'; ?></td>
                </tr>
                <tr>
                    <td colspan='6' id='ocultar'><button type='button' onclick='window.print();'>Imprimir</button></td>
                </tr>
            </table>
        </div>
    </body>
</html>