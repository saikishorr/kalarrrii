<?php
session_start();
require_once 'config.php';

// if ($connection->connect_error) {
//     die("Connection failed: " . $connection->connect_error);
// } else {
//     // echo "Connected successfully to the database.";
// }

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    if (empty($_POST['full_name'])) {
        $errors['full_name'] = 'Full name is required';
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $_POST['full_name'])) {
        $errors['full_name'] = 'Invalid full name';
    }

    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Valid email address is required';
    }

    if (empty($_POST['phone']) || !preg_match('/^\d{10}$/', $_POST['phone'])) {
        $errors['phone'] = 'Valid 10-digit phone number is required';
    }

    if (empty($_POST['password']) || strlen($_POST['password']) < 8) {
        $errors['password'] = 'Password must be at least 8 characters long';
    } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/', $_POST['password'])) {
        $errors['password'] = 'Password must contain letters, numbers, and symbols';
    }

    if ($_POST['password'] !== $_POST['confirm_password']) {
        $errors['confirm_password'] = 'Passwords do not match';
    }

    if (empty($errors)) {
        try {
            // Database connection
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Hash password
            $hashed_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            // Insert user into database
            $stmt = $pdo->prepare("INSERT INTO users (full_name, email, phone, password) VALUES (?, ?, ?, ?)");
            $stmt->execute([$_POST['full_name'], $_POST['email'], $_POST['phone'], $hashed_password]);

            // Create session
            $session_id = bin2hex(random_bytes(32));
            $expires_at = date('Y-m-d H:i:s', strtotime('+60 minutes'));
            
            $user_id = $pdo->lastInsertId();

            $stmt = $pdo->prepare("INSERT INTO sessions (id, user_id, expires_at) VALUES (?, ?, ?)");
            $stmt->execute([$session_id, $user_id, $expires_at]);
            
            $_SESSION['user_id'] = $user_id;
            $_SESSION['session_id'] = $session_id;
            $_SESSION['expires_at'] = $expires_at;

            // Redirect to index.php
            header('Location: index.php');
            exit();
        } catch (PDOException $e) {
            $errors['database'] = "Database error: " . $e->getMessage();
        }
    }

    $_SESSION['errors'] = $errors;
    header('Location: register.php');
    exit();
}
// Retrieve session errors (if any)
if (!empty($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="register.php" method="post">
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit">Register</button>
    </form>
</body>
</html>
