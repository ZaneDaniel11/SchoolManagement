<!-- update_student.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <?php
    // Include your database connection file
    include('../Public/Connection2.php');

    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        $studentID = $_GET['student_id'];
        $studentName = $_POST['student_name'];
        $departmentID = $_POST['department_id'];
        $courseID = $_POST['course_id'];
        $yearLevel = $_POST['year_level'];

        // Perform update query
        $updateQuery = "UPDATE students 
                        SET StudentName = '$studentName', 
                            DepartmentID = '$departmentID', 
                            CourseID = '$courseID', 
                            YearLevel = '$yearLevel' 
                        WHERE StudentID = '$studentID'";

        $result = $conn->query($updateQuery);

        if ($result) {
            header('Location:Student-Index.php');
        } else {
            echo '<div class="alert alert-danger" role="alert">
                    Error updating student: ' . $conn->error . '
                  </div>';
        }
    }

    // Fetch existing student data
    $studentID = $_GET['student_id'];
    $selectQuery = "SELECT * FROM students WHERE StudentID = '$studentID'";
    $result = $conn->query($selectQuery);
    $row = $result->fetch_assoc();
    ?>

    <div class="container mt-5">
        <h2>Update Student</h2>
        <form method="post" action="">
            <div class="mb-3">
                <label for="student_name" class="form-label">Student Name</label>
                <input type="text" class="form-control" id="student_name" name="student_name" value="<?php echo $row['StudentName']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="department_id" class="form-label">Select Department</label>
                <!-- Fetch and display departments from the database -->
                <select class="form-select" name="department_id" id="department_id" required>
                    <?php
                    $departmentsQuery = "SELECT * FROM departments";
                    $departmentsResult = $conn->query($departmentsQuery);

                    while ($department = $departmentsResult->fetch_assoc()) {
                        $selected = ($row['DepartmentID'] == $department['DepartmentID']) ? 'selected' : '';
                        echo '<option value="' . $department['DepartmentID'] . '" ' . $selected . '>' . $department['DepartmentName'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="course_id" class="form-label">Select Course</label>
                <!-- Fetch and display courses from the database -->
                <select class="form-select" name="course_id" id="course_id" required>
                    <?php
                    $coursesQuery = "SELECT * FROM courses";
                    $coursesResult = $conn->query($coursesQuery);

                    while ($course = $coursesResult->fetch_assoc()) {
                        $selected = ($row['CourseID'] == $course['CourseID']) ? 'selected' : '';
                        echo '<option value="' . $course['CourseID'] . '" ' . $selected . '>' . $course['CourseName'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="year_level" class="form-label">Year Level</label>
                <input type="number" class="form-control" id="year_level" name="year_level" value="<?php echo $row['YearLevel']; ?>" required>
            </div>
            <input type="hidden" name="student_id" value="<?php echo $row['StudentID']; ?>">
            <button type="submit" name="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
