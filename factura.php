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
            <select name="dropvendedor" id="dropvendedor" style="width: 100%" class="js-example-basic-single js-states form-control">

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
                  <td>Cantidad</td>

                  <td>
                    <input id="txtcantidad" type="number" class="form-control" name="txtcantidad" placeholder="Cantidad">
                  </td>
                </tr>

                <tr>
                  <td>Precio</td>
                  <td><input type="text" class="form-control" id="txtprecio"></td>
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
<!--   
  <script>
    function loadproductinfo(id) {
      var dato = $('#txtcodigoproducto').val();      
      $.ajax({
        type: "POST",
        url: 'dataarticulo.php',
        data: 'id='+id,
        dataType: 'json',
        success: function(data) {
          $('#txtprecio').val(data.result.nombre_articulo);     
          //alert(data.result.nombre_articulo);
        }

      });
    }
  </script> -->


  <script>
$(document).ready(function(){
    $('#searcharticle').on('click',function(){
        var id = $('#txtcodigoproducto').val();
        $.ajax({
            type:'POST',
            url:'dataarticulo.php',
            dataType: "json",
            data:{id:id},
            success:function(data){
               
                    $('#txtprecio').val(data.result.nombre_articulo);              
                    alert(data.result.nombre_articulo);
                
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

</html>