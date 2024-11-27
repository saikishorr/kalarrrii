
<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - KALARRRII Appointments</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-5">Admin Panel - KALARRRII Appointments</h2>
        <a href="logout.php" class="btn btn-danger float-right">Logout</a>
        <h3 class="mt-4">Appointment Entries</h3>
        <table class="table table-bordered mt-3">
            <thead style="color: white; background-color:green;">
            <!-- <thead class="thead-light"> -->
                <tr>
                    <th>Sr. No.</th>
                    <th>Full Name</th>
                    <th>Email Address</th>
                    <th>Phone No</th>
                    <th>Address</th>
                    <th>Preferred Date</th>
                    <th>Preferred Time</th>
                    <th>status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection
                $conn = new mysqli('localhost', 'root', '', 'kalarrri');

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch appointments from the database
                $sql = "SELECT * FROM bookings";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . htmlspecialchars($row['id']) . "</td>
                            <td>" . htmlspecialchars($row['username']) . "</td>
                            <td>" . htmlspecialchars($row['email']) . "</td>
                            <td>" . htmlspecialchars($row['phone']) . "</td>
                            <td>" . htmlspecialchars($row['address'] ?? 'N/A') . "</td>
                            <td>" . htmlspecialchars($row['booking_date']) . "</td>
                            <td>" . htmlspecialchars($row['booking_time']) . "</td>
                            <td>" . htmlspecialchars($row['status']) . "</td>
                            <td>
                                <a href='completed_appointment.php?id=" . $row['id'] . "' class='btn btn-info btn-sm'>Completed</a>
                                <a href='delete_appointment.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this appointment?\")'>Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>No appointments found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
