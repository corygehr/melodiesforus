<?php                        

//This is the post-transaction offer page.

include_once('functions.php');

$sid = intval($_COOKIE['sid']);

if(array_key_exists('pre_email', $_REQUEST)) {
	$email = htmlentities($_REQUEST['pre_email'], ENT_QUOTES);
	$mturk_id = htmlentities($_REQUEST['pre_mturk_id'], ENT_QUOTES);
	$age = intval($_REQUEST['pre_age']);
	$songId = intval($_REQUEST['songId']);
	$zip = ''.intval($_REQUEST['pre_zip']);
	edit_session(array('pre_email'=>$email, 'sid'=>$sid, 'pre_zip'=>$zip, 'pre_mturk_id'=>$mturk_id,'pre_age'=>$age, 'songId'=>intval($_REQUEST['songId'])), false, 'pre');

}
else {
	$email = get_from_session($sid,'pre_email');
	$songId = get_from_session($sid,'songId', true);
}
include_once('redirector.php');


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

<style>

table{
	margin-bottom:10px;
}
td {
	padding: 10px;
}

</style>
<script>

function next(yesno) {
   opt = '<?php echo $opt; ?>';

	logEvent('opt_'+opt+'_btn', 'opt_'+opt+'='+yesno, false);

	sendEmail = false;
	if(yesno == 'no') { //clicked no btn
		if(opt == 'out') {
      	sendEmail = true;
		}
	}
	else { //clicked big yes btn
   	if(opt == 'in') {
			sendEmail = true;
		}
	}

	post_email = $('#post_email').val();

	window.location = 'endSurvey.php?sendEmail='+sendEmail+'&post_email='+post_email;
}


</script>


<!-- use this iframe to start the download -->
<iframe width=1 height=1 style='display:none' src='songs/<?php echo $songId; ?>.zip'></iframe>


  <body>

    <div class="container" style='margin:10px'>
	 <div class='row'>
	 <div class='span13'>
         

<p> 
	<strong style="line-height: 1.3em;"><span style="font-size: xx-large;">Thank you! <span style="font-size: small;">MelodiesFor.us has processed your order.</span></span> </strong>
</p>
<table style="width: 1042px; height: 170px;">
<tr>
	<td style="background-color: #8a92ef; height: 75px; border-color: black; border-style: solid; border-width: 3px;" valign="middle">
	<p><span style="font-size: x-large; color: #ffffff;"> Get your song sent to you safely and securely with SafeDelivery</span></p>
</td>
<td rowspan="2" valign="top" style='border:0px'>
	<img src="./assets/img/woman.jpg" border="0" alt="Woman " title="Woman" width="250" height="198" style="float: right;" />
</td>
</tr>
<tr>
<td style="border-color: black; border-style: solid; border-width: 3px;" valign="top">
<p><span style="font-size: small;"><strong> SafeDelivery offers you the following services:</strong></span></p>
<ul>
	<li>Extra security for your song delivery.</li>
	<li>An additional way to access your song.</li>
	<li><span style="text-decoration: underline;">SAVE 50% </span> when your song is delivered by email.</li>
</ul>
</tr>
</table>

<table style="width: 1040px; height: 351px;">

<tr>
	<td style="width: 200px;border:solid 3px black" valign="top">
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

		$button_text = 'Email song';

		if($opt == 'out') {
      	$button_text = 'Remove me from SafeDelivery';
		}

		echo "<a href='#' id='submitBtn' class='btn btn-large' style='font-family:times;width:75%' onclick='do_validation()' type='submit'>$button_text</a>";

		?>
		
		<script>

		function do_validation() {
			if($("#post_email").valid() == '1') {
				next("yes");
			}	
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
		<a href='#' onclick='next("no")'>No thanks</a>
		</p></form>
	</td>
<td></td>
<td valign="top" style='border:solid 3px black;'>
	<p><span style="font-size: x-small;"><strong>SafeDelivery benefit details:</strong></span></p>
	<p>SafeDelivery is a trustworthy provider for digital communications and the delivery of digital content. This service is offered by leading online music retailers to ensure that customers get the music they want without problems. There are many benefits of using SafeDelivery.<br /> -If you lose your original copy of the song, you will always have a second copy available.<br /> -You save 50% when ordering the delivery of a copy of your song via SafeDelivery email.<br /> -We guarantee that the emailed copy is exactly similar to the initial selection.<br /> -100 Percent satisfaction guaranteed.</p>
	<p><span style="font-size: x-small;"><strong>Offer Details:</strong></span></p>

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
		echo "<p>".$pre_text." Simply ".$start_text."click \"$button_text\" to use our services and to take advantage of the great value that SafeDelivery provides. By clicking \"$button_text\" you will receive a safe email copy of the identical song you selected in the MelodiesFor.us store for just $0.50. This is a 50% DISCOUNT for the additional copy. You will SAVE an incredible $0.50 on this purchase. When you agree to use SafeDelivery you will receive your MelodiesFor.us selection delivered in a timely manner by email to your account. Your emailed backup copy of the song will help you to have continued access to your song in case of data loss or when you are using different computers. Alternative offers will not give you the same satisfaction or the same $0.50 DISCOUNT. Because of this special reduced offer price we cannot offer any refunds. We always strive to serve our customers to provide them with the quickest and most reliable mode of music delivery. Our customers have the highest degree of satisfaction with SafeDelivery and we invite you to try our offer.</p>";

	?>
</td>
</tr>

</table>
