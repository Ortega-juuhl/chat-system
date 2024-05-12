<?php
session_start();

include 'db_connect.php';

if(isset($_session['userID'])) {
    $userID = $_session = ['userID'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = mysqli_real_escape_string($conn, $_POST['new_name']);

    $update_query = "UPDATE users SET username = '$new_name' WHERE userID = '$userID'";
    $result = mysqli_query($conn, $update_query);

    if ($result) {
        echo "Name updated successfully.";
    }
    else {
        echo "Error updating email: " . mysqli_error($conn);
    }
    } else {
        echo "Invalid request method.";

    }
} else {
    echo "User not logged in.";

}
?>
