<?php
include 'config/config.php';
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

// Import PhpSpreadsheet classes
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Set default values
$totalRevenue = 0;
$dishStats = [];

// Check if filter is set and apply accordingly
if (isset($_POST['filter_submit'])) {
    $dateFilter = $_POST['date_filter'];
    $selectedDate = $_POST['selected_date'];
    
    if ($dateFilter == 'day') {
        $sql = "SELECT SUM(total_price) AS total_revenue FROM orders WHERE DATE(order_date) = '$selectedDate'";
    } elseif ($dateFilter == 'month') {
        $month = date('m', strtotime($selectedDate));
        $year = date('Y', strtotime($selectedDate));
        $sql = "SELECT SUM(total_price) AS total_revenue FROM orders WHERE MONTH(order_date) = '$month' AND YEAR(order_date) = '$year'";
    } elseif ($dateFilter == 'year') {
        $year = date('Y', strtotime($selectedDate));
        $sql = "SELECT SUM(total_price) AS total_revenue FROM orders WHERE YEAR(order_date) = '$year'";
    } else {
        $sql = "SELECT SUM(total_price) AS total_revenue FROM orders"; // No filter
    }
} else {
    $sql = "SELECT SUM(total_price) AS total_revenue FROM orders"; // Default without filter
}

// Execute SQL query for revenue
$result = $mysqli->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $totalRevenue = $row['total_revenue'];
}

// Fetch dish statistics (total quantity sold and total revenue for each dish)
$sql = "SELECT oi.dish_name, SUM(oi.quantity) AS total_quantity, SUM(oi.price * oi.quantity) AS total_revenue
        FROM order_items oi
        GROUP BY oi.dish_name";
$result = $mysqli->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $dishStats[] = $row;
    }
}

// Handle Excel export
if (isset($_POST['export_excel'])) {
    require '../vendor/autoload.php'; // Include PHPExcel or PhpSpreadsheet autoloader

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add header for total revenue
    $sheet->setCellValue('A1', 'Total Revenue');
    $sheet->setCellValue('B1', number_format($totalRevenue) . ' VNĐ');

    // Add headers for dish statistics
    $sheet->setCellValue('A3', 'Dish Name');
    $sheet->setCellValue('B3', 'Total Quantity Sold');
    $sheet->setCellValue('C3', 'Total Revenue');

    // Add dish data
    $rowNum = 4;
    foreach ($dishStats as $dish) {
        $sheet->setCellValue('A' . $rowNum, $dish['dish_name']);
        $sheet->setCellValue('B' . $rowNum, $dish['total_quantity']);
        $sheet->setCellValue('C' . $rowNum, number_format($dish['total_revenue']) . ' VNĐ');
        $rowNum++;
    }

    // Generate Excel file
    $writer = new Xlsx($spreadsheet);
    $fileName = 'Revenue_Dish_Statistics_' . date('Y-m-d') . '.xlsx';

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    $writer->save('php://output');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics</title>
    <link rel="stylesheet" href="statistics.css">
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

        <div class="statistics-section">
            <h2>Revenue & Dish Statistics</h2>

            <!-- Date Filter Form -->
            <form method="POST" action="">
                <label for="date-filter">Filter By:</label>
                <select name="date_filter" id="date-filter">
                    <option value="day">Day</option>
                    <option value="month">Month</option>
                    <option value="year">Year</option>
                </select>
                <input type="date" name="selected_date" required>
                <button type="submit" name="filter_submit">Filter</button>
            </form>

            <!-- Display Total Revenue -->
            <p><strong>Total Revenue (Filtered): </strong><?php echo number_format($totalRevenue); ?> VNĐ</p>

            <!-- Dish Statistics -->
            <h3>Dish Sales and Revenue</h3>
            <table>
                <thead>
                    <tr>
                        <th>Dish Name</th>
                        <th>Total Quantity Sold</th>
                        <th>Total Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dishStats as $dish): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($dish['dish_name']); ?></td>
                            <td><?php echo htmlspecialchars($dish['total_quantity']); ?></td>
                            <td><?php echo number_format($dish['total_revenue']); ?> VNĐ</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Export to Excel -->
            <form method="POST" action="">
                <button type="submit" name="export_excel">Export to Excel</button>
            </form>
        </div>
    </div>
</body>
</html>
