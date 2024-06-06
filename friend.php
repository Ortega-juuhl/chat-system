<?php 
session_start();
include 'db_connect.php';

$user_ID = $_SESSION['user_id'];

$selectNamesQuery = "SELECT Users.user_id AS sender_id, Users.name, FriendRequests.request_id 
                     FROM Users 
                     INNER JOIN FriendRequests ON Users.user_id = FriendRequests.sender_id 
                     WHERE FriendRequests.status = 'pending' AND Users.user_id != $user_ID";

$result = $conn->query($selectNamesQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friend Requests</title>
    <link rel="stylesheet" href="friend.css">
</head>
<body>
    <div class="friend-requests-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sender_id = $row['sender_id'];
                $request_id = $row['request_id'];
                $name = $row['name'];

                echo '<div class="friend-request">';
                echo "<p class='friend-name'>$name</p>";
                echo "<form action='accept_friend.php' method='post' class='friend-action-form'>";
                echo "<input type='hidden' name='sender_id' value='$sender_id'>";
                echo "<input type='hidden' name='request_id' value='$request_id'>";
                echo "<button type='submit' class='btn accept-btn'>Accept</button>";
                echo "</form>";

                echo "<form action='reject_friend.php' method='post' class='friend-action-form'>";
                echo "<input type='hidden' name='sender_id' value='$sender_id'>";
                echo "<input type='hidden' name='request_id' value='$request_id'>";
                echo "<button type='submit' class='btn reject-btn'>Reject</button>";
                echo "</form>";
                echo '</div>';
            }
        } else {
            echo "<p class='no-requests'>You don't have any pending friend requests.</p>";
        }
        ?>
        <a href="index.php" class="home-button">Home</a>
    </div>
</body>
</html>
