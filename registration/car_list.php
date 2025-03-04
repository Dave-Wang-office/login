<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_name'])) {
    echo "<script>alert('Please Login First!'); window.location.href='login.php';</script>";
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Welcome to Car Rental System</h1>
<nav>
    <a href="car_list.php">View Cars</a> |
    <a href="bookings.php">My Bookings</a> |
    <a href="logout.php">Logout</a>
</nav>
<div>
    <h2>Available Cars</h2>
    <?php
    $sql = "SELECT * FROM cars";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>
                    <img src='images/{$row['image']}' alt='{$row['car_name']}' width='200'>
                    <p>Brand: {$row['car_brand']}</p>
                    <p>Model: {$row['car_model']}</p>
                    <p>Type: {$row['car_type']}</p>
                    <p>Color: {$row['color']}</p>
                    <p>Price: {$row['price']} per day</p>
                    <a href='rent_car.php?id={$row['id']}'>Rent Now</a>
                  </div><hr>";
        }
    } else {
        echo "No Cars Available";
    }
    ?>
</div>

<!-- Rent Car Page -->
<?php
if (isset($_GET['id'])) {
    $car_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $rent_sql = "INSERT INTO bookings (user_id, car_id, rent_date) VALUES ('$user_id', '$car_id', NOW())";
    if ($conn->query($rent_sql) === TRUE) {
        echo "<script>alert('Car Rented Successfully!'); window.location.href='bookings.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!-- Bookings Page -->
<div>
    <h2>My Bookings</h2>
    <?php
    $user_id = $_SESSION['user_id'];
    $booking_sql = "SELECT cars.car_name, cars.car_model, cars.car_brand, bookings.rent_date FROM bookings JOIN cars ON bookings.car_id = cars.id WHERE bookings.user_id='$user_id'";
    $booking_result = $conn->query($booking_sql);
    if ($booking_result->num_rows > 0) {
        while ($row = $booking_result->fetch_assoc()) {
            echo "<p>Brand: {$row['car_brand']} - Model: {$row['car_model']} - Rented on: {$row['rent_date']}</p>";
        }
    } else {
        echo "No Bookings Found";
    }
    ?>
</div>
</body>
</html>