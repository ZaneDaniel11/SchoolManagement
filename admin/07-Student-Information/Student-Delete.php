<?php
include('../Public/Connection.php');

if (isset($_GET['student_id'])) {
    $studentID = $_GET['student_id'];

    try {
        // Use prepared statement to avoid SQL injection
        $deleteQuery = "DELETE FROM students WHERE StudentID = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bindParam(1, $studentID, PDO::PARAM_INT);
        $stmt->execute();

        // Check if any rows were affected
        if ($stmt->rowCount() > 0) {
            // Redirect to the page where you list students
            header('Location: Student-Index.php');
            exit();
        } else {
            echo "No record found with the specified ID.";
        }
    } catch (PDOException $e) {
        echo "Error deleting record: " . $e->getMessage();
    }
} else {
    echo "Invalid student ID.";
}
?>
