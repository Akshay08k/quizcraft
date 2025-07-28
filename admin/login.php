<?php
session_start();
require_once('../db.php'); // $conn is your PDO instance

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Prepare and execute safely
    $stmt = $conn->prepare('SELECT * FROM users WHERE email = :email AND is_admin = 1');
    $stmt->execute([':email' => $email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        header('Location: index.php');
        exit();
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>QuizCraft - Admin Login</title>
    <link rel="shortcut icon" href="../public/images/logo.jpeg" type="image/x-icon" />
    <link rel="stylesheet" href="../public/css/output.css">
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold mb-6 text-center">Admin Login</h2>
        <?php if ($error): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" class="w-full p-2 border rounded mb-4" required>
            <input type="password" name="password" placeholder="Password" class="w-full p-2 border rounded mb-4" required>
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
                Login
            </button>
        </form>
    </div>
</body>

</html>
