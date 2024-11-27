<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .success-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .success-box {
            text-align: center;
            padding: 30px;
            border: 2px solid #198754;
            border-radius: 15px;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .success-box img {
            width: 150px;
            margin-bottom: 20px;
        }
        .success-id, .success-name {
            font-size: 1.2rem;
            margin: 10px 0;
        }
        .btn-home {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="success-container">
    <div class="success-box">
        <!-- <img src="https://i.gifer.com/7efs.gif" alt="Success GIF"> -->
        <img src="https://media.giphy.com/media/111ebonMs90YLu/giphy.gif" alt="Success GIF">
        <h2 class="text-success">Appointment Booked Successfully!</h2>
        <p class="success-id"><strong>Appointment ID:</strong> 
            <span id="appointmentId">
                <?php echo htmlspecialchars($_GET['id'] ?? 'N/A'); ?>
            </span>
        </p>
        <p class="success-name"><strong>Name:</strong> 
            <span id="username">
                <?php echo htmlspecialchars($_GET['name'] ?? 'N/A'); ?>
            </span>
        </p>
        <a href="index.php" class="btn btn-success btn-home">Go Back to Home</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
