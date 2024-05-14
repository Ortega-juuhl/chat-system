<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $message_id = $_POST['message_id'];

    // Corrected SQL query: remove the asterisk (*) after DELETE
    $delete_message = "DELETE FROM Messages WHERE message_id = $message_id";

    // Execute the query and check the result
    $result = mysqli_query($conn, $delete_message);
    if ($result) {
        echo '<script>alert("Message deleted."); window.location.href = "chat.php";</script>';
    } else {
        echo '<script>alert("Message failed to be deleted, please try again later."); window.location.href = "chat.php";</script>';
    }
} else {
    echo '<script>alert("Failed to get message_id, please try again later."); window.location.href = "chat.php";</script>';
}
?>
