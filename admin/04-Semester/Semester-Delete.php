<?php
include('../Public/Connection.php');

if (isset($_GET['delete_id'])) {
    try {
        $delete_id = $_GET['delete_id'];

        // Prepare and execute the delete query
        $delete_query = "DELETE FROM Semesters WHERE SemesterID = :delete_id";
        $delete_stmt = $conn->prepare($delete_query);
        $delete_stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
        $delete_stmt->execute();

        // Check if the deletion was successful
        if ($delete_stmt->rowCount() > 0) {
            // Redirect to the semester index page or any other desired page after successful deletion
            header('Location: Semester-Index.php');
            exit();
        } else {
            echo "No records deleted.";
        }
    } catch (PDOException $e) {
        // Handle errors
        echo "Error: " . $e->getMessage();
    }
}

// Close the PDO connection
$conn = null;
?>
