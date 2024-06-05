<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if 'friendId' is set in the $_POST array
    if(isset($_POST['friendId'])) {
        $friend_id = $_POST['friendId'];
        $user_ID = $_SESSION['user_id'];

        // Remove the extra WHERE clause in the DELETE statement
        $remove_friend = "DELETE FROM friends WHERE 
                          (user_id = $user_ID AND friend_id = $friend_id) 
                          OR 
                          (user_id = $friend_id AND friend_id = $user_ID)";

        // Execute the query
        $result = mysqli_query($conn, $remove_friend);

        // Check if the query was successful
        if($result){
            echo '<script>alert("Removed friend."); window.location.href = "index.php";</script>';
        } else {
            echo '<script>alert("Failed to remove friend."); window.location.href = "index.php";</script>';
        }
    } else {
        echo "Friend ID not provided.";
    }
}
?>
