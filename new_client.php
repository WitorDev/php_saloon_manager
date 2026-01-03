<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add client</title>
</head>

<body>
    <?php
    include("./header.html");
    ?>


    <form action="add_client.php" method="post">
        <label for="name">Name (required):</label><br>
        <input type="text" name="name" id="name" required><br><br>

        <label for="email">Email (optional):</label><br>
        <input type="email" name="email" id="email"><br><br>

        <label for="phone">Phone (optional):</label><br>
        <input type="text" name="phone" id="phone"><br><br>

        <input type="submit" value="Add Client">
    </form>
</body>

</html>