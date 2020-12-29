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
           $idp = $factura["idp"];
           $CantidadP = $factura["CantidadP"];
           $PrecioP = $factura["PrecioP"];

           try{
            $query = "INSERT INTO det_venta(id_enc_venta,id_articulo,cantidad,precio,descuento,total) VALUES($idp,$idp,$CantidadP,$PrecioP,$PrecioP,$PrecioP)";
            $resultado = $cnn->query($query); 
           }
           catch(Exception $e)
           {
            echo 'Message: ' .$e->getMessage();
               echo "Insercion fallida ";
            
           }
          
           if($resultado)
           {
             echo "Insercion exitosa";
           }
           else 
           {
              echo "Insercion fallida";
           }
          

          //echo $factura["idp"],$factura["CantidadP"],$factura["PrecioP"];
         }
         mysqli_close($cnn);

         break;
   }

   ?>