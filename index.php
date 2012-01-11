<?php

include("worker/lib/IronMQ/IronMQ.class.php");

$queue_name = "TweetWorker";
$mq = new IronMQ(__DIR__."/worker/config.ini");
$message = $mq->getMessage($queue_name);
if(!empty($message)) {
    $mq->deleteMessage($queue_name, $message->id);
}

$headers = getallheaders();
$is_ajax = array_key_exists("X-Requested-With", $headers) && $headers["X-Requested-With"] == "XMLHttpRequest";

if($is_ajax) {
    echo json_encode($message);
} else {
?><!DOCTYPE html
<html>
<head>
  <meta charset='utf-8'>
  <title>Powered by Iron.io</title>

  <style type="text/css">
      body {
        margin-top: 0;
        font-family: Helvetica, Arial, FreeSans, san-serif;
        background: #0099DC url(images/page-bg.png) 30% 0;
        color: #9EF;
        line-height: 1.5em;
      }

      #container {
        margin: 0 auto;
        width: 600px;
        padding: 40px 150px 20px;

        background: -webkit-radial-gradient(50% 30%, hsla(200, 82%, 84%, 0.5), hsla(200, 82%, 74%, 0) 70%);
        background: -moz-radial-gradient(50% 30%, hsla(200, 82%, 84%, 0.5), hsla(200, 82%, 74%, 0) 70%);
        background: -ms-radial-gradient(50% 30%, hsla(200, 82%, 84%, 0.5), hsla(200, 82%, 74%, 0) 70%);
        background: radial-gradient(50% 30%, hsla(200, 82%, 84%, 0.5), hsla(200, 82%, 74%, 0) 70%);
      }

      h1 {
          font-size: 3.1em;
          margin-bottom: 3px;
      }

      h1 .sw {
          color: #1e90ff;
      }

      h1 .iw {
          color: #b22222;
      }

      h1 .small {
          font-size: 0.4em;
      }

      h1 a {
          text-decoration: none
      }

      h2 {
          font-size: 1.5em;
          color: #1e90ff;
      }

      h3 {
          text-align: center;
          color: #1e90ff;
      }

      a {
          color: yellow;
      }

      .run {
        margin-bottom: 20px;
        padding-top: 20px;
        clear: both;
        text-align: center;
        position: relative;
      }

      .download {
          float: right;
      }

      pre {
          background: #000;
          color: #fff;
          padding: 15px;
      }

      hr {
          border: 0;
          width: 80%;
          border-bottom: 1px solid #aaa
      }

      .footer {
          text-align: center;
          padding-top: 30px;
          font-style: italic;
      }

      #tweet-box {
        background: white;
        float: left;
        padding: 20px 30px;
        border-radius: 10px;
        margin-left: 30px;
        border: 2px solid #004B6D;
        position: relative;
        width: 350px;
        color: #007F99;
      }

      #tweet-box:after {
        content: "";
        position: absolute;
        top: 35px;
        left: -20px;
        border-width: 0 20px 20px 0;
        border-style: solid;
        border-color: transparent #fff;
        display: block;
        width: 0;
      }

      #tweet-box:before {
        content: "";
        position: absolute;
        top: 33px;
        left: -24px;
        border-width: 0 23px 24px 0;
        border-style: solid;
        border-color: transparent #004B6D;
        display: block;
        width: 0;
      }


      button  {
        font-size: 25px;
        padding: 15px 15px 15px 20px;
        background: #0A89B3;
        background:hsla(190, 89%, 30%, .5);
        color: white;
        text-transform: uppercase;
        border: 2px solid #004B6D;
        border-radius: 10px;
        font-family: "Gill Sans", "Gill Sans MT", Calibri, sans-serif;
        letter-spacing: 1px;
        text-shadow: 0 2px 0 rgba(0,0,0,.75);
        margin: 0;
      }

      .description-wrapper {
        background: #9EF;
        padding: 5px;
      }

      .description {
        border: 1px solid #004B6D;
        padding: 40px 40px 30px;
        background: #02749F;
        box-shadow: 0 1px 3px rgba(0,0,0,.8);
      }
      
      .description p {
        border-bottom: 1px solid #265973;
        margin: 0;
        padding-bottom: 30px;
        text-shadow: 0 -1px 0 rgba(0,0,0,.75);
      }

      .description h1 {
        border-top: 1px solid hsl(190, 60%, 40%);
        margin: 0;
        padding: 20px 0 0;
        font-size: 32px;
        text-align: center;
        color: #004B6D;
      }
      
      .description h1 a {
        color: #00344D;
        text-shadow: 0 1px 0 rgba(255,255,255,.2);
      }

      #status_container {
        position: absolute;
        top: 124px;
        left: 273px;
      }
  </style>

  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script type="text/javascript" src="js/jquery.ba-dotimeout.min.js"></script>
  <script type="text/javascript" src="js/jquery.cookie.js"></script>


