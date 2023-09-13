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
    $id = $_GET['subject_id'];
    $sql = "SELECT * FROM teachers WHERE TeacherID = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $name = $row['TeacherName'];
    ?>
    <form action="#" method="post" enctype="multipart/form-data">
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Subject</label>
            <div class="col-sm-10" style="margin-right: 5px;">
                <input type="text" class="form-control" id="inputEmail3" name="subject_name" placeholder="Enter Subject" value="<?php echo $name ?>">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-10">
                <select class="form-select" name="course_id" id="course_id" aria-label="Default select example">
                    <option selected>Select The Course</option>
                    <?php
                    $courseQuery = "SELECT * FROM departments";
                    $courseResult = $conn->query($courseQuery);

                    while ($row = $courseResult->fetch(PDO::FETCH_ASSOC)) {
                        $id = $row['DepartmentID'];
                        $name = $row['DepartmentName'];
                        echo "<option value='$id'>$name</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Insert</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>

<?php
include('../Public/Connection.php');

if (isset($_POST['submit'])) {
    $id = $_GET['subject_id'];
    $name = $_POST['subject_name'];
    $course = $_POST['course_id'];

    try {
        $sql = "UPDATE teachers SET TeacherName = :name, DepartmentID = :course WHERE TeacherID = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':course', $course, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header('Location: Teacher-Index.php');
        exit();
    } catch (PDOException $e) {
        echo "Error updating record: " . $e->getMessage();
    }
}
?>
