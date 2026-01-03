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
        <?php
        if (isset($_SESSION["username"])) {
            echo "<h1>Welcome, {$_SESSION["username"]}, to the Saloon Manager system!</h1>";
        }
        ?>
        <p>Manage your clients here!</p>

    </section>

</body>

</html>