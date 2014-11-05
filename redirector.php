<?php

//This file ensures that participants view the right pages at the right times

$override = false;
if(array_key_exists('override', $_COOKIE)) {
	$override = true;
}

if(array_key_exists('override', $_REQUEST)) {
	setcookie("override", 'true', time()+3600); //1 hour
	$override = true;
}


include('config.php');

if(!EXPERIMENT_OPEN && !$override) {
	die('OLD. This experiment is now closed. Thank you for your participation.');
}


include_once('functions.php');

// Check for the user asking to reset the environment
if(isset($_POST['phase']) && $_POST['phase'] == 'resetEnv')
{
	// Clear cookie and redirect to start
	unset($_COOKIE['sid']);
	setcookie('sid', null, -1, '/');

	header('Location: /');
	exit();
}


if(has_finished(-1)) {
	redir("thankYouPage.php");
}
else {
	if(!array_key_exists('sid', $_COOKIE)) {
		redir("consent.php", true);
	}
	else {
		$sid = intval($_COOKIE['sid']);

		if(!has_consented($sid)) {
			redir("consent.php", true);
		}
		else {

			if(!has_done_presurvey($sid)) {
				if("intro.php" != basename($_SERVER["SCRIPT_FILENAME"]))
         	redir("shopping.php");
			}
			else {
				if(!has_seen_negative_option($sid)) { //pre survey done
					redir('purchase.php', true);
					//go to negative options page
				}
				else {
					if(has_finished($sid)) {
						redir("thankYouPage.php");
					}                      
					else {
                	redir('endSurvey.php');
					}
				}
			}
		}
	}
}         
