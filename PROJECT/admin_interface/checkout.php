<?php
include 'config/config.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set the content type to JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table_id'])) {
    $table_id = $_POST['table_id'];
    $user_id = $_SESSION['user_id']; // Assuming user ID is stored in session
    $total_price = 0; // Initialize total price

    // Begin transaction
    $mysqli->begin_transaction();

    try {
        // Retrieve the selected dishes for the table
        $query = "SELECT dish_id, quantity FROM table_orders WHERE table_id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $table_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Create an array to hold order items
        $order_items = [];

        while ($row = $result->fetch_assoc()) {
            $dish_id = $row['dish_id'];
            $quantity = $row['quantity'];

            // Get the dish name from dishes
            $dishQuery = "SELECT dish_name FROM menu WHERE dish_id = ?";
            $dishStmt = $mysqli->prepare($dishQuery);
            $dishStmt->bind_param("i", $dish_id);
            $dishStmt->execute();
            $dishResult = $dishStmt->get_result();
            $dish = $dishResult->fetch_assoc();

            if (!$dish) {
                throw new Exception("Dish not found for dish ID: $dish_id");
            }

            // Get the price from menu
            $priceQuery = "SELECT price FROM menu WHERE dish_id = ?";
            $priceStmt = $mysqli->prepare($priceQuery);
            $priceStmt->bind_param("i", $dish_id);
            $priceStmt->execute();
            $priceResult = $priceStmt->get_result();
            $priceData = $priceResult->fetch_assoc();

            if (!$priceData) {
                throw new Exception("Price not found for dish ID: $dish_id");
            }
            $price = $priceData['price']; // Get price from menu

            // Calculate total price
            $total_price += $price * $quantity;

            // Add to order items array
            $order_items[] = [
                'dish_name' => $dish['dish_name'],
                'quantity' => $quantity,
                'price' => $price,
            ];

            // Get the ingredients for each dish
            $ingredientQuery = "SELECT ingredient_id FROM dish_ingredients WHERE dish_id = ?";
            $ingredientStmt = $mysqli->prepare($ingredientQuery);
            $ingredientStmt->bind_param("i", $dish_id);
            $ingredientStmt->execute();
            $ingredientResult = $ingredientStmt->get_result();

            while ($ingredient = $ingredientResult->fetch_assoc()) {
                $ingredient_id = $ingredient['ingredient_id'];

                // Log the required quantities
                error_log("Updating ingredient_id: $ingredient_id, reducing by: $quantity");

                // Reduce the quantity of each ingredient in the database
                $updateQuery = "UPDATE ingredients SET quantity = quantity - ? WHERE ingredient_id = ? AND quantity >= ?";
                $updateStmt = $mysqli->prepare($updateQuery);
                $updateStmt->bind_param("iii", $quantity, $ingredient_id, $quantity);
                
                if (!$updateStmt->execute()) {
                    throw new Exception("Error executing update statement: " . $updateStmt->error);
                }

                // Check if the update was successful
                if ($updateStmt->affected_rows === 0) {
                    // If not enough stock, throw an exception to roll back the transaction
                    throw new Exception("Not enough stock for ingredient ID: $ingredient_id");
                }
            }
        }

        // Create a new order in the orders table
        $insertOrderQuery = "INSERT INTO orders (user_id, total_price, order_date, table_id) VALUES (?, ?, NOW(), ?)";
        $insertOrderStmt = $mysqli->prepare($insertOrderQuery);
        $insertOrderStmt->bind_param("idi", $user_id, $total_price, $table_id);
        
        if (!$insertOrderStmt->execute()) {
            throw new Exception("Error creating order: " . $insertOrderStmt->error);
        }

        // Get the last inserted order ID
        $order_id = $insertOrderStmt->insert_id;

        // Insert each order item into order_items table
        foreach ($order_items as $item) {
            $insertItemQuery = "INSERT INTO order_items (order_id, dish_name, quantity, price) VALUES (?, ?, ?, ?)";
            $insertItemStmt = $mysqli->prepare($insertItemQuery);
            $insertItemStmt->bind_param("isid", $order_id, $item['dish_name'], $item['quantity'], $item['price']);
            
            if (!$insertItemStmt->execute()) {
                throw new Exception("Error inserting order item: " . $insertItemStmt->error);
            }
        }

        // Clear the table orders after checkout
        $clearTableQuery = "DELETE FROM table_orders WHERE table_id = ?";
        $clearStmt = $mysqli->prepare($clearTableQuery);
        $clearStmt->bind_param("i", $table_id);
        $clearStmt->execute();
        
        // Check if clear operation was successful
        if ($clearStmt->affected_rows === 0) {
            throw new Exception("Failed to clear table orders for table ID: $table_id");
        }

        // Update table status to empty
        $updateStatusQuery = "UPDATE restaurant_table SET status = 'empty' WHERE table_id = ?";
        $updateStatusStmt = $mysqli->prepare($updateStatusQuery);
        $updateStatusStmt->bind_param("i", $table_id);
        $updateStatusStmt->execute();

        // Commit transaction
        $mysqli->commit();

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $mysqli->rollback();
        error_log("Transaction failed: " . $e->getMessage());
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request or missing table ID']);
}

// Close the connection
$mysqli->close();
?>
