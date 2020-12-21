 <?php
   $id = $_POST["id"];
   $opt = $_POST["option"];
  
   $data = array();

   include 'conexion.php';

   switch ($opt) {
      case 1:
         
         //$articulodata = "SELECT * FROM articulo where codigo_articulo=$id";
         //$objetoarticulo = mysqli_query($cnn, $articulodata) or die(mysql_error($cnn));
         $query = $cnn->query("SELECT * FROM articulo where codigo_articulo=$id");

         $userData =  $query->fetch_assoc();
         $data['result'] = $userData;

         echo json_encode($data);

         break;

      case 2:
         $pp = $_POST["objDatosColumna"];
          echo  $pp[0];

            break;
   }

   ?>