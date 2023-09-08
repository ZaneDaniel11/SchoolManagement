<?php
include('../Public/Connection.php');

if (isset($_GET['subject_id'])) {
    $id = $_GET['subject_id'];

    try {
        // Prepare and execute the DELETE statement
        $delete_query = "DELETE FROM subjects WHERE SubjectID = :id";
        $stmt = $conn->prepare($delete_query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Check if the deletion was successful
        if ($stmt->rowCount() > 0) {
            // Successful deletion
            header('Location: Subject-index.php');
            exit();
        } else {
            // No rows affected, subject not found
            header("Location: Subject-index.php?error=Subject not found");
            exit();
        }
    } catch (PDOException $e) {
        // Error in deletion
        header("Location: Subject-index.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    // 'subject_id' parameter is not set
    header("Location: Subject-index.php?error=Invalid request");
    exit();
}
?>
