<?php
include('../Public/Connection.php');

if (isset($_POST['submit'])) {
    $teacherID = $_POST['teacher_id'];
    $subjectID = $_POST['subject_id'];

    try {
        // Use prepared statement to avoid SQL injection
        $insertQuery = "INSERT INTO FacultySubjects (TeacherID, SubjectID) VALUES (?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bindParam(1, $teacherID, PDO::PARAM_INT);
        $stmt->bindParam(2, $subjectID, PDO::PARAM_INT);
        $stmt->execute();

        header('location:Faculty-Index.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
