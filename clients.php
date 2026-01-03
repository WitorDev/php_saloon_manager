<?php
session_start();
if (empty($_SESSION["username"])) {
    header("Location: login.php");
}

require("./connection.php");

$stmt = mysqli_prepare($conn, "SELECT c.id, c.name, c.email, c.phone
FROM clients c
JOIN users u ON u.id = c.user_id
WHERE u.id = ?;
");
mysqli_stmt_bind_param($stmt, "i", $_SESSION["user_id"]);
mysqli_stmt_execute($stmt);
$result = $stmt->get_result();

$clients = [];

while ($row = mysqli_fetch_assoc($result)) {
    $clients[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients</title>
</head>

<body>
    <?php
    include("./header.html");
    ?>

    <section>
        <h1>Clients:</h1>
        <a href="new_client.php">Add client</a>
        <br>
        <br>

        </h3>
        <?php
        if (!empty($clients)) {
            foreach ($clients as $client) {
                $id = $client["id"];
                $name = $client["name"];
                $email = $client["email"];
                $phone = $client["phone"];
                echo
                    <<<HTML
            <div class="contact">
                <h2>$name</h2>
                <a href="mailto:$email">$email</a>
                <a href="https://wa.me/$phone" target="_blank">$phone</a><br><br>
                <a href="delete_client.php?id=$id"
                onclick="return confirm('Are you sure?')">
                    <button>Delete</button>
                </a>
            </div>
        HTML;
            }
        } else {
            echo "<br><br><p>No clients yet!</p>";
        }
        ?>
    </section>



</body>

</html>