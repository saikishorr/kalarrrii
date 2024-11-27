<?php
session_start();
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: admin_login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kalarrrii";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM appointments");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Admin Dashboard</h2>

    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-primary" onclick="printTable()">Print Bookings</button>
        <button class="btn btn-success" onclick="exportSelectedToExcel()">Export Selected to Excel</button>    
    </div>

    <form method="POST" action="delete.php" onsubmit="return confirmBulkDelete();">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th><input type="checkbox" id="selectAll"></th>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Problem</th>
            <th>Booking Date</th>
            <th>Booking Time</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><input type="checkbox" name="ids[]" value="<?php echo $row['id']; ?>"></td>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['problem']; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td><?php echo $row['booking_time']; ?></td>
                <td>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" 
                       class="btn btn-danger btn-sm" 
                       onclick="return confirm('Are you sure you want to delete this booking?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <button type="submit" class="btn btn-danger mt-3">Delete Selected</button>
</form>


<script>
    // Select all checkboxes
    document.getElementById('selectAll').addEventListener('change', function () {
        document.querySelectorAll('input[name="ids[]"]').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Print the table
    function printTable() {
        const printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Print Bookings</title></head><body>');
        printWindow.document.write(document.querySelector('.table').outerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }

    // Export to Excel
    function exportToExcel() {
        const table = document.querySelector('.table').outerHTML;
        const data = new Blob([table], { type: 'application/vnd.ms-excel' });
        const url = URL.createObjectURL(data);
        const link = document.createElement('a');
        link.href = url;
        link.download = 'bookings.xls';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
// Export selected rows to Excel
    function exportSelectedToExcel() {
    const selectedCheckboxes = document.querySelectorAll('input[name="ids[]"]:checked');
    if (selectedCheckboxes.length === 0) {
        alert('Please select at least one item to export.');
        return;
    }

    // Create a table dynamically with selected rows
    const table = document.createElement('table');
    const header = document.querySelector('.table thead').cloneNode(true);
    const body = document.createElement('tbody');

    selectedCheckboxes.forEach(checkbox => {
        const row = checkbox.closest('tr').cloneNode(true);
        body.appendChild(row);
    });

    table.appendChild(header);
    table.appendChild(body);

    // Generate today's date for the file name
    const today = new Date();
    const formattedDate = today.toISOString().slice(0, 10); // Format: YYYY-MM-DD
    const fileName = `bookings_${formattedDate}.xls`;

    // Convert table to Excel-compatible format
    const data = new Blob([table.outerHTML], { type: 'application/vnd.ms-excel' });
    const url = URL.createObjectURL(data);

    // Create a download link and trigger it
    const link = document.createElement('a');
    link.href = url;
    link.download = fileName;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}



    // Bulk delete confirmation
    function confirmBulkDelete() {
        const selectedItems = document.querySelectorAll('input[name="ids[]"]:checked');
        if (selectedItems.length === 0) {
            alert('Please select at least one item to delete.');
            return false;
        }
        return confirm('Are you sure you want to delete the selected items?');
    }

    // Select all checkboxes
    document.getElementById('selectAll').addEventListener('change', function () {
        document.querySelectorAll('input[name="ids[]"]').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });


</script>
</body>
</html>
