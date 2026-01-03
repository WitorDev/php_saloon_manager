<?php
include("./connection.php");
session_start();
// get clients
$stmt = mysqli_prepare(
    $conn,
    "SELECT id, name FROM clients WHERE user_id = ? ORDER BY name"
);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

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
    <title>Add appointment</title>
</head>

<body>
    <?php
    include("./header.html");
    ?>



    <form action="new_appointment.php" method="post">
        <label for="client">Client (required):</label><br>
        <select name="client" id="client">
            <?php
            foreach ($clients as $client) {
                $id = $client['id'];
                $name = htmlspecialchars($client['name']);
                echo "<option value=\"$id\">$name</option>";
            }
            ?>
        </select>
        <br>
        <br>

        <label for="service">Service (required):</label><br>
        <select name="service" id="service">
            <option value="HAIRCUT">Haircut</option>
            <option value="HAIRSTYLE">Hairstyle</option>
            <option value="MANICURE">Manicure</option>
            <option value="PEDICURE">Pedicure</option>
            <option value="EYEBROW">Eyebrow</option>
            <option value="MAKEUP">Makeup</option>
            <option value="HAIR_TREATMENT">Hair Treatment</option>
        </select>
        <br><br>

        <label for="date">Date (required):</label><br>
        <input type="date" name="date" id="date" required><br><br>

        <label for="time">Time (required):</label><br>
        <input type="time" name="time" id="time" required><br><br>

        <label for="notes">Notes: (Optional)</label><br>
        <textarea name="notes" id="notes" rows="10" cols="40"></textarea>
        <br>

        <input type="submit" value="Add Appointment"><br><br>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // filter through input values
        $client = filter_input(INPUT_POST, "client", filter: FILTER_SANITIZE_NUMBER_INT);
        $service = filter_input(INPUT_POST, "service", FILTER_SANITIZE_SPECIAL_CHARS);
        $date = filter_input(INPUT_POST, "date", FILTER_SANITIZE_SPECIAL_CHARS);
        $time = filter_input(INPUT_POST, "time", FILTER_SANITIZE_SPECIAL_CHARS);
        $notes = filter_input(INPUT_POST, "notes", FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($client) || empty($service) || empty($date) || empty($time)) {
            echo "Client, Service, Date and Time fields are required.<br>";
        } else {
            // create appointment
            $stmt_add_appointment = mysqli_prepare(
                $conn,
                "INSERT INTO appointments (user_id, client_id, service, appointment_date, appointment_time, notes) VALUES (?, ?, ?, ?, ?, ?)"
            );

            mysqli_stmt_bind_param($stmt_add_appointment, "iissss", $_SESSION["user_id"], $client, $service, $date, $time, $notes);

            if (mysqli_stmt_execute($stmt_add_appointment)) {
                echo "Appointment added successfuly.";
                header("Location: appointments.php");
            } else {
                echo "Error: " . mysqli_stmt_error($stmt_add_appointment);
            }
        }
    }

    ?>
</body>

</html>