<?php 
session_start();
include_once('functions.php');

$participantGroup = $_GET['participant_group']; // gets entered num
$_SESSION['participant_group'] = $participantGroup; // should make num available on shopping page
$consent = $_GET['consent'];

if($consent) {
	// could also change group_num here
	edit_session(array('consent'=>'yes'),true, 'override'); 
	redir('intro.php');
}
else {
	redir('consent.php');
}
