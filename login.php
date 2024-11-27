<?php
session_start();
require_once 'config.php';
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
} else {
    echo "Connected successfully to the database.";
}
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    if (empty($_POST['email_or_phone'])) {
        $errors['email_or_phone'] = 'Email or phone number is required';
    } elseif (!filter_var($_POST['email_or_phone'], FILTER_VALIDATE_EMAIL) && !preg_match('/^\d{10}$/', $_POST['email_or_phone'])) {
        $errors['email_or_phone'] = 'Enter a valid email or 10-digit phone number';
    }

    if (empty($_POST['password'])) {
        $errors['password'] = 'Password is required';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: login.php');
        exit();
    }

    try {
        // Database connection
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email OR phone = :phone");
        $stmt->execute([
            ':email' => $_POST['email_or_phone'],
            ':phone' => $_POST['email_or_phone']
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $errors['login'] = 'User not found';
            $_SESSION['errors'] = $errors;
            header('Location: login.php');
            exit();
        }

        // Verify password
        if (!password_verify($_POST['password'], $user['password'])) {
            $errors['login'] = 'Incorrect password';
            $_SESSION['errors'] = $errors;
            header('Location: login.php');
            exit();
        }

        // Create session
        $session_id = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', strtotime('+60 minutes'));

        $stmt = $pdo->prepare("INSERT INTO sessions (id, user_id, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$session_id, $user['id'], $expires_at]);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['session_id'] = $session_id;
        $_SESSION['expires_at'] = $expires_at;

        header('Location: dashboard.php');
        exit();
    } catch (PDOException $e) {
        $errors['database'] = "Database error: " . $e->getMessage();
        $_SESSION['errors'] = $errors;
        header('Location: login.php');
        exit();
    }
}

// Retrieve session errors (if any)
if (!empty($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}

// $_SESSION['user_id'] = $user['id'];
// $_SESSION['session_id'] = $session_id;
// $_SESSION['expires_at'] = $expires_at;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="login.php" method="post">
        <label for="email_or_phone">Email or Phone:</label>
        <input type="text" id="email_or_phone" name="email_or_phone" value="<?php echo htmlspecialchars($_POST['email_or_phone'] ?? ''); ?>" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</body>
</html>
