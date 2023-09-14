<?php
include('../Public/Connection2.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $subjectName = $_POST['teacher_name'];
    $courseId = $_POST['department_id'];

    try {
        // Insert subject details into the subjects table
        $insertQuery = "INSERT INTO teachers (TeacherName, DepartmentID) VALUES (?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("si", $subjectName, $courseId);
        $stmt->execute();
        $stmt->close();

        // Redirect to a success page or display a success message
        header("Location: Teacher-Index.php");
        exit();
    } catch (Exception $e) {
        // Handle any errors during the insert process
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect if the form is not submitted via POST
    header("Location: index.php");
    exit();
}

// Close the MySQLi connection
mysqli_close($conn);
?>
