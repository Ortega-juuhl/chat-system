<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #36393f;
            color: #ffffff;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #2f3136;
            padding: 20px;
            border-radius: 10px;
        }

        h1 {
            color: #7289da;
            text-align: center;
        }

        h3 {
            color: #7289da;
            margin-top: 20px;
        }

        .user {
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 5px;
            background-color: #40444b;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .username {
            color: #ffffff;
            margin-right: 10px;
        }

        .delete-button {
            background-color: #ff4040;
            color: #ffffff;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .delete-button:hover {
            background-color: #ff0000;
        }

        .delete-button i {
            margin-right: 5px;
        }

        .home-button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .home-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #7289da;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .home-button:hover {
            background-color: #677bc4;
        }

        .home-button i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
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
                echo "<h1>Admin Panel</h1>";

                $select_all_users = "SELECT * FROM USERS";
                $user_result = mysqli_query($conn, $select_all_users);

                if (mysqli_num_rows($user_result) > 0) {
                    echo "<h3>All Users:</h3>";
                    while ($user_row = mysqli_fetch_assoc($user_result)) {
                        echo "<div class='user'>";
                        echo "<span class='username'>Username: " . $user_row['username'] . "</span>";
                        echo "<form action='ban.php' method='post'>";
                        echo "<input type='hidden' name='user_ban_id' value='" . $user_row['user_id'] . "'>";
                        echo "<button type='submit' class='delete-button'>Delete <i class='fas fa-trash-alt'></i> </button>";
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
