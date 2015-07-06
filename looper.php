<?php
	session_start();
	
	// Continues running the experiment until the user has finished the group
	include('config.php');
	include('functions.php');

	// Get session
	$sid = intval($_COOKIE['sid']);

	$db = db_connect();

	$group = get_from_session($sid, 'group_num');
	$transaction = get_from_session($sid, 'transaction');
	$treatment = get_from_session($sid, 'treatment_id');
	$action = $_GET['sendEmail'];  // based on user choice in purchase.php
	$mediaId = $_GET['mediaId'];
	
	if($action == 'true') {
		// email needs to be sent
		
		// adds media id to array
		if (isset($_SESSION['mediaId'])) {
			$_SESSION['mediaId'][] = $mediaId;
		} else {
			$_SESSION['mediaId'] = array($mediaId);
		}
		
		$action = 1;
	}
	else {
		$action = 0;
	}

	// Insert results into database
	$q = "INSERT INTO treatment_selections(sid, treatment_id, action)
		  VALUES($sid, $treatment, $action)";
	runQuery($db, $q, false);
	
	/*
		If $action is true, then media id should be added to an array
		that contains all media to be sent at final transaction 
	*/ 

	if($transaction == 12) {
		// Redirect to end survey, we're at the end
		header('Location: endSurvey.php?sendEmail=' . $_GET['sendEmail'] . '&post_email=' . $_GET['post_email']);
		die;
	}
	else {
		// increments transaction 
		$newSeq = $transaction+1;
		
		// Get the ID of the next item in the sequence (transaction)
		// $q = "SELECT id FROM treatment WHERE sequence = $newSeq AND group_num = $group LIMIT 1";
		// $result = runQuery($db, $q, true);

		// $newTreatment = $result[0]['id'];

		// updates transaction num for session
		edit_session(array('transaction' => $newSeq), true, 'override');

		// Redirect back to shopping
		header('Location: shopping.php?success&transaction='.$newSeq);
		die;
	}
?>