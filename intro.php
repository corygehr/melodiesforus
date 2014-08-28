<?php

//comes after consent and before shopping page

include_once('redirector.php');

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>MelodiesFor.us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="./assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <script src="./assets/js/jquery.js"></script>
    <script src="./eventRecorder.js"></script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="./assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="./assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="./assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="./assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="./assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="./assets/ico/favicon.png">
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <span style='font-weight:bold;color:black' class="brand">MelodiesFor.us</span>
        </div>
      </div>
    </div>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h2 style='text-align:center'>Instructions</h2>
<p>
In the study, you will be visiting an online shopping environment for music. Please take the opportunity to sample the different songs and interact with the website.
</p><p>
For this study, we have given to you (in addition to the participation reward) a starting budget of $1.50. Using this budget, you have to purchase exactly one song in the music store. Any transaction in the shopping environment reduces your starting budget as described in the shopping environment. At the end of the study, you will receive any remaining money as a bonus payment.
 </p><p>
After completing your shopping, you will be redirected to a survey. The careful completion of the survey and the submission of the HIT marks the end of the study. There is no completion code. 
</p>
        <p style='text-align:center'><a id='beginBtn' href="shopping.php" class="btn btn-primary btn-large">Click to Begin &raquo;</a></p>
      </div>

      <hr>

      <footer>
      </footer>

    </div> <!-- /container -->

    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./assets/js/bootstrap-transition.js"></script>
    <script src="./assets/js/bootstrap-alert.js"></script>
    <script src="./assets/js/bootstrap-modal.js"></script>
    <script src="./assets/js/bootstrap-dropdown.js"></script>
    <script src="./assets/js/bootstrap-scrollspy.js"></script>
    <script src="./assets/js/bootstrap-tab.js"></script>
    <script src="./assets/js/bootstrap-tooltip.js"></script>
    <script src="./assets/js/bootstrap-popover.js"></script>
    <script src="./assets/js/bootstrap-button.js"></script>
    <script src="./assets/js/bootstrap-collapse.js"></script>
    <script src="./assets/js/bootstrap-carousel.js"></script>
    <script src="./assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>
