<?php
session_start();
if (empty($_SESSION["username"])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>

    <?php
    include("./header.html");
    ?>
    <section>
        <div class="user-section">
            <div>
                <h1>
                    <?php echo $_SESSION["username"] ?>
                </h1>
                <p>User ID: <?php echo $_SESSION["user_id"] ?></p>
            </div>
            <br>
            <form action="logout.php" method="post">
                <input style="background: lightcoral;" class="logout-button" type="submit" value="Logout" name="logout">
            </form>
        </div>
    </section>
    <?php
    include("./footer.html");
    ?>
</body>

</html>