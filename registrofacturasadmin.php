<?php
require_once 'header.php';
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
                                    <th id="facturaID">Factura No.</th>
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
        <div class="tabla-menu" style="display: none;">
            <button id="guardarCambios">Guardar cambios</button>
            <button id="cancelarCambios">Cancelar</button>
        </div>
    </div>

    <script>
        var table;
        var tablaBtn = document.getElementsByClassName("tabla-menu");
        var guardar = document.getElementById('guardarCambios'); // Assumes element with id='button'
        var cancelar = document.getElementById('cancelarCambios'); // Assumes element with id='button'

        var columnID = document.getElementsByClassName('columnID');

        var bteliminar = `<button id='btnEliminar' class='btn btn-danger btn-sm rounded-0' type='button' data-toggle='tooltip' data-placement='top' title='Delete' OnClick=""><i class='fa fa-trash'></i></button>`
        $(document).ready(function() {
            table = $("#table_facturas").DataTable({
                pageLength: 10,
                "ajax": {
                    "method": "POST",
                    "url": "registrodefacturasadmindata.php",
                },
                "columns": [{
                        "data": "numero",
                        "className": "columnID"
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
                        "data": null,
                        "defaultContent": bteliminar,
                        "targets": -1
                    }
                ]
            });
        });

        var user_id, fila, respuesta;

        $("#table_facturas").on('click', '.btn-danger', function(e) {
            e.preventDefault();
            y = table
                .row($(this).parents('tr'));

            y.remove()
                .draw();

            tablaBtn[0].style.display = 'block';

            // TODO: Grab Parent element of the button clicked
            fila = $(this);
            user_id = parseInt($(this).closest('tr').find('td:eq(0)').text());
            respuesta = confirm("¿Está seguro de borrar el registro " + user_id + "?");
            console.log(user_id, respuesta)

            if (respuesta == true) {
                eliminarFactura(user_id);
            }
        });

        guardar.addEventListener("click", function() {
            // TODO: Grab parent element class columnID[].innerText
        })

        cancelar.addEventListener("click", function() {
            alert('Cancelado');
            location.reload();
        })

        function eliminarFactura(user_id) {
            console.log(`Esta mierda funciona ${user_id}`)
        }
    </script>
</body>

<?php
require_once 'footer.php';

?>

</html>