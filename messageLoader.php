<?php
session_start();
$profile_id = $_SESSION['id'];
header("Content-type: text/plain");
require_once 'dbconnect.php';
require_once 'Functions.php';

require_once 'emojione/lib/php/autoload.php';

$count = $_POST['count'];
$recipient_id = filter_input(INPUT_POST, 'recipient_id', FILTER_VALIDATE_INT);


$x = 0;
$html = '<div class="innerMessages" >';

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
		
			if($countSQL === $count){
				echo false;
			}else{
				getMessages($profile_id,$recipient_id,$conn, $countSQL);
				/*
				$html =      "<li class='message_cover'>
						  <div class='recipient'>
						  <p class='message'>{$countSQL}</p><br>
						  <p class='message'>{$typing}</p>
						  </div>
						  </li>";
						  
					$data = array(
									'html' => $html,
									'profile_id' => ''
								);
					echo json_encode($data);
				*/
			}
			
	}
}else{
	echo false;
}


	
?>