<?php 
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table_number = $mysqli->real_escape_string($_POST['table_number']);
    
    $query = "INSERT INTO restaurant_table (table_number) VALUES ('$table_number')";
    if ($mysqli->query($query)) {
        echo "Table added successfully!";
    } else {
        echo "Error: " . $mysqli->error;
    }
}
?>
