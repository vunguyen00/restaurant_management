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

    // Begin transaction
    $mysqli->begin_transaction();

    try {
        // Retrieve the selected dishes for the table
        $query = "SELECT dish_id, quantity FROM table_orders WHERE table_id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $table_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $dish_id = $row['dish_id'];
            $quantity = $row['quantity'];

            // Get the ingredients for each dish
            $ingredientQuery = "SELECT ingredient_id, quantity_required FROM dish_ingredients WHERE dish_id = ?";
            $ingredientStmt = $mysqli->prepare($ingredientQuery);
            $ingredientStmt->bind_param("i", $dish_id);
            $ingredientStmt->execute();
            $ingredientResult = $ingredientStmt->get_result();

            while ($ingredient = $ingredientResult->fetch_assoc()) {
                $ingredient_id = $ingredient['ingredient_id'];
                $quantity_required = $ingredient['quantity_required'] * $quantity; // Adjust based on ordered quantity

                // Log the required quantities
                error_log("Updating ingredient_id: $ingredient_id, reducing by: $quantity_required");

                // Check if quantity_required is not null
                if ($quantity_required !== null && $quantity_required > 0) {
                    // Reduce the quantity of each ingredient in the database
                    $updateQuery = "UPDATE ingredients SET quantity = quantity - ? WHERE ingredient_id = ? AND quantity >= ?";
                    $updateStmt = $mysqli->prepare($updateQuery);
                    $updateStmt->bind_param("iii", $quantity_required, $ingredient_id, $quantity_required);
                    
                    if (!$updateStmt->execute()) {
                        throw new Exception("Error executing update statement: " . $updateStmt->error);
                    }

                    // Check if the update was successful
                    if ($updateStmt->affected_rows === 0) {
                        // If not enough stock, throw an exception to roll back the transaction
                        throw new Exception("Not enough stock for ingredient ID: $ingredient_id");
                    }
                } else {
                    error_log("Skipped updating ingredient_id: $ingredient_id because quantity_required is zero or negative");
                }
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
        echo json_encode(['success' => false, 'error' => 'Transaction failed']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request or missing table ID']);
}

// Close the connection
$mysqli->close();
?>
