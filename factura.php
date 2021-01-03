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
              <button id="btnagregarproducto" class="btn btn-primary">Agregar Producto</button>
            </div>


            <div class="row">
              <div class="col-lg-12">
                <table id="table_productos" class="table table-bordered  display nowrap" cellspacing="0" width="100%">



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

  <div class="container">
    <table id="example" class="display" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>Name</th>
          <th>Position</th>
          <th>Office</th>
          <th>Extn.</th>
          <th>Start date</th>
          <th>Salary</th>
          <th>Edit / Delete</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th>Name</th>
          <th>Position</th>
          <th>Office</th>
          <th>Extn.</th>
          <th>Start date</th>
          <th>Salary</th>
          <th>Edit / Delete</th>
        </tr>
      </tfoot>
    </table>
  </div>

  <script>
    var tablaListado;
    var editor;
    var dataSet;
    var objetofacturajson;
    var jsonn;

    var data1 = [];
    var id = 1;

    $(document).ready(function() {
      dataSet = [];
      objetofacturajson = [];
      jsonn = "";

      // Datatable init
      tablaListado = $("#table_productos").DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
          'print'
        ],
        select: true,
        "data": dataSet,
        "columns": [{
            "title": "codigoproducto"
          },
          {
            "title": "nombreproducto"
          },
          {
            "title": "cantidadproducto"
          },
          {
            "title": "precio"
          },
          {
            "title": "Eliminar"
          },
          {
            "title": "Editar"
          }
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

        var bteliminar = `<button id='btnEliminar' class='btn btn-danger btn-sm rounded-0' type='button' data-toggle='tooltip' data-placement='top' title='Delete' OnClick="eliminar('${id}')"><i class='fa fa-trash'></i></button>`
        var bteditar = `<button id='btnEditar' class='btn btn-success btn-sm rounded-0' type='button' data-toggle='tooltip' data-placement='top' title='Delete' OnClick="editar('${id}')"><i class='fa fa-edit'></i></button>`

        data1 = [idp, NombreP, CantidadP, PrecioP, bteliminar, bteditar];

        data1JSON = JSON.stringify(data1);
        console.log(data1JSON)

        dataSet.push(data1);

        tablaListado.clear();
        tablaListado.rows.add(dataSet);
        tablaListado.draw();


        objetofacturajson.push({
          idp: idp,
          NombreP: NombreP,
          CantidadP: CantidadP,
          PrecioP: PrecioP,
        });

        id += 1;
      });

      // Save the DataTable on the Database
      $('#brnguardarfactura').click(function(e) {
        e.preventDefault();

        var opt = 2;
        $.ajax({
          type: "POST",
          url: "dataarticulo.php",
          data: {
            objDatosColumna: JSON.stringify(objetofacturajson),
            option: opt
          },
          success: function(data) {
            console.log(JSON.stringify(objetofacturajson));
          }
        });
      });
    });

    // Delete function
    // Eliminamos el elemento padre del boton > [Tabla]
    function eliminar(id) {
      $("#table_productos").on('click', '.btn-danger', function(e) {
        e.preventDefault();
        // $(this).parent().parent().remove();
        //tablaListado.row($(this).parent().parent()).remove().draw();

        //data1.shift(id, 6);

        tablaListado
          .row($(this).parents('tr'))
          .remove()
          .draw();
      });
    }

    function editar(data1) {
      console.log(data1);
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
            $('#txtnombreP').val(data.result.nombre_articulo);
            $('#txtprecio').val(data.result.precio_articulo);
            $('#txtcantidad').val(data.result.existencia_articulo);
            $('#idp').val(data.result.id);
          }
        });
      });
    });
  </script>

  <script>
    // TEST DATATABLE
    var editor; // use a global for the submit and return data rendering in the examples

    $(document).ready(function() {
      editor = new $.fn.dataTable.Editor({
        "ajax": "staff.php",
        "table": "#example",
        "fields": [{
          "label": "First name:",
          "name": "first_name"
        }, {
          "label": "Last name:",
          "name": "last_name"
        }, {
          "label": "Position:",
          "name": "position"
        }, {
          "label": "Office:",
          "name": "office"
        }, {
          "label": "Extension:",
          "name": "extn"
        }, {
          "label": "Start date:",
          "name": "start_date",
          "type": "datetime"
        }, {
          "label": "Salary:",
          "name": "salary"
        }]
      });

      // Edit record
      $('#example').on('click', 'a.editor_edit', function(e) {
        e.preventDefault();

        editor.edit($(this).closest('tr'), {
          title: 'Edit record',
          buttons: 'Update'
        });
      });

      // Delete a record
      $('#example').on('click', 'a.editor_remove', function(e) {
        e.preventDefault();

        editor.remove($(this).closest('tr'), {
          title: 'Delete record',
          message: 'Are you sure you wish to remove this record?',
          buttons: 'Delete'
        });
      });

      $('#example').DataTable({
        ajax: "staff.php",
        columns: [{
            data: null,
            render: function(data, type, row) {
              // Combine the first and last names into a single table field
              return data.first_name + ' ' + data.last_name;
            }
          },
          {
            data: "position"
          },
          {
            data: "office"
          },
          {
            data: "extn"
          },
          {
            data: "start_date"
          },
          {
            data: "salary",
            render: $.fn.dataTable.render.number(',', '.', 0, '$')
          },
          {
            data: null,
            className: "center",
            defaultContent: '<a href="" class="editor_edit">Edit</a> / <a href="" class="editor_remove">Delete</a>'
          }
        ]
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