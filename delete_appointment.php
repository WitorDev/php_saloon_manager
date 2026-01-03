<?php
require("./connection.php");

if (!isset($_GET["id"])) {
    die("Appointment ID not provided");
}

$id = $_GET["id"];

$stmt = mysqli_prepare($conn, "DELETE FROM appointments WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_execute($stmt);

mysqli_stmt_close($stmt);

header("Location: appointments.php");
exit;
?>

!