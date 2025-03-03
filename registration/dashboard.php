<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    echo "<script>alert('Please Login First!'); window.location.href='login.html';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Welcome, <?php echo $_SESSION['user_name']; ?>!</h1>
<button><a href="logout.php">Logout</a></button>
<button><a href="admin.php">Data</a></button>
<button><a href="edit_user.php">Edit_user</a></button>
</body>
</html>
