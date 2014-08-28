<?php
print "<pre>";

//This script gives approvals and bonuses.
//Each of these can be turned off with vars here.
//The default is to do a dry run, unless realrun.txt contains a 1.
//This script excludes action on mturk_ids that are in affected.csv.
//BE CAREFUL!
$approve = true;
$giveBonus = true;

$bonus_file = 'outfile.csv';
$record_file = 'affected.csv';
$realrun_file ='realrun.txt';

include_once(dirname(__FILE__).'/config/config.php');
include_once(dirname(__FILE__).'/../functions.php');

$dry = 1-intval(@file_get_contents($realrun_file));

$previously_affected = trim(file_get_contents($record_file));
if($previously_affected) {
	$previously_affected = explode(',', $previously_affected);
	$previously_affected = array_unique($previously_affected);
}
else {
	$previously_affected = array();
}


if($dry) {
	print "This is a DRY RUN. The actions below are NOT happening for real.\n";
}
else {
	print "This is NOT a dry run. The actions below ARE happening for real.\n";
}

include(dirname(__FILE__).'/MechanicalTurk.class.php');


$mturk = new MechanicalTurk(MTURK_KEY, MTURK_SECRET);

$wids_aids = $mturk->getWorkersAndAssignmentsForHIT(HIT_ID);
$wids = $wids_aids['wids'];
$aids = $wids_aids['aids'];


print "Found ".count($wids)." workers to record (from mturk).\n";
print "Found ".count($aids)." assignments to record (from mturk).\n";
print "Found ".count($previously_affected)." workers already affected (from $record_file).\n";
print "Found ".count(array_diff($wids, $previously_affected))." new workers to act on.\n";



print "\n------------------------------";
print "\nPAYING...DO NOT EXIT";
print "\n------------------------------\n";

//APPROVE HIT
$num_accepted = 0;
$num_rejected = 0;
$raw_total_bonus = 0;
$num_50 = 0;
$num_01 = 0;
$num_undef = 0;
$num_err = 0;
if($approve) {
	for($i=0;$i<count($wids);$i++) {
		if(in_array($wids[$i], $previously_affected)) {
			continue;
		}           

		$sid = get_sid_from_mturk_id($wids[$i]);

		$finished = has_finished_by_sid($sid); 

		if($finished)  {
			if(!$dry) { 
				$res = $mturk->approveHIT($aids[$i]);
			}

			if($giveBonus) {
				$email_sent = get_from_session($sid, 'email_sent'); 


				$bonus = 0;
				$data[$i]['bonus'] = 0.51;
				$bonusstr = '';

				if(strstr($email_sent,'true')) {
					$bonusstr = "You subscribed to SafeDelivery, therefore your bonus is $0.01.";
					$bonus = 0.01;
					$num_01++;
				}
				elseif(strstr($email_sent,'false')) {
					$bonusstr = "You did not subscribe to SafeDelivery, therefore your bonus is $0.50.";
					$bonus = 0.50;
					$num_50++;
				}
				elseif(strstr($email_sent,'undef')) {
            	$num_undef++;
				}
				else {

					$num_err++;
				}

				$raw_total_bonus += $bonus;
				if(!$dry) {
					$a = $mturk->grantBonus($wids[$i], $aids[$i], $bonus, $bonusstr);
				}         
			}


			$num_accepted++;
		}
		else {
			if(!$dry) { 
				$res = $mturk->rejectHIT($aids[$i],"You did not finish the task acceptably.");

			} 

			$num_rejected++;
		}
	}
	print "Assignments: Approved $num_accepted, rejected $num_rejected\n";
	print "Bonuses: $0.50 = $num_50, $0.01 = $num_01, undef = $num_undef, err = $num_err\n";
	
	$total_bonus = $raw_total_bonus*1.1;

	print "Total bonus: $total_bonus ($raw_total_bonus + 10%)\n";

	$total_expense = $total_bonus + $num_accepted*0.55;
	print "Total expense: $total_expense (bonus + $num_accepted*0.55)\n";
}
else {
	print "Approving assignments is OFF.\n";
}

//Record affected mturk_ids
sort($wids);
$affected = '';
for($i=0;$i<count($wids);$i++) {
   $affected .= $wids[$i].',';
}

if($dry) {
	print "NOT recording affected ids to $record_file\n";
}
else {
	print 'Recorded affected ids.\n';
	file_put_contents($record_file, $affected);
	file_put_contents($realrun_file, '0'); //only 1 real run at a time
}
