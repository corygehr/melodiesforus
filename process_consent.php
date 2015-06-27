<?php 

include_once('functions.php');

$participantGroup = $_GET['participant_group'];
$consent = $_GET['consent'];



// will need to check that participant group data has been entered and is correct
// 


if($consent) {
	edit_session(array('consent'=>'yes'),true, 'override'); 
	redir('intro.php');
}
else {
	redir('consent.php');
}
