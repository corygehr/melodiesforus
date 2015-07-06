<?php

//This page delegates to pages that show survey, process survey, send mail
// start session
session_start();
include_once('functions.php');

if(array_key_exists('prevPage', $_REQUEST) && $_REQUEST['prevPage'] == 'survey') {
	include('endPage.php');
	die;
}

$sid = intval($_COOKIE['sid']); //for security
$email_sent = false;

// EMAIL
// echo $_SESSION['mediaCount']."<br>";
if ( isset($_SESSION['mediaId']) ) {
	 // TRACE 
	foreach($_SESSION['mediaId'] as $id => $mediaId) {
			echo $id." = ".$mediaId."<br>";
	}
	
	$mediaToSend = $_SESSION['mediaId'];

	if (count($mediaToSend) > 0) {
		// there are some emails that need to be sent
		echo "need to send ".count($mediaToSend)." emails</br>";
		sendEmail();
	} else {
		// TRACE
		echo "No messages to send</br>";
	}
}



// This wont work, need to check if user wanted any emails sent, not just last transaction
// if(array_key_exists('sendEmail', $_GET)) {
// 	$wantsEmail = ($_REQUEST['sendEmail'] != 'false');
// 	if($wantsEmail) { 
// 		sendEmail(); // start function to send email
// 	}
// }
if(array_key_exists('post_email', $_REQUEST)) {
	$email = htmlentities($_REQUEST['post_email'], ENT_QUOTES);

   if(!has_seen_negative_option($sid)) { //first time submitting

      $newData = array('post_email'=>$email, 
		               'sid'=>$sid,
					   'email_sent'=>var_export($email_sent, true));

		edit_session($newData, true, 'post');
	}
	else {  //record attempt to change 
		recordCheater($sid, $email_sent ? "true":"false");
	}
}          

function sendEmail() {
	global $sid;
	
	$to = getEmailForCurrentSession(); //from functions.php

	if($to == 'undef') {
		$to = str_replace("'",'',$_GET['post_email']);
	}

	$email_sent = true;
	// get songId from SESSION instead
	// for each songId added to session, send email
	// $songId = get_from_session($sid, 'songId', true);
	
	
	
	//tis avoid duplicates being sent when someone reloads the page
	foreach($_SESSION['mediaId'] as $id => $mediaId) {
		
		if(!has_seen_negative_option($sid)) { 
			echo "Sending ".$mediaId."</br>";
			include('PHPMailer/mailer.php');
		} 
	}

	unset($_SESSION['mediaId']);
	
}

// EMAIL

include_once('redirector.php');

                                  
?>

<script src="./assets/js/jquery.js"></script>
<script src="./eventRecorder.js"></script>



<script>
	 $(document).ready(function() {
		$('input:text').addClass('input-block-level');
		$('button').addClass('btn');
		$('button').addClass('btn-primary');
		$('button').addClass('btn-large');
		$('button').css('margin-left','40%');
		$('button').eq(0).attr('id','submitBtn');
  });
</script> 
 

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <span style='font-weight:bold;color:black' class="brand">WebMed.ia</span>
        </div>
      </div>
    </div>

    <div class='endSurvey_div'>
    	<p>
    		You have completed the final transaction! Please complete the survey below to finish.
    	</p>
 		<div class='row'>
			<div class='span8'>
 
				<?php
					
					include('survey/survey.php');
					
				?>

			</div> <!-- spanX -->
		</div> <!-- row-->
	
	</div> <!-- container -->

<link href="../assets/css/bootstrap.css" rel="stylesheet">

<style>
legend {
	border:0px;
}
</style> 
