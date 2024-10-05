<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'env.php';
require 'vendor/autoload.php';

$error = ""; // To store error messages
$success = ""; // To store success message

// Database connection
$conn = new mysqli("localhost", "root", "", "quizcraft");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId);
        $stmt->fetch();
        $token = bin2hex(random_bytes(50)); // Generate a random token
        $expires = date("Y-m-d H:i:s", strtotime("+10 minutes"));

        $stmt = $conn->prepare("UPDATE users SET pass_reset_token = ?, reset_expires = ? WHERE id = ?");
        $stmt->bind_param("ssi", $token, $expires, $userId);
        $stmt->execute();

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $smtp_mail;
            $mail->Password = $smtp_pass;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('akshaykomade012345@gmail.com', 'QuizCraft');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = "<p>Click <a href='http://localhost/taskmgm/reset_password.php?token=$token'>here</a> to reset your password.</p>";

            $mail->send();
            $success = "Reset link sent to your email.";
        } catch (Exception $e) {
            $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $error = "Email not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>QuizCraft | Forgot Password</title>
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
            <span class="text-3xl font-bold text-yellow-500">Forgot Password</span>
        </h2>

        <p class="text-gray-300 text-center mb-6">
            Enter your email and we’ll send you a link to reset your password.
        </p>

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

        <form action="forgot_password.php" method="POST">
            <div class="mb-6">
                <label for="email" class="block text-gray-300 font-medium mb-2">Email</label>
                <input type="email" id="email" name="email"
                    class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter your email" required />
            </div>

            <button type="submit"
                class="w-full bg-yellow-700 text-white py-2 rounded-lg hover:bg-yellow-800 transition duration-200">
                Reset Password
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="login.php" class="text-blue-400 hover:underline">Back to Login</a>
        </div>
    </div>
</body>

</html>