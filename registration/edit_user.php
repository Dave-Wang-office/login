<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_name'])) {
    echo "<script>alert('Please Login First!'); window.location.href='login.html';</script>";
    exit();
}

if ($_SESSION['user_name'] !== 'admin') {
    echo "<script>alert('Access Denied! Only Admins Can View This Page'); window.location.href='dashboard.php';</script>";
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('User Not Found'); window.location.href='admin.php';</script>";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $update_sql = "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email', phone='$phone' WHERE id=$id";
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('User Updated Successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Edit User</h1>
<form method="POST">
    <label>First Name:</label>
    <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" required><br>

    <label>Last Name:</label>
    <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" required><br>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo $row['email']; ?>" required><br>

    <label>Phone:</label>
    <input type="text" name="phone" value="<?php echo $row['phone']; ?>" required><br>

    <button type="submit">Update</button>
</form>
<a href="admin.php">Back to Admin Panel</a>
</body>
</html>
