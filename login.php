<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result = $conn->query($sql)) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_id = $row['user_id'];
            $_SESSION["user_id"] = $user_id;
    
            $hashed_password = $row['password'];
            $verify_password = password_verify($password, $hashed_password);
            if ($verify_password) {
                echo '<script>alert("Login successful."); window.location.href = "index.php";</script>';
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo '<script>alert("Incorrect password.");</script>';
        }
    } else {
        echo '<script>alert("Username not found.");</script>';
    }
    $stmt->close();
    $conn->close();
}
?>