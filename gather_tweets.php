<?php
require_once('TwitterAPIExchange.php');
require_once('auxiliar.php');
require_once('private.php');
$hashtag = $_POST['hashtag'];
$settings = array(
    'oauth_access_token' => oauth_access_token(),
    'oauth_access_token_secret' => oauth_access_token_secret(),
    'consumer_key' => consumer_key(),
    'consumer_secret' => consumer_secret()
);

$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = '?q=#'.$hashtag.'&count=100&result_type=recent&tweet_mode=extended';
$requestMethod = 'GET';


$twitter = new TwitterAPIExchange($settings);
$response = json_decode($twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest(), true);
    

//var_dump($response);
  
$conexion = conexion_bbdd();   
foreach($response['statuses'] as $tweets) {
    $created_at = date("Y-m-d H:i:s", strtotime($tweets['created_at']));
    $screen_name = $tweets[user][screen_name];
    $user_id = $tweets[user][id];
    $full_text = str_replace("'", "", $tweets['full_text']);
    $consulta = "INSERT IGNORE INTO tweets(id, date, text, username, userid) VALUES ($tweets[id], '$created_at', '$full_text', '$screen_name', $user_id)";
    if(!$resultado = mysqli_query($conexion, $consulta)) die("Error description: " . mysqli_error($conexion));
    
    foreach($tweets["entities"]["hashtags"] as $hashtags){
        $consulta = "INSERT IGNORE INTO hashtags(tweet_id, text) VALUES ($tweets[id], '$hashtags[text]')";
        if(!$resultado = mysqli_query($conexion, $consulta)) die("Error description: " . mysqli_error($conexion));
    }
}
echo "Tweets obtenidos y guardados en la base de datos";
?>