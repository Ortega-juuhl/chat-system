<?php
include 'db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $_POST["search"];
    $getUserInfo = "SELECT * FROM Users WHERE username = '$search'";
    
    $result = $conn->query($getUserInfo);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $searchUserID = $row['user_id'];
        $user_ID = $_SESSION['user_id'];

        if ($user_ID != $searchUserID) {
            $_SESSION['friend_request_user_id'] = $searchUserID;

            echo "Search result for " . $search. ":" . "<br>";
            echo "Username:" . $search . "<br>"; // Display the searched username
            echo "Status:" . $row['online_status'] . "<br>" . "<br>";

            echo "<form action='add_friend.php' method='post'>";
            echo "<input type='hidden' name='searchUserID' value='$searchUserID'>";
            echo "<button type='submit'>Add</button>";
            echo "</form>";
        } else {
            echo '<script>alert("You can\'t send a friend request to yourself."); window.location.href = "chat_system.php";</script>';
        }
    } else {
        echo "No user found with username '$search'.";
    }
}
?>
