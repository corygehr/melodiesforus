<?php 

include_once('functions.php');

if(array_key_exists('consent', $_GET) && $_GET['consent'] == 'yes') {
	edit_session(array('consent'=>'yes'),true, 'override'); 
	redir('intro.php');
}
else {
	redir('consent.php');
}

