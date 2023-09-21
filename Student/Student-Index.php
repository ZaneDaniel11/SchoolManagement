<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
  
  exit();
}

// The rest of your existing code
include('../Public/Connection.php');

// ... (rest of your code)
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Information Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../Public/Index.css">
</head>

<body>

  <?php
  include('../Public/navbar.html');
  ?>

  <!-- ADD modal -->
  <div class="modal fade" id="add_data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Add Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- FORM STARTS -->

          <div class="container mt-5">
            <h2>Student Information Form</h2>
            <form action="Grade-Insert.php" method="post">
              <div class="mb-3">
                <label for="student_id" class="form-label">Student</label>
                <select class="form-select" id="student_id" name="student_id" required>
                  <!-- Options for students will be populated dynamically from the database -->
                  <?php
                  // Include your database connection script
                  include('../Public/Connection.php');
                  $studentQuery = "SELECT * FROM Students";
                  $studentResult = mysqli_query($conn, $studentQuery);

                  while ($studentRow = mysqli_fetch_assoc($studentResult)) {
                    echo "<option value='{$studentRow['StudentID']}'>{$studentRow['StudentName']}</option>";
                  }

                  mysqli_close($conn);
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="subject_id" class="form-label">Subject</label>
                <select class="form-select" id="subject_id" name="subject_id" required>
                  <!-- Options for subjects will be populated dynamically from the database -->
                  <?php
                  include('../Public/Connection.php');

                  $subjectQuery = "SELECT * FROM Subjects";
                  $subjectResult = mysqli_query($conn, $subjectQuery);

                  while ($subjectRow = mysqli_fetch_assoc($subjectResult)) {
                    echo "<option value='{$subjectRow['SubjectID']}'>{$subjectRow['SubjectName']}</option>";
                  }

                  mysqli_close($conn);
                  ?>
                </select>
              </div>

              <div class="mb-3">
                <label for="semester_id" class="form-label">Semester</label>
                <select class="form-select" id="semester_id" name="semester_id" required>
                  <!-- Options for semesters will be populated dynamically from the database -->
                  <?php
                  include('../Public/Connection.php');

                  $semesterQuery = "SELECT * FROM Semesters";
                  $semesterResult = mysqli_query($conn, $semesterQuery);

                  while ($semesterRow = mysqli_fetch_assoc($semesterResult)) {
                    echo "<option value='{$semesterRow['SemesterID']}'>{$semesterRow['SemesterName']}</option>";
                  }

                  mysqli_close($conn);
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="prelim_grade" class="form-label">Prelim Grade</label>
                <input type="text" class="form-control" id="prelim_grade" name="prelim_grade" required>
              </div>

              <div class="mb-3">
                <label for="midterm_grade" class="form-label">Midterm Grade</label>
                <input type="text" class="form-control" id="midterm_grade" name="midterm_grade" required>
              </div>

              <div class="mb-3">
                <label for="semi_finals_grade" class="form-label">Semi-Finals Grade</label>
                <input type="text" class="form-control" id="semi_finals_grade" name="semi_finals_grade" required>
              </div>

              <div class="mb-3">
                <label for="finals_grade" class="form-label">Finals Grade</label>
                <input type="text" class="form-control" id="finals_grade" name="finals_grade" required>
              </div>

              <button type="submit" name="submit" class="btn btn-primary">Submit</button>

            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
  <div class="Insert-Button-Container"><button class="button-41" role="button" data-bs-toggle="modal" data-bs-target="#add_data">Button 41</button></div>

  <?php
    // Replace these with your actual database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "school_db";

    try {
        // Create a PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query to fetch data from the Grades table
        $sql = "SELECT * FROM Grades";
        $result = $conn->query($sql);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
    ?>

    <div class="container mt-5">
        <h2>Grades Table</h2>
        <table class="table table-bordered">
            <thead>
                <!-- ... (your existing table header) ... -->
            </thead>
            <tbody>
                <?php
                // Display data from the database
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        $id = $row['GradeID'];
                        // Fetch student name
                        $studentID = $row['StudentID'];
                        $studentQuery = "SELECT StudentName FROM Students WHERE StudentID = :studentID";
                        $studentStatement = $conn->prepare($studentQuery);
                        $studentStatement->bindParam(':studentID', $studentID);
                        $studentStatement->execute();
                        $studentName = ($studentStatement->rowCount() > 0) ? $studentStatement->fetchColumn() : "";

                        // Fetch subject name
                        $subjectID = $row['SubjectID'];
                        $subjectQuery = "SELECT SubjectName FROM Subjects WHERE SubjectID = :subjectID";
                        $subjectStatement = $conn->prepare($subjectQuery);
                        $subjectStatement->bindParam(':subjectID', $subjectID);
                        $subjectStatement->execute();
                        $subjectName = ($subjectStatement->rowCount() > 0) ? $subjectStatement->fetchColumn() : "";

                        // Fetch semester name
                        $semesterID = $row['SemesterID'];
                        $semesterQuery = "SELECT SemesterName FROM Semesters WHERE SemesterID = :semesterID";
                        $semesterStatement = $conn->prepare($semesterQuery);
                        $semesterStatement->bindParam(':semesterID', $semesterID);
                        $semesterStatement->execute();
                        $semesterName = ($semesterStatement->rowCount() > 0) ? $semesterStatement->fetchColumn() : "";

                        echo "<tr>";
                        echo "<td>{$row['GradeID']}</td>";
                        echo "<td>{$studentName}</td>";
                        echo "<td>{$subjectName}</td>";
                        echo "<td>{$semesterName}</td>";
                        echo "<td>{$row['PrelimGrade']}</td>";
                        echo "<td>{$row['MidtermGrade']}</td>";
                        echo "<td>{$row['SemiFinalsGrade']}</td>";
                        echo "<td>{$row['FinalsGrade']}</td>";
                        echo "<td>{$row['FinalGrade']}</td>";
                        echo '<td><button type="button" class="btn btn-primary"><a href="Grade-Update.php?grade_id=' . $id . '">Primary</a></button></td>
                            <td><button type="button" class="btn btn-danger"><a href="Grade-Delete.php?grade_id=' . $id . '">Danger</a></button></td>';
                    }
                } else {
                    echo "<tr><td colspan='9'>No data available</td></tr>";
                }

                // Close the PDO connection
                $conn = null;
                ?>
            </tbody>
        </table>     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
      <!-- Add any additional scripts for dynamic population of dropdown options if needed -->

</body>

</html>