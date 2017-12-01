<?php
session_start();
$profile_id = $_SESSION['id'];

require_once 'dbconnect.php';
require_once 'Functions.php';

require_once 'emojione/lib/php/autoload.php';

$page = filter_input(INPUT_POST, 'page', FILTER_VALIDATE_INT);
$recipient_id = filter_input(INPUT_POST, 'recipient_id', FILTER_VALIDATE_INT);


$sql = "
		SELECT COUNT(id) as count FROM `messages`
		WHERE `profile_id` = {$profile_id}
		OR `profile_id`= {$recipient_id}
		AND `recipient_id` = {$profile_id}
		OR `recipient_id` = {$recipient_id}
		";
		
		
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$countSQL = $row['count'];
	}
}



$lowerAmount = 0;
$upperAmount = ($page+1)*10;

echo getMessages($profile_id,$recipient_id,$conn, $countSQL, $lowerAmount, $upperAmount);

?>