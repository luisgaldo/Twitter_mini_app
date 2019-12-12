<?php
require_once('auxiliar.php');
$conexion = conexion_bbdd(); 
$consulta = "SELECT COUNT(text) as counter, text FROM hashtags GROUP BY text ORDER BY COUNT(text) DESC LIMIT 10";
if(!$resultado = mysqli_query($conexion, $consulta)) die("Error description: " . mysqli_error($conexion));
$tweets = array();
$i = 0;
while($res=mysqli_fetch_array($resultado)){
    $tweets[$i]['word'] = $res['text'];
    $tweets[$i]['size'] = $res['counter']; 
    $i = $i +1 ;
    }
echo json_encode($tweets);
?>