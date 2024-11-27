<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Appointment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 500px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        .btn-custom {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <?php
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'kalarrri');

        // Check connection
        if ($conn->connect_error) {
            die("<p class='text-danger'>Connection failed: " . $conn->connect_error . "</p>");
        }

        // Sanitize the input
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id > 0) {
            // Delete the appointment
            $sql = "DELETE FROM bookings WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                echo "<p class='text-success'>Appointment ID $id has been successfully deleted.</p>";
            } else {
                echo "<p class='text-danger'>Error deleting record: " . $conn->error . "</p>";
            }

            $stmt->close();
        } else {
            echo "<p class='text-danger'>Invalid appointment ID.</p>";
        }

        $conn->close();
        ?>

        <a href="view.php" class="btn btn-primary btn-custom">Go Back</a>
    </div>
</body>
</html>
