<?php
// connect to db
$env = parse_ini_file(__DIR__ . "/.env");

$host = $env["DB_HOST"];
$databaseName = $env["DB_NAME"];
$user = $env["DB_USER"];
$password = $env["DB_PASSWORD"];

try {
    $conn = new mysqli($host, $user, $password, $databaseName);
} catch (Exception $error) {
    echo "<b><p style='width: 100%; background-color: red; color: white; padding: 0.4rem; margin: 0 auto;'>Connection to Database failed: " . $error->getMessage() . ".</p></b>";
}
?>