<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Appointment</title>
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
    <script>
        function confirmCompletion() {
            return confirm('Are you sure you want to mark this appointment as completed?');
        }
    </script>
</head>
<body>
    <div class="container text-center">
    <?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'kalarrri');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Display confirmation prompt using JavaScript
    echo "<script>
        if (confirm('Are you sure you want to mark this appointment as completed?')) {
            ";
            
            // Update appointment status in the database
            $sql = "UPDATE bookings SET status='completed' WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $id);
            if ($stmt->execute()) {
                echo "alert('Appointment ID $id has been marked as completed.');
                    document.write('<div class=\"container mt-4\"><h3>Appointment ID " . htmlspecialchars($id) . " has been marked as completed.</h3>');
                    document.write('<a href=\"view.php\" class=\"btn btn-primary mt-3\">Go Back</a></div>');
                ";
            } else {
                echo "alert('Error updating record: " . $conn->error . "');
                window.location.href = 'view.php';";
            }

    echo "}
    else {
        window.location.href = 'view.php';
    }
    </script>";
}

$conn->close();
?>

    </div>
</body>
</html>
