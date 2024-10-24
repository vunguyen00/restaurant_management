<?php
session_start();
include 'config/config.php';

// Import PhpSpreadsheet classes
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch total revenue
$sql = "SELECT SUM(total_price) AS total_revenue FROM orders";
$result = $mysqli->query($sql);
$totalRevenue = 0;
if ($result) {
    $row = $result->fetch_assoc();
    $totalRevenue = $row['total_revenue'];
}

// Fetch dish statistics (total quantity sold and total revenue for each dish)
$sql = "SELECT oi.dish_name, SUM(oi.quantity) AS total_quantity, SUM(oi.price * oi.quantity) AS total_revenue
        FROM order_items oi
        GROUP BY oi.dish_name";
$result = $mysqli->query($sql);

$dishStats = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $dishStats[] = $row;
    }
}

// Handle Excel export
if (isset($_POST['export_excel'])) {
    require 'vendor/autoload.php'; // Include PHPExcel or PhpSpreadsheet autoloader

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add header for total revenue
    $sheet->setCellValue('A1', 'Total Revenue');
    $sheet->setCellValue('B1', '$' . number_format($totalRevenue, 2));

    // Add headers for dish statistics
    $sheet->setCellValue('A3', 'Dish Name');
    $sheet->setCellValue('B3', 'Total Quantity Sold');
    $sheet->setCellValue('C3', 'Total Revenue');

    // Add dish data
    $rowNum = 4;
    foreach ($dishStats as $dish) {
        $sheet->setCellValue('A' . $rowNum, $dish['dish_name']);
        $sheet->setCellValue('B' . $rowNum, $dish['total_quantity']);
        $sheet->setCellValue('C' . $rowNum, '$' . number_format($dish['total_revenue'], 2));
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
    <link rel="stylesheet" href="admin.css">
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

        <div class="statistics-section">
            <h2>Revenue & Dish Statistics</h2>

            <!-- Total Revenue -->
            <p><strong>Total Revenue: </strong>$<?php echo number_format($totalRevenue, 2); ?></p>

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
                            <td>$<?php echo number_format($dish['total_revenue'], 2); ?></td>
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
