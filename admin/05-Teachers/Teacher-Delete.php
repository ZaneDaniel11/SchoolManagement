<?php

include('../Public/Connection.php');

if (isset($_GET['subject_id'])) {
    $id = $_GET['subject_id'];

    try {
        // Use prepared statement to avoid SQL injection
        $sql = "DELETE FROM teachers WHERE TeacherID = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Check if any rows were affected
        if ($stmt->rowCount() > 0) {
            header('Location: Teacher-index.php');
            exit();
        } else {
            echo "No record found with the specified ID.";
        }
    } catch (PDOException $e) {
        echo "Error deleting record: " . $e->getMessage();
    }
}

?>
