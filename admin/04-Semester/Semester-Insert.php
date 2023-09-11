<?php
include('../Public/Connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Retrieve form data
        $subjectName = $_POST['subject_name'];
        $year = $_POST['year'];
        $courseId = $_POST['course_id'];

        // Prepare and execute the SQL statement for inserting into the semesters table
        $insertQuery = "INSERT INTO semesters (SemesterName, YearLevel, SubjectID) VALUES (:subjectName, :year, :courseId)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bindParam(':subjectName', $subjectName, PDO::PARAM_STR);
        $insertStmt->bindParam(':year', $year, PDO::PARAM_INT);
        $insertStmt->bindParam(':courseId', $courseId, PDO::PARAM_INT);
        $insertStmt->execute();

        // Redirect to the success page
        header('Location: Semester-Index.php');
        exit();
    } catch (PDOException $e) {
        // Handle errors
        $error = $e->getMessage();
        header("Location: Semester-Index.php?error=$error");
        exit();
    }
}
?>
