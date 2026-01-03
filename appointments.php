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
    <title>Appointments</title>
</head>

<body>
    <?php
    include("./header.html");
    ?>
    <section>
        <h1>Appointments:</h1>
        <a href="new_appointment.php">Add appointment</a><br><br>

        </h3>
        <?php
        include("./connection.php");
        // create new appointment
        
        // show all user's appointments
        $stmt_get_appointments = mysqli_prepare($conn, "SELECT * FROM appointments WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt_get_appointments, "s", $_SESSION["user_id"]);
        mysqli_stmt_execute($stmt_get_appointments);
        $stmt_get_appointments_result = $stmt_get_appointments->get_result();

        $appointments = [];

        while ($row = mysqli_fetch_assoc($stmt_get_appointments_result)) {
            $appointments[] = $row;

            $client_id = $row["client_id"];
            $get_client_name_result = mysqli_query($conn, "SELECT name FROM clients WHERE id = $client_id");
            $client_name = mysqli_fetch_assoc($get_client_name_result);

            echo <<<HTML
            <div class="appointment">
                <h2>{$client_name["name"]}</h2>
                <p><strong>Service:</strong> {$row["service"]}</p>
                <p><strong>Date:</strong> {$row["appointment_date"]}</p>
                <p><strong>Time:</strong> {$row["appointment_time"]}</p>
                <p><strong>Notes:</strong><br>{$row["notes"]}</p>
                <a href="delete_appointment.php?id={$row["id"]}"
                onclick="return confirm('Are you sure?')">
                    <button>Delete</button>
                </a>
            </div>
        HTML;

        }
        ?>

    </section>



</body>

</html>