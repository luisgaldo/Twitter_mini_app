<?php
require_once('auxiliar.php');
$conexion = conexion_bbdd(); 
$consulta = "SELECT id, date, username, text FROM tweets;";
if(!$resultado = mysqli_query($conexion, $consulta)) die("Error description: " . mysqli_error($conexion));
$tweets = array();
while($res=mysqli_fetch_array($resultado)){
    $tweets[$res['id']] = array();
    $tweets[$res['id']]['date'] = $res['date'];
    $tweets[$res['id']]['username'] = $res['username']; 
    $tweets[$res['id']]['text'] = $res['text']; 
    }
echo json_encode($tweets);
?>