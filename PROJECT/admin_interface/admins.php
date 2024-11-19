<?php 
include("config/config.php");
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_SESSION['user_name'])) {
    $userName = $_SESSION['user_name'];  // Get user name from session
    $userRoleQuery = "SELECT role FROM user WHERE user_name = '$userName'";
    $roleResult = $mysqli->query($userRoleQuery);
    $userRole = $roleResult->fetch_assoc()['role'];
} else {
    $userName = "USER"; 
}

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
            <li><a href="statistical.php">Revenue Statistics</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="navbar">
            <a href="#">Home</a>
            <div class="dropdown">
                <a href="#" class="user-btn" id="user-btn"><?php echo htmlspecialchars($userName); ?></a>
                <div class="dropdown-content">
                    <a href="logout.php">Log Out</a>
                    <a href="../information.php">Information</a>
                </div>
            </div>
        </div>

        <div class="container">
            <h3>Admins</h3>
            <form method="GET" action="admins.php" class="search-form">
                <input type="text" name="search_query" placeholder="Search by name or email" value="<?php echo isset($_GET['search_query']) ? $_GET['search_query'] : ''; ?>">
                <button type="submit" class="btn">Search</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Search functionality
                $search_query = isset($_GET['search_query']) ? mysqli_real_escape_string($mysqli, $_GET['search_query']) : '';

                // Fetch users with role information from the database, applying search if needed
                $sql = "SELECT user_id, user_name, email, role FROM user";
                if ($search_query) {
                    $sql .= " WHERE user_name LIKE '%$search_query%' OR email LIKE '%$search_query%'";
                }

                $result = mysqli_query($mysqli, $sql);

                if (!$result) {
                    die("Query failed: " . mysqli_error($mysqli));  // Check for query errors
                }

                // Display each user in the table
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['user_id']}</td>
                            <td>{$row['user_name']}</td>
                            <td>{$row['email']}</td>
                            <td>" . ($row['role'] == 1 ? "Admin" : "User") . "</td>
                            <td>
                                <form action='edit_role.php' method='POST' style='display:inline-block;'>
                                    <input type='hidden' name='user_id' value='{$row['user_id']}'>
                                    <input type='hidden' name='role' value='" . ($row['role'] == 1 ? "0" : "1") . "'>
                                    <button type='submit' class='btn'>" . ($row['role'] == 1 ? "Demote to User" : "Promote to Admin") . "</button>
                                </form>
                            </td>
                        </tr>";
                }
                ?>
                </tbody>
                <script>
                    // JavaScript for the dropdown
                    var userBtn = document.getElementById('user-btn');
                    var dropdownContent = document.querySelector('.dropdown-content');

                    userBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
                    });

                    window.addEventListener('click', function (e) {
                        if (!userBtn.contains(e.target) && !dropdownContent.contains(e.target)) {
                            dropdownContent.style.display = 'none';
                        }
                    });
                
                </script>
            </table>
        </div>
    </div>
</body>
</html>