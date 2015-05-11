<?php

//This is the music shopping page
include_once('functions.php');
//include_once('redirector.php');

$sid = intval($_COOKIE['sid']);
$treatment = getTreatmentForSession($sid);

$wt = $treatment['warning_type'];
$warning_msg = $treatment['warning_msg'];

// Get the media types for this treatment
$treatment = get_from_session($sid, 'treatment_id');

$db = db_connect();

$q = "SELECT media_type FROM treatment WHERE id = $treatment LIMIT 1";

$result = runQuery($db, $q, true);

$selectedType = $result[0]['media_type'];
 
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="./assets/js/jquery.js"></script>
    <script src="./eventRecorder.js"></script>
	 <script type="text/javascript" src="./survey/js/jquery.validate.js"></script>

	 <script>
	 $(document).ready(function() {
		 $('.addToCart').click(function(e) {
			 var song = $(this).closest("div").find(".hiddenMediaArtist").html();
			 var songId = $(this).closest("div").find(".hiddenMediaId").text();
			 $('#cart').html(song+": $0.99");
			 $('#songId').val(songId);
		 });
	 });

	 </script>

    <link href="./assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
		.span4 {
			border-top: 1px solid #eee;
			border-bottom: 1px solid #eee;
			max-width:300px;
			margin-left:-10px;
		}
		#bigGroup {
			border: 3px solid black;
			padding: 5px;
		}
		#cartSpan, #warningSpan {
			height: 164px;
			max-width:170px;
			padding: 10px;
			padding-right:15px;
			border: 3px solid black;
		}
		#warningSpan {
			display:none;
		}
		#cartMediaArea {
			height: 100px;
         max-width:170px;
			padding: 10px; 
		}
    </style>
    <link href="./assets/css/bootstrap.css" rel="stylesheet">

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
          <span style='font-weight:bold;color:black' class="brand">WebMed.ia</span>
        </div>
      </div>
    </div>

    <div class="container">

<?php
	if(isset($_GET['success'])) {
		$transaction = $_GET['transaction'];
		echo "<p>Transaction complete! You are now on transaction $transaction.</p>";
	}
?>

      <!-- Main hero unit for a primary marketing message or call to action -->

      <div style='margin-left:-10px;margin-top:-5px' class='row'>

      <div id='bigGroup' class='span13' style='margin-right:-10px'>

      <div class="row">

<?php 
		$media = get_media_by_type($selectedType);

		if($media) {

			$count=1;

			foreach($media as $m) { 

				if($count>1 && ($count-1)%2 == 0) {
		  			echo "</div><div class='row'>";
		  		}
?>
		  
		  
		  <div class="span4" style='padding-top:5px;padding-bottom:10px;padding-left:5px;'>
          <h3 style='margin-top:-13px;'><?php echo $m['name']; ?></h3>
			 <h4 style='margin-top:-8px;'><i> by <?php echo $m['author']; ?></i>
			   <span style='font-size:12px'>(<?php echo $m['genre']; ?>)</span>
				</h4>

				<h6 style='display:none;' class='hiddenMediaArtist'><?php echo $m['name']."<br> by ".$m['author']; ?></h6>
				<h6 style='display:none' class='hiddenMediaId'><?php echo $m['id']; ?></h6>
					<?php
						if($m['media_type'] != 11) {
					?>
					<div><?php echo "<img style='float:left' src='". $m['cover_path'] . "' width=100 height=100 />"; ?></div>
					<?php
						}
					?>
					<p>
					<?php
						switch($m['media_type'])
						{
							case 1:
								echo "<audio onmousedown='logEvent(\"player".$m['id']."\",\"click\", true)' style='float:right' src='" . $m['path'] . "' controls preload></audio>";
							break;

							case 11:
								echo "<video onmousedown='logEvent(\"player".$m['id'].",\"click\", true)' src='" . $m['path'] . "' width='250' height='250' controls></video>";
							break;

							case 21:
								echo "{$m['description']}";
							break;
						}
					?>
					</p>
					<br/>
          <a class="btn addToCart" style='margin-top:20px;float:right' id='addToCartBtn<?php echo $m['id']; ?>'href="#">Add to cart ($0.99) &raquo;</a>
        </div>
		  
		  <?php
		  		$count++;
			}
		}
		  
		  ?>
		</div> <!--last media block -->

		<script>
			$(document).ready(function(){
				$("#purchaseForm").validate({
					rules: {
						pre_email: {
							required: true,
							email: true
						},
						pre_age: {
							required: true,
							digits: true,
							minlength:2,
						  	maxlength:2,
						},
						pre_zip: {
							required: true,
							digits: true,
							minlength:5,
							maxlength:5,
						} 
					},
	   	});
		});

		</script>

		<style>
		.input-block-level { clear:none; }
		.error { display:inline; padding-left:5px; color:red }
		</style>

      <div id='secondStage' class='row' style='display:none'>
			<div class='span8'>
				<div name='extraInfoContent' style='padding-left:20px;max-width:600px'> 
					<h4 style='text-decoration:underline'>Please enter the following information to complete your purchase:</h4>
					<div class='errorMsgTop'></div>

					<form id='purchaseForm' action='purchase.php' method='POST'>
					<div>
