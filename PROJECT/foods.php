<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="foods.css">
</head>
<body>
    <div class="sidebar">
        <h2>LOGO</h2>
        <ul>
            <li><a href="admin.html">Home</a></li>
            <li><a href="admins.html">Admins</a></li>
            <li><a href="orders.html">Orders</a></li>
            <li><a href="foods.html">Foods</a></li>
            <li><a href="books.html">Bookings</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="navbar">
            <a href="#">Home</a>
            <span>admin</span>
        </div>

        <div class="foods-section">
            <h2>Foods</h2>
            <button class="create-btn">Create Foods</button>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>name</th>
                        <th>image</th>
                        <th>price</th>
                        <th>delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>chicken wings</td>
                        <td><img src="chicken-wings.jpg" alt="chicken wings"></td>
                        <td>$10</td>
                        <td><button class="delete-btn">delete</button></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>pizza</td>
                        <td><img src="pizza.jpg" alt="pizza"></td>
                        <td>$20</td>
                        <td><button class="delete-btn">delete</button></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>steak</td>
                        <td><img src="steak.jpg" alt="steak"></td>
                        <td>$30</td>
                        <td><button class="delete-btn">delete</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
