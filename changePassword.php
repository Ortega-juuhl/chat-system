<?php
session_start();

include 'db_connect.php';

if(isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $old_password = mysqli_real_escape_string($conn, $_POST['old_password']);

        $select_password = "SELECT password FROM users WHERE userID = '$userID'";
        $result_password = mysqli_query($conn, $select_password);

        if ($result_password) {
            $row_password = mysqli_fetch_assoc($result_password);

            if ($row_password && password_verify($old_password, $row_password['password'])) {
                $n_password = mysqli_real_escape_string($conn, $_POST['n_password']);
                $cn_password = mysqli_real_escape_string($conn, $_POST['cn_password']);

                if ($n_password == $cn_password) {
                    $hashed_password = password_hash($n_password, PASSWORD_DEFAULT);

                    $update_query = "UPDATE user SET password = '$hashed_password' WHERE userID = '$userID'";
                    $result_update = mysqli_query($conn, $update_query);

                    if($result_update) {
                        echo "Password updated successfully.";
                    } else {
                        echo "Error updating password: " . mysqli_error($conn);
                    }
                } else {
                    echo "Passwords don't match.";
                }
            } else {
                echo "Incorrect old password.";
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid request method.";
    }
} else {
    echo "User not logged in";
}
?>
