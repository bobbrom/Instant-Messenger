<?php
session_start();
require_once 'dbconnect.php';
$profile_id = $_SESSION['id'];
$count = $_POST['count'];

$messageId = $_POST['messageId'];
if($messageId > 0){
    $insert = "AND profile_id != ".$messageId;
}
$sql = sprintf(
           "SELECT COUNT(DISTINCT(message_id)) as number
            FROM `messages` 
            WHERE `recipient_id`= %d
            AND `Time_Seen` = 0
            {$insert}
            Limit 1",
        mysqli_real_escape_string( $conn, $profile_id )
    );
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$SQLcount = $row['number'];	
			//echo $SQLcount;
		if($SQLcount == $count){
			echo false;
		}else{
			echo $SQLcount;
		}
}else{
	echo false;
}
?>