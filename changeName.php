<?php
session_start();

include 'db_connect.php';

$user_id = $_SESSION['user_id'];


if (isset($_SESSION['user_id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_name = mysqli_real_escape_string($conn, $_POST['new_name']);

        $update_query = "UPDATE users SET name = '$new_name' WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $update_query);

        if ($result) {
            echo "Name updated successfully.";
        } else {
            echo "Error updating Name: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid request method.";
    }
} else {
    echo "User not logged in.";
}
?>
