<?php
session_start();
include 'db_connect.php';

$user_ID = $_SESSION['user_id'];

$is_admin_query = "SELECT is_admin FROM USERS WHERE user_id = $user_ID";
$result = mysqli_query($conn, $is_admin_query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $is_admin_value = $row['is_admin'];
    
    if ($is_admin_value === '1') {
        echo "Hei, Admin!<br>";

        $select_all_users = "SELECT * FROM USERS";
        $user_result = mysqli_query($conn, $select_all_users);

        if (mysqli_num_rows($user_result) > 0) {
            echo "<h3>All Users:</h3>";
            while ($user_row = mysqli_fetch_assoc($user_result)) {
                echo "Username: " . $user_row['username'] . "<br>";
                echo "<form action='ban.php' method='post'>";
                echo "<input type='hidden' name='user_ban_id' value='" . $user_row['user_id'] . "'>";
                echo "<input type='submit' Value='DELETE USER'>";
                echo "</form>";
            }
        } else {
            echo "No users found.";
        }
    }
} else {
    echo "You are not an admin";
}
?>
