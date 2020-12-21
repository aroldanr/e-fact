<?php
require_once 'header.php';
require_once 'conexion.php';
$query = "SELECT COALESCE((SELECT SUM(dv.total) AS ventas FROM enc_venta AS ev INNER JOIN det_venta AS dv ON dv.id_enc_venta = ev.id WHERE ev.estado = 1 AND ev.fecha = DATE_FORMAT(NOW(),'%Y-%m-%d')),0) AS ventas, (SELECT COUNT(id) AS productos FROM articulo) AS productos, (SELECT COUNT(id) AS clientes FROM cliente) AS clientes, (SELECT COUNT(id) AS transito FROM enc_venta WHERE estado = 0 AND fecha = DATE_FORMAT(NOW(),'%Y-%m-%d')) AS transito";
$res = $cnn->query($query);
$estadisticas = $res->fetch_array();

$query2 = "SELECT (SELECT MAX(dv.total) AS mayor_venta FROM enc_venta AS ev INNER JOIN det_venta AS dv ON ev.id = dv.id_enc_venta WHERE ev.estado = 1 AND ev.fecha = DATE_FORMAT(NOW(), '%Y-%m-%d')) AS mayor_venta, (SELECT MAX(dv.cantidad) AS mayor_venta FROM enc_venta AS ev INNER JOIN det_venta AS dv ON ev.id = dv.id_enc_venta WHERE ev.estado = 1 AND ev.fecha = DATE_FORMAT(NOW(), '%Y-%m-%d')) AS mayor_producto, (SELECT v.nombre_vendedor FROM enc_venta AS ev INNER JOIN det_venta AS dv ON ev.id = dv.id_enc_venta INNER JOIN vendedor AS v ON ev.id_vendedor = v.id WHERE ev.estado = 1 AND ev.fecha = DATE_FORMAT(NOW(), '%Y-%m-%d') GROUP BY v.nombre_vendedor HAVING MAX(dv.cantidad)) AS vendedor";
$res2 = $cnn->query($query2);
$estadisticas2 = $res2->fetch_array();

$query3 = "SELECT (SELECT MAX(dv.total) AS mayor_venta FROM enc_venta AS ev INNER JOIN det_venta AS dv ON ev.id = dv.id_enc_venta WHERE ev.estado = 1 AND ev.fecha BETWEEN DATE(CONCAT_WS('-', YEAR(ev.fecha), MONTH(ev.fecha), '1')) AND LAST_DAY(ev.fecha)) AS mayor_venta, (SELECT MAX(dv.cantidad) AS mayor_venta FROM enc_venta AS ev INNER JOIN det_venta AS dv ON ev.id = dv.id_enc_venta WHERE ev.estado = 1 AND ev.fecha BETWEEN DATE(CONCAT_WS('-', YEAR(ev.fecha), MONTH(ev.fecha), '1')) AND LAST_DAY(ev.fecha)) AS mayor_producto, (SELECT v.nombre_vendedor FROM enc_venta AS ev INNER JOIN det_venta AS dv ON ev.id = dv.id_enc_venta INNER JOIN vendedor AS v ON ev.id_vendedor = v.id WHERE ev.estado = 1 AND ev.fecha BETWEEN DATE(CONCAT_WS('-', YEAR(ev.fecha), MONTH(ev.fecha), '1')) AND LAST_DAY(ev.fecha) GROUP BY v.nombre_vendedor HAVING MAX(dv.cantidad)) AS vendedor";
/* $res3 = $cnn->query($query3);
$estadisticas3 = $res3->fetch_array(); */

$query4 = "SELECT COALESCE((SELECT SUM(dv.total) AS ventas FROM enc_venta AS ev INNER JOIN det_venta AS dv ON dv.id_enc_venta = ev.id WHERE ev.fecha = DATE_FORMAT(NOW(),'%Y-%m-%d')),0) AS ventas, (SELECT COUNT(id) AS productos FROM articulo) AS productos, (SELECT COUNT(id) AS clientes FROM cliente) AS clientes";
$res4 = $cnn->query($query4);
$estadisticas4 = $res4->fetch_array();

$fecha = new DateTime();
$fecha->modify('last day of this month');
$last_day = $fecha->format('d');
?>
<div id="page-wrapper">
    <div class="graphs">
        <div class="col_3">
            <div class="col-md-3 widget widget1">
                <div class="r3_counter_box"><i class="fa fa-mail-forward"></i>
                    <div class="stats">
                        <h5><?php echo $estadisticas['productos']; ?></h5>
                        <div class="grow">
                            <p>PRODUCTOS</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 widget widget1">
                <div class="r3_counter_box"><i class="fa fa-users"></i>
                    <div class="stats">
                        <h5><?php echo $estadisticas['clientes']; ?></h5>
                        <div class="grow grow1">
                            <p>CLIENTES</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 widget widget1">
                <div class="r3_counter_box"><i class="fa fa-eye"></i>
                    <div class="stats">
                        <h5><?php echo $estadisticas['transito']; ?></h5>
                        <div class="grow grow3">
                            <p>TRÁNSITO</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 widget">
                <div class="r3_counter_box"><i class="fa fa-usd"></i>
                    <div class="stats">
                        <h5><?php echo 'C$ ' . number_format($estadisticas['ventas'], 2); ?></h5>
                        <div class="grow grow2">
                            <p>VENTAS</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- switches -->
        <div class="switches">
            <div class="col-4">
                <div class="col-md-4 switch-right">
                    <div class="switch-right-grid">
                        <div class="switch-right-grid1">
                            <h3>ESTADÍSTICAS DE HOY</h3>
                            <p>Ventas realizadas el <?php echo date('d/m/Y'); ?>.</p>
                            <ul>
                                <li>Mayor Venta: <?php echo 'C$ ' . number_format($estadisticas2['mayor_venta'], 2); ?></li>
                                <li>Productos Vendidos: <?php echo number_format($estadisticas2['mayor_producto']); ?></li>
                                <li>Vendedor: <?php echo $estadisticas2['vendedor']; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 switch-right">
                    <div class="switch-right-grid">
                        <div class="switch-right-grid1">
                            <h3>ESTADÍSTICAS DEL MES</h3>
                            <p>Ventas mensuales del <?php echo '01/' . date('m/Y') . ' al ' . $last_day . '/' . date('m/Y'); ?>.</p>
                            <ul>
                                <li>Mayor Venta: <?php echo 'C$ ' . number_format($estadisticas3['mayor_venta'], 2); ?></li>
                                <li>Productos Vendidos: <?php echo number_format($estadisticas3['mayor_producto']); ?></li>
                                <li>Vendedor: <?php echo $estadisticas3['vendedor']; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 switch-right">
                    <div class="switch-right-grid">
                        <div class="switch-right-grid1">
                            <h3>ESTADÍSTICAS GENERALES</h3>
                            <p>Ventas totales al <?php echo date('d/m/Y'); ?>.</p>
                            <ul>
                                <li><?php echo 'Ventas Totales: C$ ' . number_format($estadisticas4['ventas'], 2); ?></li>
                                <li><?php echo 'Clientes: ' . $estadisticas4['clientes']; ?></li>
                                <li><?php echo 'Existencia: ' . $estadisticas4['productos'] . ' productos.'; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-12">
                <img style="margin-top: 20px; width: 100%; height: 200px;" src="images/banner.jpg" alt="Banner" />
            </div>
        </div>
        <!-- //switches -->
    </div>
    <!--body wrapper start--></div>
<!--body wrapper end-->
</div>
<?php
require_once 'footer.php';
?>