</head>

<body>

<img src="images/twitter_bird.png" alt="" style="position: absolute;top: 320px;left: 200px;opacity: .5;.;width: 50px;">
<img src="images/twitter_bird.png" alt="" style="position: absolute;top: 600px;left: 100px;opacity: .5;.;width: 30px;">
<img src="images/twitter_bird.png" alt="" style="position: absolute;top: 110px;left: 1060px;opacity: .5;.;width: 30px;">
<img src="images/twitter_bird.png" alt="" style="position: absolute;top: 180px;left: 100px;opacity: .5;.;width: 20px;">
<img src="images/twitter_bird.png" alt="" style="position: absolute;top: 420px;left: 950px;opacity: .5;.;width: 60px;">


<div id="container">

  <div id="tweets">
    <img src="images/twitter_bird.png" alt="" style="float:left;">
    <div id="tweet-box">
      <?php if(!empty($message)) { ?>
          Latest Tweet:
          <br/>
      <span style="font-weight: bold;">
          <?php print $message->body; ?>
      </span>
      <?php } else { ?>
          <div style="color: red;">
            There are no more tweets in the queue.<br> Run TweetWorker to get another one.
          </div>
      <?php } ?>
    </div>
  </div>

   <div class="run">
    <div id="status_container" style="display: none;">
      <div id="status_indicator" style="display: inline-block; width: 40px;">
        <img src="images/ajax-loader.gif"/>
      </div>
      <div id="status_div">
      </div>
    </div>
    <form id="runForm" action="/run.php" method="post">
      <img src="images/robotic-giant.png" style="margin: 0 auto;display: block;" alt="">
      <button>Run TweetWorker <span style="color: #004B6D;margin-left: 10px;font-size: 20px;text-shadow:none;">▶</span></button>
    </form>
  </div>

  <div class="description-wrapper">
    <div class="description">
      <p>
        This is an example application that uses <a href="http://www.iron.io/products/mq">IronMQ</a>
        and <a href="http://www.iron.io/products/worker">IronWorker</a> together. If you click
        the &quot;Run TweetWorker&quot; button above, that will queue up a
        <a href="https://github.com/iron-io/heroku_sinatra_example/blob/master/workers/tweet_worker.rb">TweetWorker</a> task
        on IronWorker. TweetWorker is a worker that gets the latest tweet tagged with #cloud and push that
        tweet onto a queue on IronMQ.
        <br/><br/>
        This page you are looking at grabs tweets off the same queue on IronMQ and displays them. To see
        more tweets, keep running TweetWorker.
      </p>
      <h1><a href="http://www.iron.io" id="main">Powered by <img src="images/logo.png" alt=""></a></h1>
    </div>
  </div>

    


  <script>
      status_polling = false;
      $("#runForm").submit(function() {
          $("#status_container").show();
          $("#status_indicator").show();
          $("#status_div").html("Starting");
          var jqxhr = $.post("run.php", {}, function (json) {
              console.log("json");
              console.log(json);
              if (json.task_id != null) {
                  $.cookie('task_id', json.task_id);
                  if(!status_polling) {
                      getStatus();
                  }
              } else {
                  $("#status_indicator").hide();
                  $("#status_div").html("Error");
              }
          }, "json");
          return false;
      });

      function getStatus() {
          status_polling = true;
          $.doTimeout(2000, function () {
              if($.cookie("task_id") != null) {
              var jqxhr = $.getJSON("worker_status.php", {"task_id": $.cookie("task_id")}, function (json) {
                  console.log("json");
                  console.log(json);
                  if (json.status != null) {
                      $("#status_div").html("Task status: " + json.status);
                      console.log("Success");
                      if(json.status == "complete") {
                          status_polling = false;
                          $("#status_indicator").hide();
                          $.cookie("task_id", null);
                      }
                  } else {
                      console.log("Failure");
                      status_polling = false;
                      $("#status_indicator").hide();
                  }
              })
              .error(function () {
                  $("#status_indicator").hide();
                  $("#status_div").html("Error");
                  console.log("Error");
                  status_polling = false;
              })
              } else {
                  status_polling = false;
              }
              return status_polling;
          });
      }

      getStatus();
  </script>

  <script>
      if($.cookie('task_id') != null) {
          $("#status_container").show();
      } else {
          $("#status_container").hide();
      }
  </script>


  <div class="footer">
    <img src="images/icon-sprites.png" alt="">&nbsp; Source code for this project is on
    <a href="https://github.com/iron-io/heroku_sinatra_example" target="_blank">Github</a>
  </div>

</div>

</body>
</html><?php } ?>
