<?php 
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table_id = $mysqli->real_escape_string($_POST['table_id']);
    $table_number = $mysqli->real_escape_string($_POST['table_number']);
    
    $query = "UPDATE restaurant_table SET table_number='$table_number' WHERE table_id='$table_id'";
    if ($mysqli->query($query)) {
        echo "Table updated successfully!";
    } else {
        echo "Error: " . $mysqli->error;
    }
}
?>
