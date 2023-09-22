<?php
$host = 'localhost';
$username = 'root';
$password = '';
$db_name = 'school_db';

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['grade_id'])) {
        $gradeID = $_GET['grade_id'];

        // Assuming you have retrieved the updated values from a form or elsewhere
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

        // Update query using prepared statement
        $updateQuery = "UPDATE grades 
                        SET PrelimGrade = :prelimGrade, 
                            MidtermGrade = :midtermGrade, 
                            SemiFinalsGrade = :semiFinalsGrade, 
                            FinalsGrade = :finalsGrade,
                            FinalGrade = :totalWeightedScore
                        WHERE GradeID = :gradeID";

        $stmt = $conn->prepare($updateQuery);
        $stmt->bindParam(':prelimGrade', $prelimGrade);
        $stmt->bindParam(':midtermGrade', $midtermGrade);
        $stmt->bindParam(':semiFinalsGrade', $semiFinalsGrade);
        $stmt->bindParam(':finalsGrade', $finalsGrade);
        $stmt->bindParam(':totalWeightedScore', $totalWeightedScore);
        $stmt->bindParam(':gradeID', $gradeID);
        $stmt->execute();

        // Redirect to the page where you list Grades or display a success message
        header('Location: Grade-index.php?success=1');
        exit();
    } else {
        echo "Invalid grade ID.";
    }
} catch (PDOException $e) {
    echo "Error updating record: " . $e->getMessage();
} finally {
    // Close the PDO connection
    $conn = null;
}
?>
