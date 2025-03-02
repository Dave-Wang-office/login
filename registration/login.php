<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_name'] = $user['first_name'];
            echo "<script>alert('Login Successful'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Invalid Password'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('Email Not Found'); window.location.href='login.html';</script>";
    }
}
?>
