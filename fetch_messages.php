<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['friendId'])) {
    echo json_encode([]);
    exit;
}

$user_id = $_SESSION['user_id'];
$friendId = $_SESSION['friendId'];

// Fetch messages from the database
$get_chat = "
SELECT * 
FROM messages 
WHERE (receiver_id = $friendId AND sender_id = $user_id) 
   OR (receiver_id = $user_id AND sender_id = $friendId) 
ORDER BY timestamp";
$result = mysqli_query($conn, $get_chat);

$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

echo json_encode($messages);
?>
