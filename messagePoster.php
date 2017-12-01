<?php
session_start();
require_once 'requires_no_echo.php';
$profile_id = $_SESSION['id'];
$recipient_id = filter_input(INPUT_POST, recipient_id, FILTER_VALIDATE_INT);
$message = filter_input(INPUT_POST, message, FILTER_SANITIZE_STRING);

$message = trim($message);

$message_length = strlen($message);


$character_length = 160;
$length = 0;
$message_cut = '';


	$message_id = uniqid();
	$part = 1;


while($message_length > $length){
	
	$message_cut = substr($message,$length,$character_length);
	$length += $character_length;	
	

	if($recipient_id){
		$sql = "
				SELECT id
				FROM `Conversations` 
				WHERE `first_user_id`= {$profile_id}
				AND `second_user_id`= {$recipient_id}
				OR `first_user_id`= {$recipient_id}
				AND `second_user_id`= {$profile_id}";
	
		$result = $conn->query($sql);
		
			if ($result->num_rows <= 0) {
				
				$sql = "
						INSERT INTO Conversations 
						(`first_user_id`, `second_user_id`)
						VALUES
						({$profile_id}, {$recipient_id})";
				mysqli_set_charset($conn, 'utf8mb4');
				$result = $conn->query($sql);
			
	}

	
	
	}else{
		$recipient_id = 0;
	}
	//echo $message_cut.'<br><hr>';
	// Post Message
	$sql = sprintf(
					"INSERT INTO messages (messages, profile_id, recipient_id, Part, message_id) VALUES ('%s', '%d', '%d', '%d', '%s')",
					mysqli_real_escape_string( $conn, $message_cut ),
					mysqli_real_escape_string( $conn, $profile_id ),
					mysqli_real_escape_string( $conn, $recipient_id ),
					mysqli_real_escape_string( $conn, $part ),
					mysqli_real_escape_string( $conn, $message_id )
				);
	
	mysqli_set_charset($conn, 'utf8mb4');
	if (mysqli_query($conn, $sql)) {
		if($part === 1){
			$last_id = mysqli_insert_id($conn);
		}
	}
	
	
	$part++;
	

}//End of while 


	//Update Last Message
			$sql = 
				"UPDATE Conversations
				SET last_message_id = $last_id
				WHERE first_user_id =$profile_id
				AND second_user_id = $recipient_id
				OR first_user_id = $recipient_id
				AND second_user_id = $profile_id";
		
		$result = mysqli_query($conn,$sql);

$sql = "SELECT messages FROM `messages` WHERE `message_id` = '$message_id' ORDER BY `Part`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	
	while($row = $result->fetch_assoc()) {
		
		echo $row["messages"];

    }
	
} 

?>