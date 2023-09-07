<?php
include('../Public/Connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $subjectName = $_POST['subject_name'];
    $courseId = $_POST['course_id'];

    try {
        // Create a PDO connection
        $connPDO = new PDO("mysql:host=localhost;dbname=school_db", 'root', '');
        $connPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert subject details into the subjects table using prepared statement
        $insertQuery = "INSERT INTO subjects (SubjectName, CourseID) VALUES (:subjectName, :courseId)";
        $stmt = $connPDO->prepare($insertQuery);
        $stmt->bindParam(':subjectName', $subjectName);
        $stmt->bindParam(':courseId', $courseId);
        $stmt->execute();

        // Redirect to a success page or display a success message
        header("Location: Subject-index.php");
        exit();
    } catch (PDOException $e) {
        // Handle any errors during the insert process
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect if the form is not submitted via POST
    header("Location: index.php");
    exit();
}
?>
