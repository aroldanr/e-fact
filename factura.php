<html lang="en">
<?php
 require_once 'header.php';
$mode = isset($_REQUEST['f_mode']) ? $_REQUEST['f_mode'] : "";

?>
<head>

  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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


          $consecutivodata="SELECT numero FROM enc_venta ORDER BY id DESC LIMIT 1";              
          $Objconsecutivo=mysqli_query($cnn,$consecutivodata) or die(mysql_error($cnn));
          $resul = mysqli_fetch_assoc($Objconsecutivo);

          $consecutivo = substr($resul['numero'], 0, 4);

          $sumaconsecutivo = intval($consecutivo + 1)
     
        ?>
        <td><input id="txtNoFactura" value="<?php echo $resul['numero']; ?>" class="form-control"></td>        
      </tr>
      <tr>
        <td>Fecha</td>
        <td><input type="date" class="form-control" id="start" name="txtfecha"></td>        
      </tr>
      <tr>
        <td>Cliente</td>
        <td>
        <select name="dropcliente" id="dropcliente" class="form-control">

          <?php 
             // include 'conexion.php';

              $clientedata="SELECT concat(nombre1_cliente,' ',nombre2_cliente,' ',apellido1_cliente,' ',apellido2_cliente) as nombre_cliente FROM cliente";              
              $Objcliente=mysqli_query($cnn,$clientedata) or die(mysql_error($cnn));

          ?>

        <?php foreach ($Objcliente as $opciones): ?>
        <option class="form-control" value="<?php echo $opciones['nombre_cliente']?>"><?php echo $opciones['nombre_cliente']?></option>     
        <?php endforeach ?>

         </select>
        </td>       
      </tr>
      <tr>
        <td>Vendedor</td>
        <td>
        <select name="dropvendedor" id="dropvendedor" class="form-control">    
          
        <?php 
             // include 'conexion.php';

              $vendedordata="SELECT nombre_vendedor FROM vendedor";              
              $Objvendedor=mysqli_query($cnn,$vendedordata) or die(mysql_error($cnn));

          ?>
        <?php foreach ($Objvendedor as $itemsvendedor): ?>
        <option class="form-control" value="<?php echo $itemsvendedor['nombre_vendedor']?>"><?php echo $itemsvendedor['nombre_vendedor']?></option>     
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
<?php  
require_once 'footer.php'; 

?>
</body>
</html>



