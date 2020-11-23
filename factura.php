<html lang="en">
<?php
 require_once 'header.php';
$mode = isset($_REQUEST['f_mode']) ? $_REQUEST['f_mode'] : "";

?>
<head> 
  

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

          $sumaconsecutivo = intval($consecutivo + 1);
          $count=2; $digits = 10; $start= $resul['numero'];
          
        
            
            for ($n = $start; $n < $start + $count; $n++) {
              $result= str_pad($n, $digits, "0", STR_PAD_LEFT);
            }
                     
          
     
        ?>
        <td><input id="txtNoFactura" value="<?php echo $result; ?>" class="form-control"></td>        
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

<div class="container">
  <h2>Detalle Ventas por productos</h2>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">Registros marcados con un * son requeridos</div>
      <div class="panel-body">

         <form>
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
  <button type="submit" class="btn btn-primary">Guardar</button>
</form>

      </div>
     </div>

  </div>
</div>


<?php  
require_once 'footer.php'; 

?>
</body>
</html>



