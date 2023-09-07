<?php
    
include('../Public/Connection2.php');

// Check if 'delete_id' parameter is set
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    // Delete department from the database
    $delete_query = "DELETE FROM departments WHERE DepartmentID = $id";
    $result = mysqli_query($conn, $delete_query);

    if ($result) {
        // Successful deletion
        header("Location: 01-Department-index.php?success=Department deleted successfully");
        exit();
    } else {
        // Error in deletion
        $error = mysqli_error($conn);
        header("Location: 01-Department-index.php?error=$error");
        exit();
    }
} else {
    // 'delete_id' parameter is not set
    header("Location: 01-Department-index.php?error=Invalid request");
    exit();
}

?>