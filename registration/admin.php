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

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_sql = "DELETE FROM users WHERE id=$id";
    $conn->query($delete_sql);
    echo "<script>alert('User Deleted Successfully!'); window.location.href='admin.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Admin Panel</h1>
<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Registration Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT id, first_name, last_name, email, phone, created_at FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['created_at'] . "</td>";
                echo "<td>
                        <a href='admin.php?delete=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a> |
                        <a href='edit_user.php?id=" . $row['id'] . "'>Edit</a>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No Users Found</td></tr>";
        }
        ?>
    </tbody>
</table>
<a href="logout.php">Logout</a>
</body>
</html>
