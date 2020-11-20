<?php
@session_start();
unset($_SESSION["sesion"]);
session_unset();
session_destroy();
header("Location: index.php");