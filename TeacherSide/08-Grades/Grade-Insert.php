<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Now you can use $_SESSION['username'] to get the username

// Your dashboard content...
?>

<?php
include('../Public/Connection.php');

// Assume you have retrieved these values from your form or wherever you get them
$studentID = $_POST['student_id'];
$subjectID = $_POST['subject_id'];
$semesterID = $_POST['semester_id'];
$prelimGrade = $_POST['prelim_grade'];
$midtermGrade = $_POST['midterm_grade'];
$semiFinalsGrade = $_POST['semi_finals_grade'];
$finalsGrade = $_POST['finals_grade'];

// Define the weights for each component
$prelimWeight = 0.20;
$midtermWeight = 0.30;
$semiFinalsWeight = 0.20;
$finalsWeight = 0.30;

// Calculate the weighted scores for each component
$weightedPrelim = $prelimGrade * $prelimWeight;
$weightedMidterm = $midtermGrade * $midtermWeight;
$weightedSemiFinals = $semiFinalsGrade * $semiFinalsWeight;
$weightedFinals = $finalsGrade * $finalsWeight;

// Sum the weighted scores to get the final grade
$totalWeightedScore = $weightedPrelim + $weightedMidterm + $weightedSemiFinals + $weightedFinals;

try {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "school_db";
    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Your insert query with the computed final grade
    $insertQuery = "INSERT INTO Grades (StudentID, SubjectID, SemesterID, PrelimGrade, MidtermGrade, SemiFinalsGrade, FinalsGrade, FinalGrade)
                    VALUES (:studentID, :subjectID, :semesterID, :prelimGrade, :midtermGrade, :semiFinalsGrade, :finalsGrade, :totalWeightedScore)";

    $stmt = $conn->prepare($insertQuery);
    $stmt->bindParam(':studentID', $studentID);
    $stmt->bindParam(':subjectID', $subjectID);
    $stmt->bindParam(':semesterID', $semesterID);
    $stmt->bindParam(':prelimGrade', $prelimGrade);
    $stmt->bindParam(':midtermGrade', $midtermGrade);
    $stmt->bindParam(':semiFinalsGrade', $semiFinalsGrade);
    $stmt->bindParam(':finalsGrade', $finalsGrade);
    $stmt->bindParam(':totalWeightedScore', $totalWeightedScore);

    $stmt->execute();

    header('Location:Grade-index.php');
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the PDO connection
$conn = null;
?>
