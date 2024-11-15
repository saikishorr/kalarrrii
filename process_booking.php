<?php
$host = 'localhost';
$db = 'kalarrri';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $bookingDate = $_POST['bookingDate'];
    $bookingTime = $_POST['bookingTime'];

    // Insert into database
    $stmt = $pdo->prepare("INSERT INTO bookings (username, phone, email, address, booking_date, booking_time) VALUES (?, ?, ?, ?, ?, ?)");
    try {
        $stmt->execute([$username, $phone, $email, $address, $bookingDate, $bookingTime]);
        echo 'Booking successful!';
    } catch (\PDOException $e) {
        if ($e->getCode() === '23000') { // Unique constraint violation
            echo 'Selected slot is already booked. Please choose another time.';
        } else {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
