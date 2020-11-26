<?php
require_once 'header.php';
$mode = isset($_REQUEST['f_mode']) ? $_REQUEST['f_mode'] : "";

?>

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
            <select id="dropcliente" style="width: 100%" class="js-example-basic-single js-states form-control" name="dropcliente">

              <?php
              // include 'conexion.php';  

              $clientedata = "SELECT concat(nombre1_cliente,' ',nombre2_cliente,' ',apellido1_cliente,' ',apellido2_cliente) as nombre_cliente FROM cliente";
              $Objcliente = mysqli_query($cnn, $clientedata) or die(mysql_error($cnn));

              ?>

              <?php foreach ($Objcliente as $opciones) : ?>
                <option class="form-control" value="<?php echo $opciones['nombre_cliente'] ?>"><?php echo $opciones['nombre_cliente'] ?></option>
              <?php endforeach ?>

            </select>
          </td>
        </tr>
        <tr>
          <td>Vendedor</td>
          <td>
            <select name="dropvendedor" id="dropvendedor" style="width: 100%" class="js-example-basic-single js-states form-control">

              <?php
              // include 'conexion.php';

              $vendedordata = "SELECT nombre_vendedor FROM vendedor";
              $Objvendedor = mysqli_query($cnn, $vendedordata) or die(mysql_error($cnn));

              ?>
              <?php foreach ($Objvendedor as $itemsvendedor) : ?>
                <option class="form-control" value="<?php echo $itemsvendedor['nombre_vendedor'] ?>"><?php echo $itemsvendedor['nombre_vendedor'] ?></option>
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
            <div class="form-row">
              <div class="col-md-6">
                <div class="input-group" style="margin:0em">
                  <input type="number" class="form-control" placeholder="Codigo de Producto">
                  <div class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                      <i class="glyphicon glyphicon-search"></i>
                    </button>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="input-group">                  
                  <input id="msg" type="text" class="form-control" name="msg" placeholder="Additional Info">
                  <span class="input-group-addon">Text</span>
                </div>
              </div>

            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
          </form>

        </div>
      </div>

    </div>
  </div>



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