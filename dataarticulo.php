 <?php
    $id = $_POST["id"];

    $data = array();


    include 'conexion.php';
    //$articulodata = "SELECT * FROM articulo where codigo_articulo=$id";
    //$objetoarticulo = mysqli_query($cnn, $articulodata) or die(mysql_error($cnn));
    $query = $cnn->query("SELECT * FROM articulo where codigo_articulo=$id");

    $userData =  $query->fetch_assoc();
    $data['result'] = $userData;

    echo json_encode($data);
    ?>