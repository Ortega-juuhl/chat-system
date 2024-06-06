<?php 
session_start();
include 'db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or display an error message
    header("Location: login.php");
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

// Check if both friendId and friendName are set
if (isset($friendId) && isset($friendName)) {
    // Fetch messages from the database
    $get_chat = "
    SELECT * 
    FROM messages 
    WHERE (receiver_id = $friendId AND sender_id = $user_id) 
       OR (receiver_id = $user_id AND sender_id = $friendId) 
    ORDER BY timestamp";
    $result = mysqli_query($conn, $get_chat);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="chat.css">
    <script src="https://kit.fontawesome.com/9e81387435.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="chat-messages">
    <?php
    // Check if both friendId and friendName are set
    if (isset($friendId) && isset($friendName)) {
        // Fetch messages from the database
        $get_chat = "SELECT * FROM messages WHERE (receiver_id = $friendId AND sender_id = $user_id) OR (receiver_id = $user_id AND sender_id = $friendId) ORDER BY timestamp";
        $result = mysqli_query($conn, $get_chat);

        // Check if new messages are available
        $new_messages = false;
        while ($row = mysqli_fetch_assoc($result)) {
            $new_messages = true;
            // Display the message and delete button
            if ($row['sender_id'] == $user_id) {
                echo "<div class='chat-message me'><div>Me: " . $row['content'] . " (" . $row['timestamp'] . ")</div></div>";
                echo "<form action='delete_message.php' method='post' class='delete-message-form'>";
                echo "<input type='hidden' name='message_id' value='" . $row['message_id'] . "'>";
                echo "<button type='submit' class='delete-button'>Delete</button>";
                echo "</form>";
            } else {
                echo "<div class='chat-message friend'><div>" . $friendName . ": " . $row['content'] . " (" . $row['timestamp'] . ")</div></div>";
            }
        }
    }
    ?>
</div>
<div class="chat-container">
    <form id="send-message-form" action="send_chat.php" method="post" class="send-message-form">
        <input type="hidden" name="friend_id" value="<?php echo $friendId; ?>">
        <input type="text" name="message" placeholder="Type your message" class="message-input">
        <input type="submit" value="Send" class="send-button">
    </form>
    <a href="index.php" class="back-btn"><i class="fas fa-arrow-left back-icon"></i>Back</a>
</div>
</body>
</html>
