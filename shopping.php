<?php
//This is the media shopping page

include_once('functions.php');
session_start();
//include_once('redirector.php');

// get session
$sid = intval($_COOKIE['sid']);

// get entered part_group
$participant_group = getParticipantGroupForSession($sid);

$group = 'group_'.$participant_group;

// get code based on group and transaction num (get trans_num where id = )
$transaction_num = getTransactionForSession($sid);
$code = getParticipantGroupCode($participant_group, $transaction_num);
$_SESSION['group_code'] = $code;

// Get media type from code
$selectedType = getMediaTypeFromCode($code);

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
			 var song = $(this).closest("div").find(".hiddenMediaTitle").html();
			 var artist = $(this).closest("div").find(".hiddenMediaArtist").html();
			 var songId = $(this).closest("div").find(".hiddenMediaId").text();
			 $('#cart_title').html(song);
			 if (artist.length > 0) {
				 $('#cart_artist').html('by ' + artist);
			 }
			 $('#songId').val(songId);
		 });
		 
		 $('#clearCartBtn').click(function(e) {
			 $('#cart_title').html('');
			 $('#cart_artist').html('');
			 $('#cart_price').html('');
		 });
		 
	 });

	 </script>
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

  <body class="shoppingPage">

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <span style='font-weight:bold;color:black' class="brand">WebMed.ia</span>
        </div>
      </div>
    </div>
	
	<!--<p>Group Num: <?php echo $group ?></p>
	<p>Trans Num: <?php echo $transaction_num ?></p>
	<p>Code: <?php echo $code ?></p>
	<p>Media Type: <?php echo $selectedType ?></p>-->

    <div class="container contentWidth">

<!--Transaction-->

      <!-- Main hero unit for a primary marketing message or call to action -->

      <div  class='row'>

      <div id='shoppingContentWrapper' class='span13'>

      	<div class="row">

<?php 
		$media = get_media_by_type($selectedType);

		if($media) {

			$count=1;

			foreach($media as $m) { 
				// Change module to change media display 
				if($count>1 && ($count-1)%3 == 0) {
		  			echo "</div><div class='row'>";
		  		}
?>
		  
		  <div class='shoppingPage__span' >
			  <div class='shoppingPage_displayMediaInfo'>
				  <div class='shoppingPage_mediaInfo'>
				  <!--Info about media author, genre, etc.-->
			        <h3 class='shoppingPage_mediaName'><?php echo $m['name']; ?></h3>
					<!--If there is an author, show author-->
					<?php
						if (strlen($m['author']) > 0) {
					?>
							<h4 class='shoppingPage_mediaAuthor'>by <?php echo $m['author']; ?></h4>
					<?php
						}
					?>
					<!--If there is a genre to show, shows genre-->
					<?php 
					   if(strlen($m['genre']) > 0) {
					?>
							<h4 class='shoppingPage_mediaGenre'>Genre: <?php echo $m['genre']; ?></h4>
					<?php 
					   }
					?>
				</div>
				<div class='shoppingPage_mediaGraphic'>
					<!--Displays users media choice in cart-->
					<p style='display:none;' class='hiddenMediaTitle'><?php echo $m['name']."<br>"; ?></p>
					<p style='display:none;' class='hiddenMediaArtist'><?php echo $m['author']."<br>"; ?></p>
					<p style='display:none;' class='hiddenMediaId'><?php echo $m['id']; ?></p>
					<!--Displays media graphic-->
					<!--If the media graphic is of media type 1 (music), set graphic size to 100x100-->
					<?php
						if($m['media_type'] == 1) {
					?>
							<div><?php echo "<img style='float:left' src='". $m['cover_path'] . "' width=100 height=100 />"; ?></div>
					<?php
						}
					?>
					<!--If media type is of type 21 (ebook), set graphic size to 50x50-->
					<?php 
						if($m['media_type'] == 21) {
					?>
							<div><?php echo "<img style='float:left' src='". $m['cover_path'] . "' width=50 height=50 />"; ?></div>
					<?php
						}
					?>
				</div>
			</div>		
				<?php
					switch($m['media_type']) {
						// Media type is a song 
						case 1:
							echo "<div class='shoppingPage_mediaSong'>";
								echo "<audio class='shoppingPage_mediaSong' onmousedown='logEvent(\"player".$m['id']."\",\"click\", true)' src='" . $m['path'] . "' controls preload></audio>";
							echo "</div>";
						break;
						
						// Media type is a video 
						case 11:
							echo "<div >";
								echo "<video onmousedown='logEvent(\"player".$m['id'].",\"click\", true)' src='" . $m['path'] . "' width='250' height='250' controls></video>";
							echo "</div>";
						break;
		
						// Media type is ebook 
						case 21:
							echo "<p class='shoppingPage_mediaDescription'>";
								echo "{$m['description']}";
							echo "</p>";
						break;
					}
				?>
			<br/>
			<a class="btn addToCart shoppingPage_AddToCartButton" id='addToCartBtn'<?php echo $m['id']; ?>'href="#">Add to cart ($0.99) &raquo;</a>
        </div>
		  
		  <?php
		  		$count++;
			}
		}
		  
		  ?>
		</div> <!--last media block -->

