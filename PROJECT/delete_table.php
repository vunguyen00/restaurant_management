<?php 
include("config/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table_id = $mysqli->real_escape_string($_POST['id']);
    
    $query = "DELETE FROM restaurant_table WHERE table_id='$table_id'";
    if ($mysqli->query($query)) {
        echo "Table deleted successfully!";
    } else {
        echo "Error: " . $mysqli->error;
    }
}
?>
