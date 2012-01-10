<?php

include("lib/IronMQ/IronMQ.class.php");

function getTweet($query) { 
    $res = file_get_contents("http://search.twitter.com/search.json?q=".$query."&rpp=1");
    $results = json_decode($res);
    return $results->results[0];
}

$config = parse_ini_file('config.ini', true);
echo "Searching for ".$config['twitter']['query']."...";

$tweet = getTweet($config['twitter']['query']);
print_r($tweet);

$mq = new IronMQ('config.ini', true);

$response = $mq->postMessage('', "TweetWorker", array("body" => $tweet->text));

print_r($response);

?>
