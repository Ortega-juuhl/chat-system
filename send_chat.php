<?php
session_start();
include 'db_connect.php';

// Retrieve user ID and friend's ID from session and POST data
$user_id = $_SESSION['user_id'];
$friendId = $_POST['friend_id'];

// Get the message content from the form submission
$messageContent = $_POST['message'];

// Insert the new message into the database
$insertMessageQuery = "INSERT INTO messages (sender_id, receiver_id, content) 
                       VALUES ($user_id, $friendId, '$messageContent')";
$result = mysqli_query($conn, $insertMessageQuery);

if ($result) {
    header("location:chat.php");
    
} else {
    echo "Error sending message: " . mysqli_error($conn);
}
?>
