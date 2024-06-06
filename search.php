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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Result</title>
    <link rel="stylesheet" href="search.css">

</head>
<body>
    <div class="search-result">
        <h2>Search result for <?php echo $search; ?>:</h2>
        <p>Username: <?php echo $search; ?></p>
        <p>Status: <?php echo $row['online_status']; ?></p>
        <form action="add_friend.php" method="post">
            <input type="hidden" name="searchUserID" value="<?php echo $searchUserID; ?>">
            <button type="submit">Add</button>
        </form>
    </div>
</body>
</html>
<?php
        } else {
            echo '<script>alert("You can\'t send a friend request to yourself."); window.location.href = "index.php";</script>';
        }
    } else {
        echo "No user found with username '$search'.";
    }
}
?>
