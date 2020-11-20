<?php
require_once 'header.php';
require_once 'conexion.php';

$res = $cnn->query("SELECT id, nombre_vendedor FROM vendedor ORDER BY nombre_vendedor ASC");
?>
<div class="container" style="margin-top: 50px;">
    <div class="row">
        <div class="col-sm-3">&nbsp;</div>
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading"><h3>REPORTE DE FACTURACIÓN POR PERÍODOS</h3></div>
                <form class="form-horizontal" method="POST" action="r01.php" target="_blank">
                    <div class="panel-body">

                        <div class="form-group-sm">
                            <label class="control-label col-sm-4" for="fec_ini">Fecha Inicial:</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="fec_ini" id="fec_ini" required>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="form-group-sm">
                            <label class="control-label col-sm-4 for="fec_fin">Fecha Final:</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="fec_fin" id="fec_fin" required>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="form-group-sm">
                            <label class="control-label col-sm-4 for="fec_fin">Vendedor:</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="vendedor" id="vendedor">
                                    <option value="0">-- Todos --</option>
                                    <?php
                                    while ($fila = $res->fetch_assoc()) {
                                        echo '<option value="' . $fila['id'] . '">' . $fila['nombre_vendedor'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="form-group-sm">
                            <label class="control-label col-sm-4 for="estado">Estado:</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="estado" id="estado">
                                    <option value="-1">-- Todas --</option>
                                    <option value="1">Canceladas</option>
                                    <option value="0">Pendientes de pago</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary btn-sm">Generar Reporte</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-3">&nbsp;</div>
        </div>
    </div>
    <?php require_once 'footer.php'; ?>