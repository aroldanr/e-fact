<?php
require_once 'header2.php';
$mode = isset($_REQUEST['f_mode']) ? $_REQUEST['f_mode'] : "";

?>

<html lang="en">

<body>
    <br><br>
    <div class="container">
        <h2>Registro de Facturas</h2>
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">Administracion</div>
                <div class="row">
                    <div class="col-lg-12">
                        <table id="table_facturas" class="table table-bordered  display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Factura No.</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Vendedor</th>
                                    <th>Estado</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {


            var table = $("#table_facturas").DataTable({
                pageLength: 10,

                "ajax": {
                    "method": "POST",
                    "url": "registrodefacturasadmindata.php",

                },
                "columns": [{
                        "data": "numero"
                    },
                    {
                        "data": "fecha"
                    },
                    {
                        "data": "nombre_cliente"
                    },
                    {
                        "data": "nombre_vendedor"
                    },
                    {
                        "data": "estado"
                    },
                    {
                        "data": "estado"
                    }
                ]
            });

        });
    </script>


</body>

<?php
require_once 'footer.php';

?>

</html>