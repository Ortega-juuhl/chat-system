<?php
session_start();
include 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['friendId'], $_POST['reportHeader'], $_POST['reportDescription'], $_POST['reportType'])) {
    // Retrieve form data
    $user_id = $_SESSION['user_id'];
    $friend_id = $_POST['friendId'];
    $reportHeader = $_POST['reportHeader'];
    $reportDescription = $_POST['reportDescription'];
    $reportType = $_POST['reportType'];

    // Insert report into database
    $insertReportQuery = "INSERT INTO Reports (user_id, friend_id, report_header, report_description, report_type) 
                          VALUES ($user_id, $friend_id, '$reportHeader', '$reportDescription', '$reportType')";
    $conn->query($insertReportQuery);

    // Redirect back to the page where the report was made
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
} else {
    // Handle invalid request
    echo "Invalid request";
}
?>
