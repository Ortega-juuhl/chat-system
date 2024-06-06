<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="container">
        <?php
        session_start();
        include 'db_connect.php';

        $user_ID = $_SESSION['user_id'];

        $is_admin_query = "SELECT is_admin FROM Users WHERE user_id = $user_ID";
        $result = mysqli_query($conn, $is_admin_query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $is_admin_value = $row['is_admin'];

            if ($is_admin_value === '1') {
                echo "<h1>Admin Panel</h1>";

                $select_all_users = "SELECT * FROM Users";
                $user_result = mysqli_query($conn, $select_all_users);

                if (mysqli_num_rows($user_result) > 0) {
                    echo "<h3>All Users:</h3>";
                    while ($user_row = mysqli_fetch_assoc($user_result)) {
                        echo "<div class='user'>";
                        echo "<span class='username'>Username: " . $user_row['username'] . "</span>";
                        echo "<form action='delete_user.php' method='post'>";
                        echo "<input type='hidden' name='delete_user_id' value='" . $user_row['user_id'] . "'>";
                        echo "<button type='submit' class='delete-button'>Delete <i class='fas fa-trash-alt'></i> </button>";
                        echo "</form>";

                        echo "<form action='delete_user.php' method='post'>";
                        echo "<input type='hidden' name='delete_user_id' value='" . $user_row['user_id'] . "'>";
                        echo "<button type='submit' class='delete-button'>Make Admin <i class='fas fa-trash-alt'></i> </button>";
                        echo "</form>";

                        echo "</div>";
                    }
                } else {
                    echo "No users found.";
                }
            }
        } else {
            echo "You are not an admin";
        }
        ?>
        <div class="home-button-container">
            <a href="index.php" class="home-button">Home</a>
        </div>
    </div>
</body>
</html>
