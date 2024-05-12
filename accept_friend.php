<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("You need to login before you can use the chat system."); window.location.href = "login.html";</script>';
    exit; // Stop further execution if user is not logged in
}

$user_id = $_SESSION['user_id'];

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request_id'])) {
    $request_id = $_POST['request_id'];

    // Update FriendRequests status to 'accepted'
    $updateRequestQuery = "UPDATE FriendRequests SET status = 'accepted' WHERE request_id = $request_id";
    $conn->query($updateRequestQuery);

    // Get the sender_id of the friend request
    $getSenderQuery = "SELECT sender_id FROM FriendRequests WHERE request_id = $request_id";
    $resultSender = $conn->query($getSenderQuery);
    if ($resultSender->num_rows > 0) {
        $row = $resultSender->fetch_assoc();
        $sender_id = $row['sender_id'];

        // Insert a row into the Friends table for the user who accepted the request
        $insertFriendQuery1 = "INSERT INTO Friends (user_id, friend_id) VALUES ($user_id, $sender_id)";
        $conn->query($insertFriendQuery1);

        // Insert another row into the Friends table for the user who sent the request
        $insertFriendQuery2 = "INSERT INTO Friends (user_id, friend_id) VALUES ($sender_id, $user_id)";
        $conn->query($insertFriendQuery2);

        echo '<script>alert("Friend request accepted successfully."); window.location.href = "friend.php";</script>';
    } else {
        echo '<script>alert("Error accepting friend request. Please try again."); window.location.href = "friend.php";</script>';
    }
} else {
    echo "Error accepting friend request: Invalid request method or request ID.";
}
?>
