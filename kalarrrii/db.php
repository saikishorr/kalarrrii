<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kalarrrii";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'] ?? '';
    $problem = $_POST['problem'];
    $bookingDate = $_POST['bookingDate'];
    $bookingTime = $_POST['bookingTime'];

    $stmt = $conn->prepare("INSERT INTO appointments (username, phone, email, address, problem, booking_date, booking_time) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sssssss", $name, $phone, $email, $address, $problem, $bookingDate, $bookingTime);
        if ($stmt->execute()) {
            // Get the last inserted ID
            $appointment_id = $conn->insert_id;

            // Redirect to success page with ID and Name
            header("Location: success.php?id=$appointment_id&name=" . urlencode($name));
            exit;
        } else {
            echo "Error executing query: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

$conn->close();
?>
