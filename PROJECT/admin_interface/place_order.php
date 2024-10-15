<?php
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the dish ID from the POST request
    $dish_id = $_POST['dish_id'];
    $quantity_ordered = $_POST['quantity']; // Quantity of dish being ordered

    // Step 1: Get the ingredients required for the dish
    $query = "
        SELECT di.ingredient_id, i.quantity AS available_quantity, di.quantity_required
        FROM dish_ingredients di
        INNER JOIN ingredients i ON di.ingredient_id = i.ingredient_id
        WHERE di.dish_id = ?
    ";

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $dish_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $ingredients = [];
    while ($row = $result->fetch_assoc()) {
        $ingredients[] = $row;
    }
    $stmt->close();

    // Step 2: Update the ingredient quantities in the database
    $all_sufficient = true;
    $update_queries = [];
    foreach ($ingredients as $ingredient) {
        $required_quantity = $ingredient['quantity_required'] * $quantity_ordered;
        if ($ingredient['available_quantity'] < $required_quantity) {
            $all_sufficient = false;
            break;
        }
        // Update query to reduce the quantity of the ingredient
        $update_queries[] = [
            'ingredient_id' => $ingredient['ingredient_id'],
            'new_quantity' => $ingredient['available_quantity'] - $required_quantity
        ];
    }

    if ($all_sufficient) {
        // Proceed with updating ingredient quantities
        foreach ($update_queries as $update) {
            $update_query = "
                UPDATE ingredients
                SET quantity = ?
                WHERE ingredient_id = ?
            ";

            $stmt = $mysqli->prepare($update_query);
            $stmt->bind_param('ii', $update['new_quantity'], $update['ingredient_id']);
            $stmt->execute();
            $stmt->close();
        }

        echo "Order placed successfully and ingredients updated.";
    } else {
        echo "Not enough ingredients available to place the order.";
    }
}
?>
