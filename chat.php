<?php 
session_start();
include 'db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or display an error message
    header("Location: login.html");
    exit;
}

// Retrieve friend ID and name from POST data and set them into session variables
if (isset($_POST['friendId']) && isset($_POST['friendName'])) {
    $_SESSION['friendId'] = $_POST['friendId'];
    $_SESSION['friendName'] = $_POST['friendName'];
}

// Get user ID and friend ID from session
$user_id = $_SESSION['user_id'];
$friendId = $_SESSION['friendId'];
$friendName = $_SESSION['friendName'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="chat.css">
    <script src="https://kit.fontawesome.com/9e81387435.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="chat-messages" id="chat-messages">
    <!-- Messages will be loaded here dynamically -->
</div>
<div class="chat-container">
    <form id="send-message-form" action="send_chat.php" method="post" class="send-message-form">
        <input type="hidden" name="friend_id" value="<?php echo $friendId; ?>">
        <input type="text" name="message" placeholder="Type your message" class="message-input">
        <input type="submit" value="Send" class="send-button">
    </form>
    <a href="index.php" class="back-btn"><i class="fas fa-arrow-left back-icon"></i>Back</a>
</div>

<script>
function fetchMessages() {
    $.ajax({
    url: 'fetch_messages.php', // URL to send the AJAX request to
    method: 'GET', // HTTP method to use for the request (GET)
    success: function(data) { // Function to run if the request is successful
        var messages = JSON.parse(data); // Parse the JSON response from the server
        var chatMessages = $('#chat-messages'); // Get the element with ID 'chat-messages'
        chatMessages.empty(); // Clear any existing messages in the chat container

        if (messages.length > 0) { // Check if there are any messages
            messages.forEach(function(message) { // Loop through each message
                // Create a div for the message with a class based on who sent it (me or friend)
                var messageDiv = '<div class="chat-message ' + 
                    (message.sender_id == <?php echo $user_id; ?> ? 'me' : 'friend') + '">';
                // Add the message content to the div
                messageDiv += '<div>' + 
                    (message.sender_id == <?php echo $user_id; ?> ? 'Me' : '<?php echo $friendName; ?>') + 
                    ': ' + message.content + ' (' + message.timestamp + ')</div>';
                messageDiv += '</div>';
                
                // If the message was sent by the logged-in user, add a delete button
                if (message.sender_id == <?php echo $user_id; ?>) {
                    messageDiv += '<form action="delete_message.php" method="post" class="delete-message-form">';
                    messageDiv += '<input type="hidden" name="message_id" value="' + message.message_id + '">';
                    messageDiv += '<button type="submit" class="delete-button">Delete</button>';
                    messageDiv += '</form>';
                }
                // Append the message div to the chat container
                chatMessages.append(messageDiv);
            });
        } else {
            // If no messages are found, display a placeholder message
            chatMessages.append('<div class="no-messages">No messages have been sent yet.</div>');
        }
    }
});
}

setInterval(fetchMessages, 1000);
fetchMessages();
</script>
</body>
</html>
