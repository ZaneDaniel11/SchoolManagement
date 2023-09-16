<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Faculty Subject</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Update Faculty Subject</h2>

        <?php
        include('../Public/Connection.php');

        // Assuming you have the FacultySubjectID from the URL parameter
        $facultySubjectID = $_GET['faculty_subject_id'];

        // Fetch the current data from the FacultySubjects table
        $selectQuery = "SELECT * FROM FacultySubjects WHERE FacultySubjectID = ?";
        $stmt = $conn->prepare($selectQuery);
        $stmt->bindParam(1, $facultySubjectID, PDO::PARAM_INT);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $teacherID = $row['TeacherID'];
            $subjectID = $row['SubjectID'];
        }
        ?>

        <form action="#" method="post">
            <div class="mb-3">
                <label for="teacher_id" class="form-label">Teacher</label>
                <select class="form-select" name="teacher_id" id="teacher_id" required>
                    <!-- Populate the dropdown with teacher names -->
                    <?php
                    $teachersQuery = "SELECT TeacherID, TeacherName FROM teachers";
                    $teachersResult = $conn->query($teachersQuery);

                    while ($teacher = $teachersResult->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($teacher['TeacherID'] == $teacherID) ? 'selected' : '';
                        echo "<option value='{$teacher['TeacherID']}' $selected>{$teacher['TeacherName']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="subject_id" class="form-label">Subject</label>
                <select class="form-select" name="subject_id" id="subject_id" required>
                    <!-- Populate the dropdown with subject names -->
                    <?php
                    $subjectsQuery = "SELECT SubjectID, SubjectName FROM subjects";
                    $subjectsResult = $conn->query($subjectsQuery);

                    while ($subject = $subjectsResult->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($subject['SubjectID'] == $subjectID) ? 'selected' : '';
                        echo "<option value='{$subject['SubjectID']}' $selected>{$subject['SubjectName']}</option>";
                    }
                    ?>
                </select>
            </div>

            <input type="hidden" name="faculty_subject_id" value="<?php echo $facultySubjectID; ?>">

            <button type="submit" name="update" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php

if (isset($_POST['update'])) {
    $facultySubjectID = $_POST['faculty_subject_id'];
    $teacherID = $_POST['teacher_id'];
    $subjectID = $_POST['subject_id'];

    try {
        // Use prepared statement to avoid SQL injection
        $updateQuery = "UPDATE FacultySubjects SET TeacherID = ?, SubjectID = ? WHERE FacultySubjectID = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bindParam(1, $teacherID, PDO::PARAM_INT);
        $stmt->bindParam(2, $subjectID, PDO::PARAM_INT);
        $stmt->bindParam(3, $facultySubjectID, PDO::PARAM_INT);
        $stmt->execute();

        header('location:Faculty-Index.php');
        exit();
    } catch (PDOException $e) {
        echo "Error updating record: " . $e->getMessage();
    }
    
    $conn = null;
}
?>
