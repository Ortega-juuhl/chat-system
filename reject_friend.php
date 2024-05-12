<?php
include 'db_connect.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_ID = $_SESSION['user_id'];
    $request_id = $_POST['request_id'];
    $change_status = "UPDATE friendrequests SET status = 'rejected' WHERE request_id = $request_id";

    if ($conn->query($change_status) === TRUE) {
        echo '<script>alert("Successful rejected friend request."); window.location.href = "friend.php";</script>';
    } else {
        echo '<script>alert("An error occurred while trying to reject friend request, please try again."); window.location.href = "friend.php";</script>';
    }
} else {
    echo "Error accepting friend request: Invalid request method.";
}
?>

