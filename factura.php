<?php
require_once 'header.php';
$mode = isset($_REQUEST['f_mode']) ? $_REQUEST['f_mode'] : "";

?>
<<<<<<< HEAD

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
  <!-- <form style="padding-top: 5rem;">
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputEmail4">Email</label>
        <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
      </div>
      <div class="form-group col-md-6">
        <label for="inputPassword4">Password</label>
        <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
      </div>
    </div>
    <div class="form-group">
      <label for="inputAddress">Address</label>
      <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
    </div>
    <div class="form-group">
      <label for="inputAddress2">Address 2</label>
      <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputCity">City</label>
        <input type="text" class="form-control" id="inputCity">
      </div>
      <div class="form-group col-md-4">
        <label for="inputState">State</label>
        <select id="inputState" class="form-control">
          <option selected>Choose...</option>
          <option>...</option>
        </select>
      </div>
      <div class="form-group col-md-2">
        <label for="inputZip">Zip</label>
        <input type="text" class="form-control" id="inputZip">
      </div>
    </div>
    <div class="form-group">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="gridCheck">
        <label class="form-check-label" for="gridCheck">
          Check me out
        </label>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Sign in</button>
  </form> -->


  <div class="container">
=======

<html lang="en">


<head>
  <style>
    /* width */
    ::-webkit-scrollbar {
      width: 10px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
      background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: #888;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
      background: #555;
    }
  </style>
</head>

<body>
  </br>
  </br>
  <div class="container" style="background-color: white;">
>>>>>>> master
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

<<<<<<< HEAD
          <?php // Work in progress
=======
          <?php


>>>>>>> master
          $consecutivodata = "SELECT numero FROM enc_venta ORDER BY id DESC LIMIT 1";
          $Objconsecutivo = mysqli_query($cnn, $consecutivodata) or die(mysql_error($cnn));
          $resul = mysqli_fetch_assoc($Objconsecutivo);

          $consecutivo = substr($resul['numero'], 0, 4);

<<<<<<< HEAD
          $sumaconsecutivo = intval($consecutivo + 1)
          ?>
          <td><input id="txtNoFactura" value="<?php echo $resul['numero']; ?>" class="form-control"></td>
=======
          $sumaconsecutivo = intval($consecutivo + 1);
          $count = 2;
          $digits = 10;
          $start = $resul['numero'];



          for ($n = $start; $n < $start + $count; $n++) {
            $result = str_pad($n, $digits, "0", STR_PAD_LEFT);
          }



          ?>
          <td><input id="txtNoFactura" value="<?php echo $result; ?>" class="form-control" readonly></td>
>>>>>>> master
        </tr>
        <tr>
          <td>Fecha</td>
          <td><input type="date" class="form-control" id="start" name="txtfecha"></td>
        </tr>
        <tr>
          <td>Cliente</td>
          <td>
<<<<<<< HEAD
            <select name="dropcliente" id="dropcliente" class="form-control">

              <?php
              // include 'conexion.php';

              $clientedata = "SELECT concat(nombre1_cliente,' ',nombre2_cliente,' ',apellido1_cliente,' ',apellido2_cliente) as nombre_cliente FROM cliente";
=======
            <select id="dropcliente" style="width: 100%" class="js-example-basic-single js-states form-control" name="dropcliente">

              <?php
              // include 'conexion.php';  

              $clientedata = "SELECT concat(nombre1_cliente,' ',nombre2_cliente,' ',apellido1_cliente,' ',apellido2_cliente) as nombre_cliente, id FROM cliente";
>>>>>>> master
              $Objcliente = mysqli_query($cnn, $clientedata) or die(mysql_error($cnn));

              ?>

              <?php foreach ($Objcliente as $opciones) : ?>
<<<<<<< HEAD
                <option class="form-control" value="<?php echo $opciones['nombre_cliente'] ?>"><?php echo $opciones['nombre_cliente'] ?></option>
=======
                <option class="form-control" value="<?php echo $opciones['id'] ?>"><?php echo $opciones['nombre_cliente'] ?></option>
>>>>>>> master
              <?php endforeach ?>

            </select>
          </td>
        </tr>
        <tr>
          <td>Vendedor</td>
          <td>
<<<<<<< HEAD
            <select name="dropvendedor" id="dropvendedor" class="form-control">
=======
            <select name="dropvendedor" id="dropvendedor" style="width: 100%" class="js-example-basic-single js-states form-control">
>>>>>>> master

              <?php
              // include 'conexion.php';

<<<<<<< HEAD
              $vendedordata = "SELECT nombre_vendedor FROM vendedor";
=======
              $vendedordata = "SELECT nombre_vendedor,id FROM vendedor";
>>>>>>> master
              $Objvendedor = mysqli_query($cnn, $vendedordata) or die(mysql_error($cnn));

              ?>
              <?php foreach ($Objvendedor as $itemsvendedor) : ?>
<<<<<<< HEAD
                <option class="form-control" value="<?php echo $itemsvendedor['nombre_vendedor'] ?>"><?php echo $itemsvendedor['nombre_vendedor'] ?></option>
=======
                <option class="form-control" value="<?php echo $itemsvendedor['id'] ?>"><?php echo $itemsvendedor['nombre_vendedor'] ?></option>
>>>>>>> master
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
<<<<<<< HEAD
  <?php
  require_once 'footer.php';
  ?>
</body>
=======

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
                    <input id="txtnombreP" type="text" class="form-control" name="txtnombreP" placeholder="Nombre">
                  </td>
                </tr>

                <tr>
                  <td>Cantidad</td>
                  <td>
                    <input id="txtcantidad" type="number" class="form-control" name="txtcantidad" placeholder="Cantidad">
                  </td>
                </tr>

                <tr>
                  <td>Precio</td>
                  <td><input type="text" class="form-control" id="txtprecio" placeholder="Precio"></td>
                </tr>

                <tr>
                  <td>Descuento</td>
                  <td><input type="number" class="form-control" placeholder="Descuento" id="txtdescuento"></td>
                </tr>
              </tbody>

            </table>

            <table id="table_productos" class="display">
              <thead>
                <tr>
                  <th>Column 1</th>
                  <th>Column 2</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Row 1 Data 1</td>
                  <td>Row 1 Data 2</td>
                </tr>
                <tr>
                  <td>Row 2 Data 1</td>
                  <td>Row 2 Data 2</td>
                </tr>
              </tbody>
            </table>

            </br></br>
            <div class="form-row">
              <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Guardar</button>
              </div>

            </div>

          </form>

        </div>
      </div>

    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('#table_productos').DataTable();
    });
  </script>

  <script>
    $(document).ready(function() {
      $('#searcharticle').on('click', function(e) {
        e.preventDefault();
        var id = $('#txtcodigoproducto').val();
        $.ajax({
          type: 'POST',
          url: 'dataarticulo.php',
          dataType: "json",
          data: {
            id: id
          },
          success: function(data) {
            $('#txtnombreP').val(data.result.nombre_articulo);
            $('#txtprecio').val(data.result.precio_articulo);
            $('#txtcantidad').val(data.result.existencia_articulo);
          }
        });
      });
    });
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
>>>>>>> master

</html>