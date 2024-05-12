<?php
session_start();

include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = '$username'";

    if ($result = $conn->query($sql)) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_id = $row['user_id'];
            $_SESSION["user_id"] = $user_id;
    
            $hashed_password = $row['password'];
            $verify_password = password_verify($password, $hashed_password);
            if ($verify_password) {
                echo '<script>alert("Login successful."); window.location.href = "chat_system.php";</script>';
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "Username not found.";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