<!--Beginning of User Purchase form-->
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
<!--Displays user purchase form-->
      <div id='secondStage' class='row' style='display:none'>
			<div class='span8'>
				<div name='extraInfoContent' > 
					<h4 style='text-decoration:underline'>Please enter the following information to complete your purchase:</h4>
					<div class='errorMsgTop'></div>

					<form id='purchaseForm' action='purchase.php' method='POST'>
					<div>
						<?php
							// Ask for mturk id if we're using it
							if(USE_MTURK == true)
							{
								echo "<input type='text' required placeholder='Mechanical Turk ID' name='pre_mturk_id' /><br/>";
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


		<div id='rightSide' class='span3' style='float: right'>
			<div class='row'>
				<!--Displays users bank-->
				<h4 class='shoppingPage_userBank'>User Bank: $1.50</h4>
				<!--Shopping Cart-->
				<div class='shoppingPage_cartSpan span3 shoppingPage_cartSpanBorder'>
					<div class='row'>
						<div class="span3" id='shoppingPage_cartMediaArea'>
							<h3 class='shoppingPage_CartHeading'>Cart:</h3>
							<p id='cart_title'>
								<!-- Info about song user chooses will appear here -->
							</p>
							<p id='cart_artist'>
								<!--Info about artist will appear here-->
							</p>
						</div>
					</div>
					
					<!--Within Cart div, 'purchase' and 'clear cart' buttons-->
					<div class='row shoppingPage_BtnCart'>
						<div class="span3" id='cartBtnArea'>
							<a class="btn" href="#" id='purchaseBtn' onclick='doPurchase();'>Purchase</a>
							<a class="btn" href="#" id='clearCartBtn'>Clear cart</a>
						</div>
					</div>
											
				</div>
				
				<!--Moved transaction information here to save space-->
				<div class='shoppingPage_cartSpan span3' >
					<!--Displays which transaction the user is on-->
						<?php
							if(isset($_GET['success'])) {
								// $transaction = $_GET['transaction'];
								echo "<span class='shoppingPage_transactionHeading'>Transaction Complete!</span>";
								echo "<p class='shoppingPage_transactionInfo'>Now on Transaction: <strong style='font-size: 15px'>$transaction_num</strong></p>";
							}
						?>
				</div>
				
			</div> <!-- cart row -->

		 <script>
		 function doPurchase() {
			 var cart = $('#cart').html();
			 var cartSong = $('#cart_title').html();
			 if(typeof cartSong == 'undefined') {
          		alert('You must add an item to your cart.');
				return false;
			 }
			 logEvent('purchaseBtn', 'click+success', true);
			 insertPurchaseScreen();
			 return true;
		 }

		 function insertPurchaseScreen() {
			$('#shoppingContentWrapper .row:not(#secondStage)').hide();
			$('#cartBtnArea').html("---------------------------------<br/>Total: $0.99");
			$('#cartBtnArea').css('align','right');

			logEvent('secondStage', 'show');

			$('#secondStage').show();
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

