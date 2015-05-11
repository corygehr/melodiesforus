<?php
	// Continues running the experiment until the user has finished the group
	include('config.php');
	include('functions.php');

	// Get session
	$sid = intval($_COOKIE['sid']);

	$db = db_connect();

	$group = get_from_session($sid, 'group_num');
	$transaction = get_from_session($sid, 'transaction');
	$treatment = get_from_session($sid, 'treatment_id');
	$action = $_GET['sendEmail'];
	
	if($action == 'true') {
		$action = 1;
	}
	else {
		$action = 0;
	}

	// Insert results into database
	$q = "INSERT INTO treatment_selections(sid, treatment_id, action)
		  VALUES($sid, $treatment, $action)";
	runQuery($db, $q, false);

	if($transaction == 12) {
		// Redirect to end survey, we're at the end
		header('Location: endSurvey.php?sendEmail=' . $_GET['sendEmail'] . '&post_email=' . $_GET['post_email']);
		die;
	}
	else {
		// Get the ID of the next item in the sequence (transaction)
		$newSeq = $transaction+1;
		$q = "SELECT id FROM treatment WHERE sequence = $newSeq AND group_num = $group LIMIT 1";
		$result = runQuery($db, $q, true);

		$newTreatment = $result[0]['id'];

		edit_session(array('treatment_id' => $newTreatment, 'transaction' => $newSeq), true, 'override');

		// Redirect back to shopping
		header('Location: shopping.php?success&transaction='.$newSeq);
		die;
	}
?>