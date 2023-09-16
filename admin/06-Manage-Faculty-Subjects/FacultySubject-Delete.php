<?php
include('../Public/Connection.php');

if (isset($_GET['faculty_subject_id'])) {
    $facultySubjectID = $_GET['faculty_subject_id'];

    try {
        // Use prepared statement to avoid SQL injection
        $deleteQuery = "DELETE FROM FacultySubjects WHERE FacultySubjectID = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bindParam(1, $facultySubjectID, PDO::PARAM_INT);
        $stmt->execute();

        // Check if any rows were affected
        if ($stmt->rowCount() > 0) {
            // Redirect to the page where you list Faculty Subjects
            header('Location: Faculty-Index.php');
            exit();
        } else {
            echo "No record found with the specified ID.";
        }
    } catch (PDOException $e) {
        echo "Error deleting record: " . $e->getMessage();
    }
} else {
    echo "Invalid faculty subject ID.";
}
?>
