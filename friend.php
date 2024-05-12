<?php 
session_start();
include 'db_connect.php';

$user_ID = $_SESSION['user_id'];

$selectNamesQuery = "SELECT Users.user_id AS sender_id, Users.name, FriendRequests.request_id 
                     FROM Users 
                     INNER JOIN FriendRequests ON Users.user_id = FriendRequests.sender_id 
                     WHERE FriendRequests.status = 'pending' AND Users.user_id != $user_ID";

$result = $conn->query($selectNamesQuery);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sender_id = $row['sender_id'];
        $request_id = $row['request_id'];
        $name = $row['name'];
        
        echo $name;
        echo "<form action='accept_friend.php' method='post'>";
        echo "<input type='hidden' name='sender_id' value='$sender_id'>";
        echo "<input type='hidden' name='request_id' value='$request_id'>";
        echo "<button type='submit'>Accept</button>";
        echo "</form>";
        
        echo "<form action='reject_friend.php' method='post'>";
        echo "<input type='hidden' name='sender_id' value='$sender_id'>";
        echo "<input type='hidden' name='request_id' value='$request_id'>";
        echo "<button type='submit'>Reject</button>";
        echo "</form>";
    }
} else {
    echo "You don't have any pending friend requests.";
}
?>
