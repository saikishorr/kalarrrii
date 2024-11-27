<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kalarrrii";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    // Single delete
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM appointments WHERE id = $id");
} elseif (isset($_POST['ids'])) {
    // Multiple delete
    $ids = implode(',', array_map('intval', $_POST['ids']));
    $conn->query("DELETE FROM appointments WHERE id IN ($ids)");
}

header("Location: admin_dashboard.php");
exit;
?>