<?php
	// Ask for mturk id if we're using it
	if(USE_MTURK == true)
	{
		echo "
						<input type='text' required placeholder='Mechanical Turk ID' name='pre_mturk_id' />
						<br/>";
	}
?>
						<input type='text' required placeholder='Age' name='pre_age' />
						<br/>
						<input type='text' required placeholder='Zip Code' name='pre_zip' />
						<br/>
						<input type='text' required placeholder='Email' name='pre_email' />
						<br/>
         			<input type="hidden" id='songId' name="songId" value="" />
					</div>

					<br/><br/>
					
					<p>Once you confirm your purchase, the <b>download</b> of the media will be initiated. For your convenience, you will receive a compressed zip file with the media.</p>
					<br/>

			 
					<a href="#" class="btn btn-large" id='proceedBtn' onclick="logEvent('proceedBtn', 'click', false); $('#purchaseForm').submit()">Proceed &raquo;</a>

					</form>
				</div>

			</div>
		</div>



      </div> <!-- big group of songs -->


		<div id='rightSide' class='span3'>
			<div class='row'>
				<div id='cartSpan' class='span3'>
					<div class='row'>
						<div class="span3" id='cartMediaArea'>
							<h3 style='margin-top:-20px;margin-left:-10px'>Cart:</h3>
							<p id='cart'></p> <!-- This is where the song goes -->
						</div>
					</div>

					<div class='row'>
						<div class="span3" id='cartBtnArea'>
							<a class="btn" href="#" id='purchaseBtn' onclick='doPurchase();'>Purchase</a>
							<a class="btn" href="#" id='clearCartBtn' onclick="$('#cart').html('');">Clear cart</a>
						</div>
					</div>
											
				</div>
			</div> <!-- cart row -->

			<div class='row' style='margin-top:10px'>
				<div id='warningSpan' class='span3'>
					<div class='row'>
						<div style='width: 160px;' class="span2">
							<p id='warning'></p> 
						</div>
					</div>
				</div>                           

			<div class='row'>
				<div class="span3" id='cartSecurityArea'>
				</div>
			</div>    
		</div>  <!-- right side -->

		 <script>
		 function doPurchase() {
			 var cart = $('#cart').html();
			 if(cart == '') {
          	alert('You must add an item to your cart.');
				return false;
			 }
			 logEvent('purchaseBtn', 'click+success', true);
			 insertPurchaseScreen();
			 return true;
		 }

		 function insertPurchaseScreen() {
			$('#bigGroup .row:not(#secondStage)').hide();
			$('#cartBtnArea').html("---------------------------------<br/>Total: $0.99");
			$('#cartBtnArea').css('align','right');


			logEvent('secondStage', 'show');

			$('#secondStage').show();

         <?php
			if($wt == 'checkout') {
         	echo "$('#warningSpan').show();";
				echo "$('#warning').html('$warning_msg');";
			}

			?>
		 }

		 </script>
 
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

