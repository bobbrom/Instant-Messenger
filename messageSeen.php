<?php
session_start();
require_once 'dbconnect.php';

$profile_id = $_SESSION['id'];
$recipient_id = filter_input(INPUT_POST, recipient_id, FILTER_VALIDATE_INT);

$sql = "UPDATE messages
		SET `Time_Seen` = CURRENT_TIMESTAMP 
		WHERE `profile_id` = {$recipient_id}
		AND `recipient_id` = {$profile_id}";

$result = $conn->query($sql);
?>