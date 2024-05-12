<?php
session_start();
include 'db_connect.php';

// Get user ID and friend ID
$user_id = $_SESSION['user_id'];
$friendId = $_POST['friendId'];
$friendName = $_POST['friendName'];

// Fetch messages from the database
$get_chat = "SELECT * FROM messages WHERE (receiver_id = $friendId AND sender_id = $user_id) OR (receiver_id = $user_id AND sender_id = $friendId) ORDER BY timestamp";
$result = mysqli_query($conn, $get_chat);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
</head>
<body>
<div class="chat-container">
    <!-- Display chat history -->
    <div class="chat-history">
        <?php
        // Loop through the messages and display them
        while ($row = mysqli_fetch_assoc($result)) {
            // Check if the message is from the user or the friend and display accordingly
            if ($row['sender_id'] == $user_id) {
                echo "<div>Me: " . $row['content'] . " (" . $row['timestamp'] . ")</div>";
            } else {
                echo "<div>" . $friendName . ": " . $row['content'] . " (" . $row['timestamp'] . ")</div>";
            }
        }
        ?>
    </div>

    <!-- Send message form -->
    <form action="send_chat.php" method="post">
        <input type="hidden" name="friend_id" value="<?php echo $friendId; ?>">
        <input type="text" name="message" placeholder="Type your message">
        <input type="submit" value="Send">
    </form>
</div>
</body>
</html>
