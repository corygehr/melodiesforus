<?php 
session_start();
include_once('functions.php');

$participantGroup = $_GET['participant_group']; // gets entered num
$consent = $_GET['consent'];

if($consent) {
	edit_session(array('consent'=>'yes'),true, 'override'); 
	setSessionGroup($participantGroup);
	redir('intro.php');
}
else {
	redir('consent.php');
}
