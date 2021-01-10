<?php
require_once 'header.php';
$mode = isset($_REQUEST['f_mode']) ? $_REQUEST['f_mode'] : "";

?>

<html lang="en">

<!-- 
<head>

  <script>
    $(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>

</head> -->

<body>
  <div class="container" style="background-color: white; margin-top: 5rem;">
    <h2>Registro de Facturas</h2>
    <p>Registros marcados con un * son requeridos</p>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Campo</th>
          <th>Valor del Campo</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Factura No.</td>

          <?php
          $consecutivodata = "SELECT numero FROM enc_venta ORDER BY id DESC LIMIT 1";
          $Objconsecutivo = mysqli_query($cnn, $consecutivodata) or die(mysql_error($cnn));
          $resul = mysqli_fetch_assoc($Objconsecutivo);

          $consecutivo = substr($resul['numero'], 0, 4);

          $sumaconsecutivo = intval($consecutivo + 1);
          $count = 2;
          $digits = 10;
          $start = $resul['numero'];

          for ($n = $start; $n < $start + $count; $n++) {
            $result = str_pad($n, $digits, "0", STR_PAD_LEFT);
          }
          ?>
          <td><input id="txtNoFactura" value="<?php echo $result; ?>" class="form-control" readonly></td>
        </tr>
        <tr>
          <td>Fecha</td>

          <td><input type="date" class="form-control" id="start" name="txtfecha"></td>
        </tr>
        <tr>
          <td>Cliente</td>
          <td>
            <select id="dropcliente" style="width: 100%" class="js-example-basic-single js-states" name="dropcliente">

              <?php
              // include 'conexion.php';  
              $clientedata = "SELECT concat(nombre1_cliente,' ',nombre2_cliente,' ',apellido1_cliente,' ',apellido2_cliente) as nombre_cliente, id FROM cliente";
              $Objcliente = mysqli_query($cnn, $clientedata) or die(mysql_error($cnn));
              ?>

              <?php foreach ($Objcliente as $opciones) : ?>
                <option class="form-control" value="<?php echo $opciones['id'] ?>"><?php echo $opciones['nombre_cliente'] ?></option>
              <?php endforeach ?>

            </select>
          </td>
        </tr>
        <tr>
          <td>Vendedor</td>
          <td>

            <select name="dropvendedor" id="dropvendedor" style="width: 100%" class="js-example-basic-single js-states">
              <?php
              // include 'conexion.php';
              $vendedordata = "SELECT nombre_vendedor,id FROM vendedor";
              $Objvendedor = mysqli_query($cnn, $vendedordata) or die(mysql_error($cnn));
              ?>

              <?php foreach ($Objvendedor as $itemsvendedor) : ?>
                <option class="form-control" value="<?php echo $itemsvendedor['id'] ?>"><?php echo $itemsvendedor['nombre_vendedor'] ?></option>
              <?php endforeach ?>
            </select>

          </td>
        </tr>
        <tr>
          <td>Activa</td>
          <td>

          </td>
        </tr>

        <tr>
          <td>Cancelada</td>
          <td>

          </td>
        </tr>

      </tbody>
    </table>
  </div>

  <div class="container">
    <h2>Detalle Ventas por productos</h2>
    <div class="panel-group">
      <div class="panel panel-primary">
        <div class="panel-heading">Registros marcados con un * son requeridos</div>
        <div class="panel-body">
          <form>
            <table class="table table-bordered">

              <thead>
                <tr>
                  <th>Campo</th>
                  <th>Valor</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <?php $codigoproducto = "12345" ?>
                  <td>Codigo de producto</td>
                  <td>
                    <div class="input-group" style="margin:0em">
                      <input type="number" class="form-control" id="txtcodigoproducto" placeholder="Codigo de Producto">
                      <div class="input-group-btn">
                        <!-- <button class="btn btn-default" type="submit" onclick="loadproductinfo(<?php echo $codigoproducto; ?>);"> -->
                        <button class="btn btn-default" type="submit" id="searcharticle">
                          <i class="glyphicon glyphicon-search"></i>
                        </button>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Nombre</td>
                  <td>
                    <input id="txtnombreP" type="text" class="form-control" name="txtnombreP" placeholder="Nombre" readonly>
                    <input id="idp" class="form-control" type="hidden">
                  </td>
                </tr>
                <tr>
                  <td>Disponible</td>
                  <td>
                    <input id="txtcantidad" type="number" class="form-control" name="txtcantidad" placeholder="Disponible" readonly>
                  </td>
                </tr>
                <tr>
                  <td>Deseado</td>
                  <td>
                    <input id="txtdeseado" type="number" class="form-control" min="1" max=`50` name="txtdeseado" placeholder="Cantidad">
                  </td>
                </tr>
                <tr>
                  <td>Precio</td>
                  <td><input type="text" class="form-control" id="txtprecio" placeholder="Precio" readonly></td>
                </tr>
                <tr>
                  <td>Descuento</td>
                  <td><input type="number" class="form-control" placeholder="Descuento" min="1" max="50" step="1" id="txtdescuento"></td>
                </tr>
              </tbody>
            </table>

            <div class="row">
              <div class="col-sm-6">
                <button id="btnagregarproducto" class="btn btn-primary">Agregar Producto</button>
              </div>
              <div class="col-sm-6">
                <input type="number" class="form-control" id="txttotalvalue" value="0">
              </div>

            </div>
            <br><br>
            <div class="row">
              <div class="col-lg-12">
                <table id="table_productos" class="table table-bordered  display nowrap" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Codigo</th>
                      <th>Nombre</th>
                      <th>Cantidad</th>
                      <th>Precio</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>

            </br></br>
            <div class="form-row">
              <div class="col-md-6">
                <button id="brnguardarfactura" class="btn btn-primary">Guardar</button>
              </div>

            </div>

          </form>

        </div>
      </div>

    </div>
  </div>

  <script>
    var now = new Date();

    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);

    var today = now.getFullYear() + "-" + (month) + "-" + (day);

    $('#start').val(today);
  </script>

  <script>
    var tablaListado;
    var editor;
    var dataSet;
    var objetofacturajson;
    var jsonn;

    var tablalistadosdata;
    var objfactura;

    $(document).ready(function() {
      dataSet = [];
      objetofacturajson = [];
      jsonn = "";

      tablaListado = $("#table_productos").DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
          'print'
        ],
        "ordering": false,
        paging: false,
        scrollY: 400,

      });


      // Pushing the data from the inputs to the Datatable
      $('#btnagregarproducto').click(function(e) {
        e.preventDefault();
        e.stopPropagation();

        var idp = document.getElementById("idp").value;
        var NombreP = document.getElementById("txtnombreP").value;
        var CantidadP = document.getElementById("txtdeseado").value;
        var PrecioP = document.getElementById("txtprecio").value;
        var DescuentoP = document.getElementById("txtdescuento").value;
        var tot = document.getElementById("txttotalvalue").value;

        $('#txttotalvalue').val(parseFloat(tot) + parseFloat(PrecioP));

        var bteliminar = `<button id='btnEliminar' class='btn btn-danger btn-sm rounded-0' type='button' data-toggle='tooltip' data-placement='top' title='Delete' OnClick="eliminar()"><i class='fa fa-trash'></i></button>`

        tablaListado.row.add([
          idp,
          NombreP,
          CantidadP,
          PrecioP,
          bteliminar
        ]).draw(false);

      });

      // Save the DataTable on the Database
      $('#brnguardarfactura').click(function(e) {
        e.preventDefault();
        var objDatosColumna;
        // Let's put this in the object like you want and convert to JSON (Note: jQuery will also do  this for you on the Ajax request)
        tableToJSON($("#table_productos"));

        function tableToJSON(tblObj) {
          var data = [];
          var $headers = $(tblObj).find("th");
          var $rows = $(tblObj).find("tbody tr").each(function(index) {
            $cells = $(this).find("td");
            data[index] = {};
            $cells.each(function(cellIndex) {
              data[index][$($headers[cellIndex]).text()] = $(this).text();
            });
          });
          objDatosColumna = JSON.stringify(data);
        }

        var opt = 2;
        $.ajax({
          type: "POST",
          url: "dataarticulo.php",
          data: {
            objDatosColumna: objDatosColumna,
            option: opt,
            idcliente: document.getElementById("dropcliente").value,
            idvendedor: document.getElementById("dropvendedor").value,
            numerofactura: document.getElementById("txtNoFactura").value,
            fechafactura: document.getElementById("start").value
          },
          success: function(data) {
            console.log(objDatosColumna);
            alert(data);
            // reloadpage();

          }
        });
      });
    });

    // Delete function
    // Eliminamos el elemento padre del boton > [Tabla]
    function eliminar() {
      $("#table_productos").on('click', '.btn-danger', function(e) {
        e.preventDefault();
        tablaListado
          .row($(this).parents('tr'))
          .remove()
          .draw();
      });
    }

    function reloadpage() {
      location.reload();
    }
  </script>

  <script>
    $(document).ready(function() {
      $('#searcharticle').on('click', function(e) {
        e.preventDefault();
        var id = $('#txtcodigoproducto').val();
        var opt = 1;
        $.ajax({
          type: 'POST',
          url: 'dataarticulo.php',
          dataType: "json",
          data: {
            id: id,
            option: opt
          },
          success: function(data) {
            if (data.result.existencia_articulo < 1) {
              alert("No hay articulos disponibles");

            } else {
              $('#txtnombreP').val(data.result.nombre_articulo);
              $('#txtprecio').val(data.result.precio_articulo);
              $('#txtcantidad').val(data.result.existencia_articulo);
              $('#idp').val(data.result.id);
            }

          }
        });
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      $('#dropcliente').select2();
      $('#dropvendedor').select2();
    });
  </script>

</body>

<?php
require_once 'footer.php';

?>

</html>