<?php
$headers = getallheaders();
$is_ajax = array_key_exists("X-Requested-With", $headers) && $headers["X-Requested-With"] == "XMLHttpRequest";

include("lib/IronWorker/IronWorker.class.php");

$name = "TweetWorker.php";

$worker = new IronWorker('worker/config.ini');
$worker->debug_enabled = false;

$task_id = $_GET['task_id'];

$details = $worker->getTaskDetails($task_id);

if($is_ajax) {
    echo json_encode($details);
} else {
    print "Task is ".$details->status;
}
?>
