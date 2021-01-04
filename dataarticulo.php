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

         $objetofactura = json_decode($_POST["objDatosColumna"], true);
         $idcliente = $_POST["idcliente"];
         $idvendedor = $_POST["idvendedor"];
         $numerofactura = $_POST["numerofactura"];
         $fechafactura = $_POST["fechafactura"];

         $birthday = new DateTime('1879-03-14');

         $query1 = "INSERT INTO enc_venta(numero,fecha,id_cliente,id_vendedor,activa,estado) VALUES($numerofactura,'$fechafactura',$idcliente,$idvendedor,1,1)";
         $resultado1 = $cnn->query($query1);
         $idenc_venta = $cnn->insert_id; //para obtener el id autogenerado y pasarlo a la tabla det_venta

         foreach ($objetofactura as $factura) {
            $idp = $factura["Codigo"];
            $CantidadP = $factura["Cantidad"];
            $PrecioP = $factura["Precio"];


            $query = "INSERT INTO det_venta(id_enc_venta,id_articulo,cantidad,precio,descuento,total) VALUES($idenc_venta,$idp,$CantidadP,$PrecioP,$PrecioP,$PrecioP)";
            $resultado = $cnn->query($query);
            // printf ("New Record has id %d.\n", $cnn->insert_id);


            if ($resultado) {
               echo "La factura se ha guardado correctamente";
            } else {
               echo "Ha ocurrido un error";
            }
         }
         mysqli_close($cnn);

         break;
   }

   ?>