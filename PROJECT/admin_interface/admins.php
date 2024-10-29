<?php 
include("config/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admins.css">
</head>
<body>
    <div class="sidebar">
        <h2>LOGO</h2>
        <ul>
            <li><a href="admin.php">Home</a></li>
            <li><a href="admins.php">Admins</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="foods.php">Foods</a></li>
            <li><a href="books.php">Bookings</a></li>
            <li><a href="statistics.php" class="button">Revenue & Dish Statistics</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="navbar">
            <a href="#">Home</a>
            <span>admin</span>
        </div>

        <div class="container">
            <h3>Admins</h3>
            <a href="#" class="btn">Create Admins</a>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>adminname</th>
                        <th>email</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>admin.first@gmail.com</td>
                        <td>admin.first@gmail.com</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>admin.second@gmail.com</td>
                        <td>admin.second@gmail.com</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
