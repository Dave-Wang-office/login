<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $termsAccepted = isset($_POST['terms_accepted']) ? 1 : 0;

    // Hash Password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, password, terms_accepted) 
                            VALUES (?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssi", $firstName, $lastName, $email, $phone, $hashedPassword, $termsAccepted);

    if ($stmt->execute()) {
        echo "<script>alert('User registered successfully!'); window.location.href='register.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
