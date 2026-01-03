<?php
session_start();
if (empty($_SESSION["username"])) {
    header("Location: login.php");
}
require("./connection.php");

$name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
$phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS));
$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

// validate required fields
if (empty($name)) {
    echo "<p>Name field is required.</p>";
}

// SQL statement
$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO clients (user_id, name, phone, email) VALUES (?, ?, ?, ?)"
);

mysqli_stmt_bind_param($stmt, "isss", $_SESSION["user_id"], $name, $phone, $email);
mysqli_stmt_execute($stmt);

header("Location: clients.php")
    ?>