<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Grade</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body>
    <?php
    // Assuming you've passed the grade ID through the URL
    $gradeID = isset($_GET['grade_id']) ? $_GET['grade_id'] : null;

    if ($gradeID) {
        // Fetch existing data for the given grade ID

        $host = 'localhost';
        $username = 'root';
        $password = '';
        $db_name = 'school_db';

        try {
            // Create a PDO connection
            $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Your code logic here...

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }


        $selectQuery = "SELECT * FROM grades WHERE GradeID = :gradeID";
        $selectStmt = $conn->prepare($selectQuery);
        $selectStmt->bindParam(':gradeID', $gradeID);
        $selectStmt->execute();
        $gradeData = $selectStmt->fetch(PDO::FETCH_ASSOC);

        if (!$gradeData) {
            echo "Invalid grade ID.";
            exit();
        }
    } else {
        echo "Invalid grade ID.";
        exit();
    }
    ?>

    <div class="container mt-5">
        <h2>Update Grade</h2>
        <form action="process.php?grade_id=<?php echo $gradeID; ?>" method="post">
            <div class="mb-3">
                <label for="prelim_grade" class="form-label">Prelim Grade</label>
                <input type="text" class="form-control" id="prelim_grade" name="prelim_grade" value="<?php echo $gradeData['PrelimGrade']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="midterm_grade" class="form-label">Midterm Grade</label>
                <input type="text" class="form-control" id="midterm_grade" name="midterm_grade" value="<?php echo $gradeData['MidtermGrade']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="semi_finals_grade" class="form-label">Semi-Finals Grade</label>
                <input type="text" class="form-control" id="semi_finals_grade" name="semi_finals_grade" value="<?php echo $gradeData['SemiFinalsGrade']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="finals_grade" class="form-label">Finals Grade</label>
                <input type="text" class="form-control" id="finals_grade" name="finals_grade" value="<?php echo $gradeData['FinalsGrade']; ?>" required>
            </div>

            <button type="submit"  class="btn btn-primary">Update Grade</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

