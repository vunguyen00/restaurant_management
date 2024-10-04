
<?php 
include("config/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="books.css">
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

        <div class="bookings-section">
            <h2>Bookings</h2>
            <table>
                <thead>
                    <tr>
                        <th>name</th>
                        <th>email</th>
                        <th>date_booking</th>
                        <th>num_people</th>
                        <th>special_request</th>
                        <th>created_at</th>
                        <th>status</th>
                        <th>change status</th>
                        <th>delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>zzzzzzzzz</td>
                        <td>moha123@gmail.com</td>
                        <td>04/12/2023 3:13 PM</td>
                        <td>3</td>
                        <td>Energetically actualize B2B web-readiness after</td>
                        <td>2023-04-09 15:13:17</td>
                        <td>Confirmed</td>
                        <td><button class="status-btn">status</button></td>
                        <td><button class="delete-btn">delete</button></td>
                    </tr>
                    <tr>
                        <td>Mohamed Hassan</td>
                        <td>moha123@gmail.com</td>
                        <td>04/11/2023 3:15 PM</td>
                        <td>2</td>
                        <td>Rapidiously expedite team driven potentialities</td>
                        <td>2023-04-09 15:16:01</td>
                        <td>Done</td>
                        <td><button class="status-btn">status</button></td>
                        <td><button class="delete-btn">delete</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
