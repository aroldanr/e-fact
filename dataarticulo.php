 <?php
   $opt = $_POST["option"];

   $data = array();
   $message = "La transaccion se realizo satisfactoriamente";

   include 'conexion.php';

   switch ($opt) {
      case 1:
         $id = $_POST["id"];
         //$articulodata = "SELECT * FROM articulo where codigo_articulo=$id";
         //$objetoarticulo = mysqli_query($cnn, $articulodata) or die(mysql_error($cnn));
         $query = $cnn->query("SELECT * FROM articulo where codigo_articulo=$id");

         $userData =  $query->fetch_assoc();
         $data['result'] = $userData;

         echo json_encode($data);

         break;

      case 2:

         $objetofactura = json_decode($_POST["objDatosColumna"],true);
         foreach ($objetofactura as $factura) {
          // mysqli_query($cnn, "INSERT into det_venta (id_enc_venta,id_articulo,cantidad,precio,descuento,total) values('".$factura["idp"]."',".$factura["idp"].",'".$factura["CantidadP"]."','".$factura["PrecioP"]."',")");
            //$query = $cnn->query("INSERT into det_venta(id_enc_venta,id_articulo,cantidad,precio,descuento,total) values(1, " .$factura["idp"]. ", " .$factura["CantidadP"].", " .$factura["PrecioP"]. ", 0.00, 100)");
         }
         mysqli_close($cnn);

         break;
   }

   ?>