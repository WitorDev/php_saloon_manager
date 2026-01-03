<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <section>
        <br>
        <br>

        <div style="display: flex; justify-content: space-between; ">
            <div>
                <h1>Register</h1>
                <a href="login.php">Register</a>
            </div>

            <img draggable="false" src="app_logo.png" width="100" alt="Saloon Logo">
        </div>
        <br>
        <br>

        <form action="register.php" method="post">
            <label for="username">Username:</label><br>
            <input type="text" name="username" required id="username" placeholder="username"><br><br>

            <label for="password">Password:</label><br>
            <input type="password" name="password" required id="password" placeholder="password"><br><br>

            <label for="password">Confirm password:</label><br>
            <input type="password" name="confirm_password" required id="confirm_password"
                placeholder="confirm password"><br><br>

            <input type="submit" value="Login" name="login">

            <?php
            include("./connection.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                if (!empty($_POST["username"] && !empty($_POST["password"] && !empty($_POST["confirm_password"])))) {

                    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
                    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
                    $confirm_password = filter_input(INPUT_POST, "confirm_password", FILTER_SANITIZE_SPECIAL_CHARS);

                    $stmt_select_username = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
                    mysqli_stmt_bind_param($stmt_select_username, "s", $username);
                    mysqli_stmt_execute($stmt_select_username);
                    $select_username_result = $stmt_select_username->get_result();
                    if ($select_username_result->num_rows > 0) {
                        echo "<p class='input-info'>Username already taken.</p>";
                    } else {
                        if ($password === $confirm_password) {
                            if (strlen($password) < 8 || strlen($password) > 255) {
                                echo "<p class='input-info'>Password has to be at least 8 characters long and go up to a maximum of 255 characters.</p>";
                            } else {

                                echo "<p class='input-info'>Created user successfully</p>";
                                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                                // create new user in database
                                $stmt_add_new_user = mysqli_prepare($conn, "INSERT INTO users (username, password)
                                                         VALUES (?, ?)");

                                mysqli_stmt_bind_param($stmt_add_new_user, "ss", $username, $hashed_password);
                                mysqli_stmt_execute($stmt_add_new_user);
                                header("Location: login.php");
                            }
                        } else {
                            echo "<p class='input-info'>Passwords are not the same.</p>";
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