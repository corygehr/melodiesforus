<?php

include('functions.php');

$session_id = array_key_exists('sid', $_COOKIE) ? $_COOKIE['sid'] : '';
$page_name = array_key_exists('page_name', $_GET) ? $_GET['page_name'] : '';
$subject_name = array_key_exists('subject_name', $_GET) ? $_GET['subject_name'] : '';
$event_name = array_key_exists('event_name', $_GET) ? $_GET['event_name'] : '';
$current_time = array_key_exists('current_time', $_GET) ? $_GET['current_time'] : '';
$current_time_ms = array_key_exists('current_time_ms', $_GET) ? $_GET['current_time_ms'] : '';


if(in_array($page_name, $PAGES))
	recordEvent($session_id, $page_name, $subject_name, $event_name, $current_time,$current_time_ms); 
