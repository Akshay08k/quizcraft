<?php
$conn = new mysqli("localhost", "root", "", "quizcraft");

$error = "";  // To store error messages
$success = "";  // To store success message

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token is valid and not expired
    $stmt = $conn->prepare("SELECT id FROM users WHERE pass_reset_token = ? AND reset_expires > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST['password'])) {
                $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET password = ?, pass_reset_token = NULL, reset_expires = NULL WHERE pass_reset_token = ?");
                $stmt->bind_param("ss", $newPassword, $token);
                $stmt->execute();

                $success = "Password has been reset. You can now log in.";
            } else {
                $error = "Password cannot be empty.";
            }
        }
    } else {
        $error = "Invalid or expired token.";
    }
} else {
    $error = "No token provided.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>QuizCraft | Reset Password</title>
    <link rel="shortcut icon" href="logo.jpeg" type="image/x-icon" />
    <style>
        body {
            background-image: url(https://img.freepik.com/premium-vector/different-football-silhouettes-seamless-pattern-vector-background_153454-5070.jpg);
        }
    </style>

    <link rel="stylesheet" href="output.css">
</head>

<body class="bg-gray-900 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-gray-800 shadow-md rounded-lg p-8">
        <h2 class="text-2xl font-semibold text-center text-white mb-6 flex flex-col items-center">
            <img src="logo.jpeg" alt="QuizCraft Logo" class="mb-4 w-16 h-16 rounded-full" />
            <span class="text-3xl font-bold text-yellow-500">Reset Password</span>
        </h2>

        <!-- Display Error Message -->
        <?php if (!empty($error)): ?>
            <div class="mb-4 p-4 bg-red-600 text-white text-center rounded-lg">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="mb-4 p-4 bg-green-600 text-white text-center rounded-lg">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <form action="reset_password.php?token=<?php echo htmlspecialchars($token); ?>" method="POST">
            <div class="mb-6">
                <label for="password" class="block text-gray-300 font-medium mb-2">New Password</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter new password" required />
            </div>

            <button type="submit"
                class="w-full bg-yellow-700 text-white py-2 rounded-lg hover:bg-yellow-800 transition duration-200">
                Reset Password
            </button>
        </form>
    </div>
</body>

</html>