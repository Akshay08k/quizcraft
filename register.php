<?php
session_start();
include 'db.php';

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  if ($password !== $confirm_password) {
    $error_message = "Passwords do not match!";
  } else {
    $check_email_sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_email_sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $error_message = "An account with this email already exists!";
    } else {
      $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
      if ($stmt) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
          $success_message = "Registration successful! You can now log in.";
        } else {
          $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
      } else {
        $error_message = "Error preparing statement: " . $conn->error;
      }
    }
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>QuizCraft | Register</title>
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
      <span class="text-3xl font-bold text-yellow-500">QuizCraft Register</span>
    </h2>

    <?php if (!empty($success_message)): ?>
      <div class="bg-green-500 text-white p-2 mb-4 rounded">
        <?php echo $success_message; ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($error_message)): ?>
      <div class="bg-red-500 text-white p-2 mb-4 rounded">
        <?php echo $error_message; ?>
      </div>
    <?php endif; ?>

    <form action="register.php" method="POST">
      <div class="mb-4">
        <label for="username" class="block text-gray-300 font-medium mb-2">Username</label>
        <input type="text" id="username" name="name"
          class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Enter your username" required />
      </div>

      <div class="mb-4">
        <label for="email" class="block text-gray-300 font-medium mb-2">Email</label>
        <input type="email" id="email" name="email"
          class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Enter your email" required />
      </div>

      <div class="mb-4">
        <label for="password" class="block text-gray-300 font-medium mb-2">Password</label>
        <input type="password" id="password" name="password"
          class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Enter your password" required />
      </div>

      <div class="mb-6">
        <label for="confirm_password" class="block text-gray-300 font-medium mb-2">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password"
          class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Confirm your password" required />
      </div>

      <button type="submit"
        class="w-full bg-yellow-700 text-white py-2 rounded-lg hover:bg-yellow-800 transition duration-200">
        Register
      </button>
    </form>

    <div class="mt-6 text-center">
      <p class="text-gray-400">
        Already have an account?
        <a href="index.php" class="text-blue-400 hover:underline">Login</a>
      </p>
    </div>
  </div>
</body>

</html>