<?php
include("config/config.php"); // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user_id and new role from POST data
    $user_id = intval($_POST['user_id']);
    $new_role = intval($_POST['role']);

    // Check if the user_id and role are valid
    if ($user_id > 0 && ($new_role === 0 || $new_role === 1)) {
        // Update the role in the database
        $stmt = $mysqli->prepare("UPDATE user SET role = ? WHERE user_id = ?");
        $stmt->bind_param("ii", $new_role, $user_id);

        if ($stmt->execute()) {
            echo "Role updated successfully.";
        } else {
            echo "Error updating role: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Invalid input.";
    }
} else {
    echo "Invalid request method.";
}

// Redirect back to admins page after the update
header("Location: admins.php");
exit();
?>