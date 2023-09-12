<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Department</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <?php
    include('../Public/Connection.php');

    if(isset($_GET['subject_id'])) {
        $id = $_GET['subject_id'];
        $sql = "SELECT * FROM semesters WHERE SemesterID = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $name = $row['SemesterName'];
        $year = $row['YearLevel'];
    }
    ?>
    <form action="#" method="post">
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Semester Name</label>
            <div class="col-sm-10" style="margin-right: 5px;">
                <input type="text" class="form-control" id="inputEmail3" name="semester_name" placeholder="Enter Semester" value="<?php echo $name ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Year Level</label>
            <div class="col-sm-10" style="margin-right: 5px;">
                <input type="text" class="form-control" id="inputEmail3" name="year" placeholder="Enter Year Level" value="<?php echo $year ?>">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-10">
                <select class="form-select" name="subject_id" id="course_id" aria-label="Default select example">
                    <option selected>Subjects</option>
                    <?php
                    $courseQuery = "SELECT * FROM subjects";
                    $courseStmt = $conn->query($courseQuery);

                    while ($row = $courseStmt->fetch(PDO::FETCH_ASSOC)) {
                        $subjectId = $row['SubjectID'];
                        $subjectName = $row['SubjectName'];
                        echo "<option value='$subjectId'>$subjectName</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Update</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>

<?php
if (isset($_POST['submit'])) {
    try {
        $id = $_GET['subject_id'];
        $name = $_POST['semester_name'];
        $year = $_POST['year'];
        $subject = $_POST['subject_id'];

        $sql = "UPDATE semesters SET SemesterName = :name, YearLevel = :year, SubjectID = :subject WHERE SemesterID = :id";
        $updateStmt = $conn->prepare($sql);
        $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $updateStmt->bindParam(':name', $name, PDO::PARAM_STR);
        $updateStmt->bindParam(':year', $year, PDO::PARAM_STR);
        $updateStmt->bindParam(':subject', $subject, PDO::PARAM_INT);
        $updateStmt->execute();

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
