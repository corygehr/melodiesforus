<?php                        

//This is the post-transaction offer page.
// start session
session_start();


include_once('functions.php');

$sid = intval($_COOKIE['sid']);

if(array_key_exists('pre_email', $_REQUEST)) {
	$email = htmlentities($_REQUEST['pre_email'], ENT_QUOTES);
	
	if(USE_MTURK) {
		$mturk_id = htmlentities($_REQUEST['pre_mturk_id'], ENT_QUOTES);
	}
	else {
		$mturk_id = false;
	}
	$age = intval($_REQUEST['pre_age']);
	$songId = intval($_REQUEST['songId']);
	$zip = ''.intval($_REQUEST['pre_zip']);
	edit_session(array('pre_email'=>$email, 'sid'=>$sid, 'pre_zip'=>$zip, 'pre_mturk_id'=>$mturk_id,'pre_age'=>$age, 'songId'=>intval($_REQUEST['songId'])), false, 'pre');
}
else {
	$email = get_from_session($sid,'pre_email');
	$songId = get_from_session($sid,'songId', true);
}

//include_once('redirector.php');


//get the treatment and its properties for the current session
$treatment = getTreatmentForSession($sid);

$box_value = '';
$prepop = $treatment['pre-pop'];
$opt = $treatment['opt'];
if(substr($prepop, 0, 3) == 'yes'){
	$box_value = htmlentities($email, ENT_QUOTES);
}

$box_display = 'block';
$box_hidden = false;
if($prepop == 'yes-hidden') {
	$box_display = 'none';
	$box_hidden = true;
}

$wt = $treatment['warning_type'];
$warning_msg = $treatment['warning_msg'];


//shows interstitial warnings
function showInterstitial() {
	global $warning_msg, $wt;
	$toExec = '$("#interstitial").hide();logEvent("interstitial", "hide");';
	?>

			
	<div id='interstitial' style='position:absolute;left:0;top:0;width:100%;height:100%;text-align:center;background-color:white;display:table'>
		<div style='display:inline-block;margin:0 auto;display:table-cell;vertical-align:middle'>

			<center>
				<div style='border: 3px solid black;padding:10px;height: 150px; width:500px'>
					<?php echo $warning_msg; 
					
					if($wt == 'interstitial_button') {
						echo "<br><button id='hide_interstitial_btn' style='margin-top:30px;height:50px;width:75px' onclick='$toExec'>Okay</button>";
					}
					else {    //interstitial_timer_[long/short]
						$length = str_replace('interstitial_timer_','',$wt);
						$waitTime = 10000; //10 secs
			
			         if($length == 'short') {
							$waitTime = 5000; //5 secs
						}
						
						echo "<script>setTimeout('$toExec', $waitTime);</script>";
					}
					
					
					?>
				</div>
			</center>
		</div>
	</div>


<?php
}

if($wt != 'checkout' && $wt != 'none')  {
	showInterstitial();
}
?>      

<script src="./assets/js/jquery.js"></script>
<script src="./eventRecorder.js"></script>
<script type="text/javascript" src="./survey/js/jquery.validate.js"></script>
<link href="./assets/css/bootstrap.css" rel="stylesheet">

<script>
	
	function next(yesno) {
	   opt = '<?php echo $opt; ?>';
	   mediaId = <?php echo $songId;?>
	
		logEvent('opt_'+ opt +'_btn', 'opt_'+ opt + '=' + yesno, false);
	
		sendEmail = false;
		
		// if opt == out, user needs to 'opt out' of the delivery system
		// if opt == in, user needs to 'opt in' to the delivery system
		
		if(yesno == 'no') { //clicked no btn
			if (opt == 'out') {
				// User wants email to be sent to them
	      		sendEmail = true;  
			}
		} else { //clicked big yes btn
	   		if(opt == 'in') {
			// 	// User wants email to be sent to them 
				sendEmail = true;
			}
		}
	
		post_email = $('#post_email').val();
	
		window.location = 'looper.php?sendEmail=' + sendEmail + '&post_email=' + post_email + '&mediaId='+ mediaId;
	}
</script>

<!-- use this iframe to start the download -->
<?php
	$paths = get_media_path($songId);
	
	$mediaPath = "";

	if($paths) {
		$mediaPath = $paths[0]["zip_path"];
	}
