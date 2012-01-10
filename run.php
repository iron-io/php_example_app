<?php

include("lib/IronWorker/SimpleWorker.class.php");

$name = "tweetworker.php-".microtime(true);

$worker = new SimpleWorker('worker/config.ini');
$worker->debug_enabled = true;

$project_id = ""; # using default project_id from config
$zipName = "code/$name.zip";

$zipFile = SimpleWorker::zipDirectory(dirname(__FILE__)."/worker", $zipName, true);

$res = $worker->postCode($project_id, "execute.php", $zipName, $name);

$task_id = $worker->postTask($project_id, $name, null);
echo "task_id = $task_id \n";
sleep(15);
$details = $worker->getTaskDetails($project_id, $task_id);
print_r($details);

if($details->status != 'queued') {
    $log = $worker->getLog($project_id, $task_id);
    print_r($log);
}

?>
