<?php
require_once('auxiliar.php');
$conexion = conexion_bbdd(); 
$consulta = "SELECT DATE(date) as date, COUNT(text) as counter FROM tweets GROUP BY day(date)";
if(!$resultado = mysqli_query($conexion, $consulta)) die("Error description: " . mysqli_error($conexion));
$tweets = array();
while($res=mysqli_fetch_array($resultado)){
    $tweets[$res['date']]['date'] = $res['date'];
    $tweets[$res['date']]['counter'] = $res['counter']; 
    }
echo json_encode($tweets);
?>