<?php
	session_start();
	$profile_id = $_SESSION['id'];
	header('Content-Type: application/javascript');
	$recipient_id = filter_input(INPUT_GET, id, FILTER_VALIDATE_INT);
?>
// Function to send message.
function messageSend(){
	var message =  $('#messageInput').val()
	var recipient_id = <?= $recipient_id; ?>
	
	if(message){
		$.post("messagePoster.php",
		{
			message:message,
			recipient_id:recipient_id
		},
		function(data){
		});
	}
	$('#messageInput').val('')	
}
// Function to load messages.
function messageLoad(){
	var countId = document.getElementById('count')

		var count =  $('#count').val()
	
		var recipient_id = <?= $recipient_id; ?>

		$.post("messageLoader.php",
		{
			count:count,
			recipient_id:recipient_id
		}, 
		function(data){
			var result = JSON.parse(data);
			
			if(data !== false){
				document.getElementById('messages').innerHTML = result.html;
				
	
				
				if(count && (result.profile_id != <?= $profile_id; ?>)){
					document.getElementById('sound').play();
				}
				
			}
		});
		
		
setTimeout("messageLoad()",1000);	
}
// Function to see if message has been seen
function messageSeen(){
	var recipient_id = <?= $recipient_id; ?>;
	$.post("messageSeen.php",
		{
			recipient_id:recipient_id
		},
		function(data){
		});
}
// Run these on start up
$(document).ready( function(){
	// Run functions
	messageLoad();
	messageSeen();
	
	
	// On scroll up load more message.
	$('#messages').scroll(function() {
		var recipient_id = <?= $recipient_id; ?>;
		var scrollHeight = $('#messages').scrollTop();
		$('#height').html(scrollHeight);
		var page = $('#page').html();
		var count =  $('#count').val();
		var innerHeight = parseInt($('#innerHeight').html());
		
		
		if(scrollHeight == 0){
			page++;
			$('#page').html(page);
			
			
			$.post("messageLoaderExtra.php",
			{
				count:count,
				recipient_id:recipient_id,
				page:page
			},
			function(data){
				var result = JSON.parse(data);
				$('#messages').html(result.html);
				
				var newInnerHeight = parseInt($('.innerMessages').height());
				$('#messages').scrollTop(newInnerHeight - innerHeight)
			});
			
		}else if (scrollHeight > 5){
			$('#innerHeight').html($('.innerMessages').height())
		}
		
	});
	
	
	// Send message on clicking send
	$('#messageButton').click( function(){
		messageSend();
	});
	
	// Send messages on pressing Enter. If box is checked.
	$("#messageInput").keyup(function(event){
		if(document.getElementById("enterSubmit").checked){
			if(event.keyCode == 13){
				if(!event.shiftKey){
					messageSend();
				}
			}
		}
	});
	$( "#messageInput" ).on('input',function() {
		if( $('#messageInput').val() ){
			var typing = true
		}else{
			var typing = false
		}
		var recipient_id = <?php echo $recipient_id; ?>
	
		$.post("messageTyping.php",
			{
				typing:typing,
				recipient_id:recipient_id
			},
		function(data){
		});
	});
	

}); // End of $(document).ready( ....
