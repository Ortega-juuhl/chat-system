<?php
#kung fu panda er drit bra
session_start();
include 'db_connect.php';
$friend_request_user_id = $_SESSION['friend_request_user_id'];


if($conn->connect_error) {
    die("Connection failed; " . $conn->connect_error);
}
if(isset($_SESSION['friend_request_user_id'])) {
    $user_ID = $_SESSION['user_id'];


    $addFriend = "INSERT INTO FriendRequests (sender_id, receiver_id) VALUES ($user_ID, $friend_request_user_id)";

    if ($conn->query($addFriend) === TRUE) { 
        echo '<script>alert("Friend request sent successfully."); window.location.href = "index.php";</script>';
    } else {
        echo '<script>alert("Friend request failed."); window.location.href = "index.php";</script>';

    }
} else {
    echo '<script>alert("Failed to add user, please try again."); window.location.href = "index.php";</script>';
}

?>