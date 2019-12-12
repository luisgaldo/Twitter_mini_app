<?php
function conexion_bbdd(){
    $conexion = mysqli_connect("localhost","root","","elogia")
    or die("Ha sucedido un error inexperado en la conexion de la base de datos");
    mysqli_set_charset($conexion, "utf8");
        return $conexion;
}
?>