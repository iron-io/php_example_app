<?php

function getTweet($query) { 
    return file_get_contents("http://search.twitter.com/search.json?q=".$query."&rpp=1");
}

$config = parse_ini_file('config.ini', true);
print_r(getTweet($config['twitter']['query']));

?>
