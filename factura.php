<?php
require_once 'header.php';
$mode = isset($_REQUEST['f_mode']) ? $_REQUEST['f_mode'] : "";

?>

<html lang="en">


<head>

  <script>
    $(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>

</head>

<body>
  </br>
  </br>
  <div class="container" style="background-color: white;">
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

  <script>
    var tablaListado;

    function eliminar() {
      $("#table_productos").on('click', '.btn-danger', function() {
        // $(this).parent().parent().remove();
        tablaListado.row($(this).parent().parent()).remove().draw();

      });
    }

    function eliminar2(tablaListado) {
      var id = tablaListado.row(this).id();
      alert('Clicked row id ' + id);
    }
  </script>


  <script>
    $(document).ready(function() {
      var dataSet = [];
      var objetofacturajson = [];
      var jsonn = "";

      tablaListado = $("#table_productos").DataTable({
        responsive: true,
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
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
        "ordering": false
      });

      $('#btnagregarproducto').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var NombreP = document.getElementById("txtnombreP").value;
        var CantidadP = document.getElementById("txtdeseado").value;
        var PrecioP = document.getElementById("txtprecio").value;
        var DescuentoP = document.getElementById("txtdescuento").value;
        var idp = document.getElementById("idp").value;

        // var bteliminar = `<button id='btnEliminar' class='btn btn-danger btn-sm rounded-0' type='button' data-toggle='tooltip' data-placement='top' title='Delete' OnClick="eliminar('${idp}')"><i class='fa fa-trash'></i></button>`
        var bteliminar = `<button id='btnEliminar' class='btn btn-danger btn-sm rounded-0' type='button' data-toggle='tooltip' data-placement='top' title='Delete' OnClick="eliminar()"><i class='fa fa-trash'></i></button>`
        var bteditar = `<button id='btnEditar' class='btn btn-success btn-sm rounded-0' type='button' data-toggle='tooltip' data-placement='top' title='Delete' OnClick="Editar('${idp}')"><i class='fa fa-edit'></i></button>`

        var data1 = [idp, NombreP, CantidadP, PrecioP, bteliminar, bteditar];

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

     


      });

      $('#brnguardarfactura').click(function(e) {
        e.preventDefault();

        var opt = 2;
        $.ajax({
          type: "POST",
          url: "dataarticulo.php",                   
          data: {
            objDatosColumna: JSON.stringify(objetofacturajson),
            option: opt,
            idcliente: document.getElementById("dropcliente").value,
            idvendedor: document.getElementById("dropvendedor").value,
            numerofactura: document.getElementById("txtNoFactura").value,
            fechafactura: document.getElementById("start").value
          },

          success: function(data) {
            alert(data);
            reloadpage();

          }
        });


      });

    });

    function reloadpage()
    {
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
    /*     $(document).ready(function() {
      $('#btnagregarproducto').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var retorno = '';
        var NombreP = document.getElementById("txtnombreP").value;
        var CantidadP = document.getElementById("txtdeseado").value;
        var PrecioP = document.getElementById("txtprecio").value;
        var DescuentoP = document.getElementById("txtdescuento").value;
        var idp = document.getElementById("idp").value;
       
        retorno = retorno + '<tr><td>' + idp + '</td><td>' +
          NombreP + '</td><td>' + CantidadP + '</td><td>' +
          PrecioP + `</td><td><button id='btnEliminar' class='btn btn-danger btn-sm rounded-0' type='button' data-toggle='tooltip' data-placement='top' title='Delete' OnClick="Eliminar('${idp}')"><i class='fa fa-trash'></i></button></td><td><button id='btnActualizar' type='button' class='btn btn-success btn-sm rounded-0' OnClick="Actualizar('${idp}')"><i class='fa fa-edit'></button></td></tr>`;
         

        $('#table_productos').append(retorno);
      });
    }); */
  </script>

  <script>

  </script>

</body>

<?php
require_once 'footer.php';

?>

<script>
  $(document).ready(function() {
    $('#dropcliente').select2();
    $('#dropvendedor').select2();
  });
</script>

</html>