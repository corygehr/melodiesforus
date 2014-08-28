<?php

//This is the music shopping page

 include_once('redirector.php');

$sid = intval($_COOKIE['sid']);
$treatment = getTreatmentForSession($sid);

$wt = $treatment['warning_type'];
$warning_msg = $treatment['warning_msg'];
 
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
			 var song = $(this).closest("div").find(".hiddenSongArtist").html();
			 var songId = $(this).closest("div").find(".hiddenSongId").text();
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
		#cartSongArea {
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
          <span style='font-weight:bold;color:black' class="brand">MelodiesFor.us</span>
        </div>
      </div>
    </div>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->

      <div style='margin-left:-10px;margin-top:-5px' class='row'>

		<?php

      $songstring = file_get_contents('songs/song_info.txt', true);
		$genres = array();
		$songs = array();
		$artists = array();
		$song_artists = array();
      foreach(explode("\n",$songstring) as $line) {
			$split = explode(":", $line);
			$genres[] = $split[0];
         if(count($split)>1){
				$song_artist = explode(" by ",trim($split[1]));
				$songs[] = $song_artist[0];
				$artists[] = $song_artist[1];
			}
		}

		?>

      <div id='bigGroup' class='span13' style='margin-right:-10px'>

      <div class="row">
		  
		  <?php 

		  for($i=1;$i<=6;$i++) { 
			 if($i>1 && ($i-1)%2 == 0) {
			 	echo "</div><div class='row'>";   
			 }

			 $j=$i-1;

			  ?>
		  
		  
		  <div class="span4" style='padding-top:5px;padding-bottom:10px;padding-left:5px;'>
          <h3 style='margin-top:-13px;'><?php echo $songs[$j]; ?></h3>
			 <h4 style='margin-top:-8px;'><i> by <?php echo $artists[$j]; ?></i>
			   <span style='font-size:12px'>(<?php echo $genres[$j]; ?>)</span>
				</h4>

				<h6 style='display:none;' class='hiddenSongArtist'><?php echo $songs[$j]."<br> by ".$artists[$j]; ?></h6>
				<h6 style='display:none' class='hiddenSongId'><?php echo $i; ?></h6>
					<div>
						<?php echo "<img style='float:left' src='./songs/song$i"."_cover.jpg' width=100 height=100 />";  ?>
					</div>
					
					<object style='float:right' onmousedown='logEvent("player<?php echo $i;?>","click", true)' data="dewplayer-mini.swf" width="160" height="20" name="dewplayer" id="dewplayer" type="application/x-shockwave-flash">
					
					<param name="movie" value="dewplayer-mini.swf" />
					<?php
						echo "<param name='flashvars' value='mp3=songs/".$i.".mp3' />";
					?>
					<param name="wmode" value="transparent" />
					</object>
					<br/>
          <a class="btn addToCart" style='margin-top:20px;float:right' id='addToCartBtn<?php echo $i; ?>'href="#">Add to cart ($0.99) &raquo;</a>
        </div>
		  
		  <?php   

		  }
		  
		  ?>
		</div> <!--last song block -->

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
						<input type='text' required placeholder='Mechanical Turk ID' name='pre_mturk_id' />
						<br/>
						<input type='text' required placeholder='Age' name='pre_age' />
						<br/>
						<input type='text' required placeholder='Zip Code' name='pre_zip' />
						<br/>
						<input type='text' required placeholder='Email' name='pre_email' />
						<br/>
         			<input type="hidden" id='songId' name="songId" value="" />
					</div>

					<br/><br/>
					
					<p>Once you confirm your purchase, the <b>download</b> of the song will be initiated. For you convenience, you will receive a compressed zip file with the song.</p>
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
						<div class="span3" id='cartSongArea'>
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
          	alert('You must add a song to your cart.');
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

