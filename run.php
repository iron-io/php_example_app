<?php
$headers = getallheaders();
$is_ajax = array_key_exists("X-Requested-With", $headers) && $headers['X-Requested-With'] == 'XMLHttpRequest';

if($_SERVER['REQUEST_METHOD'] == "POST") {
    include("lib/IronWorker/IronWorker.class.php");

    $name = "TweetWorker.php";

    $worker = new IronWorker('worker/config.ini');
    $worker->debug_enabled = false;

    $zipName = "code/$name.zip";

    $zipFile = IronWorker::zipDirectory(dirname(__FILE__)."/worker", $zipName, true);

    $res = $worker->postCode("execute.php", $zipName, $name);

    $task_id = $worker->postTask($name, null);
    if($is_ajax) {
        echo json_encode(array("task_id" => $task_id));
    } else {
        setcookie("task_id", $task_id);
        header("Location: index.php");
    }
} else {
    if($is_ajax) {
        echo json_encode(array("error" => "Only POST requests are permitted."));
    } else {
        echo "Only POST requests are permitted.";
    }
}
?>
