<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school_db";

include('../Public/Connection.php');

if (isset($_GET['grade_id'])) {
    $facultySubjectID = $_GET['grade_id'];

    try {
        // Create a PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Delete the record from the FacultySubjects table
        $deleteQuery = "DELETE FROM grades WHERE GradeID = :facultySubjectID";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bindParam(':facultySubjectID', $facultySubjectID);
        $stmt->execute();

        // Redirect to the page where you list Faculty Subjects
        header('Location: Grade-index.php');
        exit();
    } catch (PDOException $e) {
        echo "Error deleting record: " . $e->getMessage();
    }
} else {
    echo "Invalid faculty subject ID.";
}

// Close the PDO connection
$conn = null;
?>