?>
<iframe width=1 height=1 style='display:none' src='<?php echo $mediaPath; ?>'></iframe>

  <body>

    <div class="purchasePage_Container">
	 		<div class='row'>
	 			<div class='span13'>
					<p class='purchasePage_orderConf'> 
						<span>Thank you!</span> WebMed.ia has processed your order.
					</p>
					<!--Replaced table with divs, easier to deal with, less code-->
					<div class='purchasePage_SafeDeliveryDiv'>
						<h2 class='safeDelivery_heading'>Get your purchase sent to you safely and securely with SafeDelivery</h2>
						<div class='safeDelivery_Info'>
							<div>
								<p class='safeDelivery_servicesHeading'>SafeDelivery offers you the following services:</p>
								<ul class='safeDelivery_services'>
									<li>Extra security for your media delivery.</li>
									<li>An additional way to access your media.</li>
									<li><span style="text-decoration: underline;">SAVE 50% </span> when your media is delivered by email.</li>
								</ul>
							</div>
							<img src="./assets/img/woman.jpg" border="0" alt="Woman " title="Woman" width="195" height="150" style="float: right;" />
						</div>
					</div>
					
					<!--Removed second table, created series of divs instead-->
					<div class='purchasePage_emailAndConditionsDiv'>
						<div class='emailAndConditionsDiv_leftSide'>
							<div class='leftSide_topContainer'>
								<!--put all email validation forms and such in this div -->
								<div class='leftSide_currentSafeDeliverySettings'>
									<!--Informs user of SafeDelivery choice-->
									<?php 
										$start_text = 'Entering your email address ';
								
										$end_text = 'automatically charge your budget according to the Offer Details to the right';
								
								
										if($box_hidden || $prepop != 'no') {
								      		$start_text = 'Clicking the button ';
										}
								
										if($opt == 'out') {
											$start_text = 'You are subscribed to the SafeDelivery service. ' . $start_text;
											$end_text = 'remove you from the SafeDelivery service described to the right';
										}
										echo "<p>$start_text below constitutes your electronic signature and we will $end_text.</p>";
									?>
								</div>
								<div class='leftSide_emailValidationForm'>
									<!--Email validation form-->
									<form id='post_email_form'>
										<p style="text-align: center;">
											<span style='display:<?php echo $box_display; ?>'>
												E-mail Address: 
												<input type='text' id='post_email' class='input-block-level' style='margin-top:5px;width:85%' placeholder='Email Address' value='<?php echo $box_value; ?>' name='post_email' />
											</span>
											<style>
												input.error, select.error {
													background: #FFC;
												}
												label.error {
													display:none;
												}
											</style>
											<?php
												$button_text = 'Email media';
										
												if($opt == 'out') {
													// the user needs to 'opt out' of the delivery system
										      		$button_text = 'Remove me from SafeDelivery';
												}
										
												echo "<a href='#' id='submitBtn' class='btn btn-large' style='font-family:times;width:75%' onclick='do_validation()' type='submit'>$button_text</a>";
											?>
											<script>
		
												function do_validation() {
													if($("#post_email").valid() == '1') {
														next("yes");
														<?php $yesno = 'yes'; ?> 
													}	
												}
												
												function say_no() {
													next("no");
													<?php $yesno = 'no';?>
												}
												
												$('#post_email_form').validate({
													rules: {
														post_email: {
															required: true,
															email: true
														}
													} 
										
												});
											</script>
											<br/><br/>
											<a href='#' onclick='say_no()'>No thanks</a>
										</p>
									</form>
								</div>
							</div>
							<h3 class='leftSide_UserBank'>User Bank: $0.51</h3>
						</div>
						<div  class='emailAndConditionsDiv_rightSide'>
							<!--Put all terms and conditions in this div-->
							<p class='safeDelivery_servicesHeading'>SafeDelivery Details:</p>
							<p>
								SafeDelivery is a trustworthy provider for digital communications and the delivery of digital content. 
								This service is offered by leading online music retailers to ensure that customers get the music they 
								want without problems. There are many benefits of using SafeDelivery.
							</p>
							<ul>
								<li>
									If you lose your original copy of the media, you will always have a second copy available.
								</li>
								<li>
									You save 50% when ordering the delivery of a copy of your media via SafeDelivery email.
								</li>
								<li>
									We guarantee that the emailed copy is the same as the initial selection.
								</li>
								<li>
									100% satisfaction guaranteed.
								</li>
							</ul>
							<p class='safeDelivery_servicesHeading'>Offer Details:</p>
							<?php
								$start_text = 'type in your email address and ';
								$pre_text = '';
								if($box_hidden) {
						      		$start_text = '';
								}            
								if($opt == 'out') {
						      		$pre_text = 'You have been subscribed to the SafeDelivery service.';
									$button_text = 'No thanks';
								}
								echo "<p>".$pre_text." Simply ".$start_text."click \"$button_text\" to use our services and to take 
								advantage of the great value that SafeDelivery provides. By clicking \"$button_text\" you will 
								receive a safe email copy of the identical item you selected in the WebMed.ia store for just $0.50. 
								This is a 50% DISCOUNT for the additional copy. You will SAVE an incredible $0.50 on this purchase. 
								When you agree to use SafeDelivery you will receive your WebMed.ia selection delivered in a timely 
								manner by email to your account. Your emailed backup copy of the item will help you to have 
								continued access to your media in case of data loss or when you are using different computers. 
								Alternative offers will not give you the same satisfaction or the same $0.50 DISCOUNT. Because of 
								this special reduced offer price we cannot offer any refunds. We always strive to serve our 
								customers to provide them with the quickest and most reliable mode of music delivery. Our customers 
								have the highest degree of satisfaction with SafeDelivery and we invite you to try our offer.</p>";
							?>
						</div>
					</div>