<?php
// Replace these with your actual database connection details
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'school_db';

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $studentName = $_POST['studentName'];
    $departmentID = $_POST['departmentID'];
    $courseID = $_POST['Course'];
    $yearLevel = $_POST['yearLevel'];

    // Insert into the students table
    $insertQuery = "INSERT INTO `students` (`StudentName`, `DepartmentID`, `CourseID`, `YearLevel`) VALUES ('$studentName', '$departmentID', '$courseID', '$yearLevel')";

    if (mysqli_query($conn, $insertQuery)) {
       header('Location:Student-Index.php');
    } else {
        echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
