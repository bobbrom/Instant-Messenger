<?php 
	session_start();
	$page = 'Messages';
	$title = 'Messages';
	
	$dbconnect = $_SERVER['DOCUMENT_ROOT'];
	$dbconnect .= '/dbconnect.php';
	require_once ($dbconnect);
	
	$Functions = $_SERVER['DOCUMENT_ROOT'];
	$Functions .= '/Functions.php';
	require_once ($Functions);

	$header = $_SERVER['DOCUMENT_ROOT'];
	$header .= '/header.php';
	require_once ($header);
	
	$recipient_id = filter_input(INPUT_GET, id, FILTER_VALIDATE_INT);
	
	$recipientProfile = new profileData;
	$recipientProfile->set_id($recipient_id);
	
?>
<html>
	<head>
		<link href='/CSS/style.css' rel='stylesheet'> 
		<link href='/CSS/messages.css' rel='stylesheet'> <!-- Main CSS file for this page -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/emojione/2.2.6/assets/css/emojione.min.css"/> <!-- Loads stylesheet for emoji -->
		<script src="https://cdn.jsdelivr.net/emojione/2.2.6/lib/js/emojione.min.js"></script>  <!-- Loads JavaScript for emoji -->
		<script src="/JS/messages_js.php?id=<?= $recipient_id; ?>"></script><!-- Main javascript file for this page -->
		<title id='title'>Messages <?= $TabTitle; ?></title>
	</head>
	<body>
		<main>
			<h1 id='page'>0</h1>	<!-- This is hidden -->
			<h1 id='innerHeight'>00</h1>	<!-- This is hidden -->
			<div class='back_messages'>
				<div id='messages' class='container'></div>	<!-- This is where the message are loaded -->
				<?= $recipientProfile->profilePictureBig('recipientProfilePicture'); ?> <!-- This loads profile picture -->
				<textarea name='message'  class='messageInput' id='messageInput' placeholder='Write a reply...' ></textarea><!-- Where message is written -->
				<button type='submit' id='messageButton' class='messageButton'>Reply</button>
				<!-- Checkbox for pressing enter to send -->
				<div class='enterDivSpacer'>
					<div class='enterDiv'>
						<label for='enterSubmit'>Press enter to submit:</label>
						<input id='enterSubmit' type='checkbox'>
					</div>
				</div>
			</div> <!-- End of back -->
		</main>
	</body>
</html>
