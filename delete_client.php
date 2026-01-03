<?php
require("./connection.php");

if (!isset($_GET["id"])) {
    die("Client ID not provided");
}

$id = $_GET["id"];

$stmt = mysqli_prepare($conn, "DELETE FROM clients WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_execute($stmt);

mysqli_stmt_close($stmt);

header("Location: clients.php");
exit;
?>

!