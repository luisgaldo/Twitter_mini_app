<?php
require_once('auxiliar.php');
$conexion = conexion_bbdd(); 
$consulta = "SELECT length(text) as longitud, COUNT(text) as counter FROM tweets group by length(text)";
if(!$resultado = mysqli_query($conexion, $consulta)) die("Error description: " . mysqli_error($conexion));
$tweets = array();
while($res=mysqli_fetch_array($resultado)){
    $tweets[$res['longitud']]['longitud'] = $res['longitud'];
    $tweets[$res['longitud']]['cantidad'] = $res['counter']; 
    }
echo json_encode($tweets);
?>