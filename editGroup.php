<?php
	// Continues running the experiment until the user has finished the group
	include('config.php');
	include('functions.php');

	$message = '';

	$db = db_connect();

	if(isset($_POST['phase']) && $_POST['phase'] == 'updateGroup') {
		// Get new group number
		$newGroup = $_POST['group'];

		$q = "UPDATE settings SET value = $newGroup WHERE name = 'CURRENT_GROUP' LIMIT 1";
		runQuery($db, $q, false);
		$message = "Update success!";
	}

	$q = "SELECT value FROM settings WHERE name = 'CURRENT_GROUP' LIMIT 1";
	$result = runQuery($db, $q, true);

	$currentGroup = $result[0]['value'];
}
?>
<!DOCTYPE html>
<head>
	<title>Update Group</title>
	<script src="//code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="./eventRecorder.js"></script>
	<link href="./assets/css/bootstrap.css" rel="stylesheet">
</head>
<body>
<?php
	if($message) { echo "<p>$message</p>"; }
?>
	<h1>Update Group</h1>
	<p>
		Please enter the desired group number below. This impacts
	</p>
	<form>
		<fieldset>
			<input type='hidden' name='phase' value='updateGroup' />
			<label for='group'>Group Number:</label>
			<input name='group' value='<?php echo $currentGroup; ?>' />
			<input type='submit' value='Update Group' />
		</fieldset>
	</form>
	<script src="./assets/js/bootstrap-transition.js"></script>
	<script src="./assets/js/bootstrap-alert.js"></script>
	<script src="./assets/js/bootstrap-modal.js"></script>
	<script src="./assets/js/bootstrap-dropdown.js"></script>
	<script src="./assets/js/bootstrap-scrollspy.js"></script>
	<script src="./assets/js/bootstrap-tab.js"></script>
	<script src="./assets/js/bootstrap-tooltip.js"></script>
	<script src="./assets/js/bootstrap-popover.js"></script>
	<script src="./assets/js/bootstrap-button.js"></script>
	<script src="./assets/js/bootstrap-collapse.js"></script>
	<script src="./assets/js/bootstrap-carousel.js"></script>
	<script src="./assets/js/bootstrap-typeahead.js"></script>
</body>
</html>