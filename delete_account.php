<?php
session_start();
include 'db_connect.php';

$user_id = $_SESSION['user_id'];

// Delete messages sent or received by the user
$delete_messages = "DELETE FROM Messages WHERE sender_id = $user_id OR receiver_id = $user_id";
$result_messages = mysqli_query($conn, $delete_messages);

// Delete friend requests sent or received by the user
$delete_friend_requests = "DELETE FROM FriendRequests WHERE sender_id = $user_id OR receiver_id = $user_id";
$result_friend_requests = mysqli_query($conn, $delete_friend_requests);

// Delete friendships where the user is involved
$delete_friendships = "DELETE FROM Friends WHERE user_id = $user_id OR friend_id = $user_id";
$result_friendships = mysqli_query($conn, $delete_friendships);

// Delete the user from the Users table
$delete_user = "DELETE FROM Users WHERE user_id = $user_id";
$result_user = mysqli_query($conn, $delete_user);

// Check if all queries executed successfully
if ($result_messages && $result_friend_requests && $result_friendships && $result_user) {
    echo '<script>alert("Deleted account."); window.location.href = "index.html";</script>';
} else {
    echo '<script>alert("Failed to delete account."); window.location.href = "usersettings.html";</script>';
}

// Redirect to a suitable page after deleting the account
exit;
?>
