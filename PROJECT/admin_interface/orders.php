<?php 
include("config/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="orders.css">
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
        </ul>
    </div>

    <div class="main-content">
        <div class="navbar">
            <a href="#">Home</a>
            <span>admin</span>
        </div>

        <div class="orders-section">
                <h2>Orders</h2>
                <table>
                    <thead>
                        <tr>
                            <th>name</th>
                            <th>email</th>
                            <th>town</th>
                            <th>country</th>
                            <th>phone_number</th>
                            <th>address</th>
                            <th>total_price</th>
                            <th>status value</th>
                            <th>status</th>
                            <th>delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Mohamed Hassan</td>
                            <td>moha@gmail.com</td>
                            <td>town</td>
                            <td>country</td>
                            <td>123034333</td>
                            <td>Progressively communicate user friendly internal o</td>
                            <td>$10</td>
                            <td>Pending</td>
                            <td><button class="status-btn">status</button></td>
                            <td><button class="delete-btn">delete</button></td>
                        </tr>
                        <tr>
                            <td>Mohamed Hassan</td>
                            <td>moha@gmail.com</td>
                            <td>sample town</td>
                            <td>sample country</td>
                            <td>19232234</td>
                            <td>Efficiently exploit dynamic e-tailers...</td>
                            <td>$40</td>
                            <td>Pending</td>
                            <td><button class="status-btn">status</button></td>
                            <td><button class="delete-btn">delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </div>
</body>
</html>
