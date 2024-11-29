<?php

$conn = new mysqli("localhost", "root", "", "quizcraft");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>