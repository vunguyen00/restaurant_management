<?php
include("config/config.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Get user role if available
if (isset($_SESSION['user_name'])) {
    $userName = $_SESSION['user_name'];
    $userRoleQuery = "SELECT role FROM user WHERE user_name = '$userName'";
    $roleResult = $mysqli->query($userRoleQuery);
    $userRole = $roleResult->fetch_assoc()['role'];
} else {
    $userName = "USER"; 
}

// Set default timeframe (e.g., month)
$timeframe = isset($_POST['timeframe']) ? $_POST['timeframe'] : 'month';

// Query to get revenue data based on the selected timeframe
if ($timeframe === 'day') {
    $sql = "SELECT DATE(order_date) AS date, SUM(total_price) AS revenue 
            FROM orders 
            GROUP BY DATE(order_date)";
} elseif ($timeframe === 'month') {
    $sql = "SELECT DATE_FORMAT(order_date, '%Y-%m') AS date, SUM(total_price) AS revenue 
            FROM orders 
            GROUP BY DATE_FORMAT(order_date, '%Y-%m')";
} else { // year
    $sql = "SELECT DATE_FORMAT(order_date, '%Y') AS date, SUM(total_price) AS revenue 
            FROM orders 
            GROUP BY DATE_FORMAT(order_date, '%Y')";
}

$result = $mysqli->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Revenue Statistics</title>
    <link rel="stylesheet" href="statistical.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <a href="#" class="user-btn"><?php echo htmlspecialchars($userName); ?></a>
                <div class="dropdown-content">
                    <a href="logout.php">Log Out</a>
                </div>
            </div>
        </div>

        <div class="content">
            <h2>Revenue Statistics</h2>
            <form method="POST" action="">
                <label for="timeframe">View by:</label>
                <select name="timeframe" id="timeframe" onchange="this.form.submit()">
                    <option value="day" <?php if ($timeframe === 'day') echo 'selected'; ?>>Day</option>
                    <option value="month" <?php if ($timeframe === 'month') echo 'selected'; ?>>Month</option>
                    <option value="year" <?php if ($timeframe === 'year') echo 'selected'; ?>>Year</option>
                </select>
            </form>

            <h3 style="color: #ff9900;">Revenue Bar Chart</h3>
            <canvas id="revenueBarChart" width="400" height="200"></canvas>

            <!-- Line Chart Heading and Canvas -->
            <h3 style="color: #ff9900;">Revenue Line Chart</h3>
            <canvas id="revenueLineChart" width="400" height="200"></canvas>

            <!-- Pie Chart Heading and Canvas with Smaller Size -->
            <h3 style="color: #ff9900;">Revenue Distribution Pie Chart</h3>
            <canvas id="revenuePieChart" width="300" height="200" style="max-width: 500px; max-height: 250px;"></canvas>
        </div>
    </div>

    <script>
        // Extract data for charts
        const data = <?php echo json_encode($data); ?>;
        const labels = data.map(item => item.date);
        const revenues = data.map(item => item.revenue);

        // Bar Chart
        const ctxBar = document.getElementById('revenueBarChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue (VNĐ)',
                    data: revenues,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: '<?php echo ucfirst($timeframe); ?>'
                        },
                        ticks: {
                            callback: function(value, index, values) {
                                const date = labels[index];
                                return '<?php echo $timeframe === 'day' ? "Ngày" : ($timeframe === "month" ? "Tháng" : "Năm"); ?> ' + date;
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Revenue (VNĐ)'
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString() + ' VNĐ';
                            }
                        }
                    }
                }
            }
        });

        // Line Chart
        const ctxLine = document.getElementById('revenueLineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue (VNĐ)',
                    data: revenues,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    fill: true,
                    borderWidth: 2,
                    pointRadius: 3
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: '<?php echo ucfirst($timeframe); ?>'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Revenue (VNĐ)'
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString() + ' VNĐ';
                            }
                        }
                    }
                }
            }
        });

        // Pie Chart
        const ctxPie = document.getElementById('revenuePieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue (VNĐ)',
                    data: revenues,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'right'
                    }
                }
            }
        });

    </script>
</body>
</html>
