<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <section>
        <br>
        <br>

        <div style="display: flex; justify-content: space-between; ">
            <div>
                <h1>Login</h1>
                <a href="register.php">Register</a>
            </div>

            <img draggable="false" src="app_logo.png" width="100" alt="Saloon Logo">
        </div>
        <br>
        <br>

        <form action="login.php" method="post">
            <label for="username">Username:</label><br>
            <input type="text" name="username" id="username" placeholder="username"><br><br>

            <label for="password">Password:</label><br>
            <input type="password" name="password" id="password" placeholder="password"><br><br>

            <input type="submit" value="Login" name="login">

            <?php

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                if (!empty($_POST["username"] && !empty($_POST["password"]))) {
                    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
                    $user_password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

                    include("./connection.php");
                    $stmt_select_username = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
                    mysqli_stmt_bind_param($stmt_select_username, "s", $username);
                    mysqli_execute($stmt_select_username);
                    $stmt_select_username_result = $stmt_select_username->get_result();
                    // check if user exists
                    if ($stmt_select_username_result->num_rows < 1) {
                        echo "<p class='input-info'>User not found.</p>";
                    } else { // if exists
                        // compare passwords
                        if ($row = mysqli_fetch_assoc($stmt_select_username_result)) {
                            $db_hashed_password = $row["password"];
                            if (password_verify($user_password, $db_hashed_password)) {
                                $_SESSION["user_id"] = $db_user_id = $row["id"];
                                $_SESSION["username"] = $username;

                                echo "<p class='input-info'>Correct password.</p>";
                                header("Location: index.php");
                            } else {
                                echo "<p class='input-info'>Incorrect password.</p>";
                            }
                        }

                    }

                } else {
                    echo "<p class='input-info'>Missing username or password.</p>";
                }
            }

            ?>
        </form>
    </section>
</body>


</html>