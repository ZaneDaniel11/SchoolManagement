<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../01-Department/CSS-Department/Index.css">
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
                        <form action="Student-Insert.php" method="post">

                            <div class="mb-3">
                                <label for="studentName" class="form-label">Student Name</label>
                                <input type="text" class="form-control" id="studentName" name="studentName" required>
                            </div>

                            <div class="mb-3">
                                <label for="departmentID" class="form-label">Select Department</label>
                                <select class="form-select" id="departmentID" name="departmentID" required>
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

                                    $departmentQuery = "SELECT * FROM departments";
                                    $departmentResult = mysqli_query($conn, $departmentQuery);

                                    while ($departmentRow = mysqli_fetch_assoc($departmentResult)) {
                                        echo "<option value='{$departmentRow['DepartmentID']}'>{$departmentRow['DepartmentName']}</option>";
                                    }

                                    mysqli_close($conn);
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="departmentID" class="form-label">Select Course</label>
                                <select class="form-select" id="Course" name="Course" required>
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

                                    $departmentQuery = "SELECT * FROM courses";
                                    $departmentResult = mysqli_query($conn, $departmentQuery);

                                    while ($departmentRow = mysqli_fetch_assoc($departmentResult)) {
                                        echo "<option value='{$departmentRow['CourseID']}'>{$departmentRow['CourseName']}</option>";
                                    }

                                    mysqli_close($conn);
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="yearLevel" class="form-label">Year Level</label>
                                <input type="number" class="form-control" id="yearLevel" name="yearLevel" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="Insert-Button-Container"><button class="button-41" role="button" data-bs-toggle="modal" data-bs-target="#add_data">Button 41</button></div>


    <table class="table table-bordered" style="margin-left: 100px;">
        <thead>
            <tr>
                <th>Faculty ID</th>
                <th scope="col">Teacher Name</th>
                <th scope="col">Teacher Subject</th>
                <th colspan="2">Operation</th>
            </tr>
        </thead>
        <tbody>

            <div class="container mt-5" style="margin-left: 100px;">
                <h2>Student Information Table</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Department</th>
                            <th>Course</th>
                            <th>Year Level</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
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

                        // Replace this query with your actual query to fetch student data
                        $query = "SELECT students.StudentID, students.StudentName, departments.DepartmentName, courses.CourseName, students.YearLevel
              FROM students
              INNER JOIN departments ON students.DepartmentID = departments.DepartmentID
              INNER JOIN courses ON students.CourseID = courses.CourseID";

                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {

                            while ($row = $result->fetch_assoc()) {
                                $id = $row['StudentID'];
                                echo '<tr>';
                                echo '<td>' . $row['StudentID'] . '</td>';
                                echo '<td>' . $row['StudentName'] . '</td>';
                                echo '<td>' . $row['DepartmentName'] . '</td>';
                                echo '<td>' . $row['CourseName'] . '</td>';
                                echo '<td>' . $row['YearLevel'] . '</td>';
                                echo ' <td><button type="button" class="btn btn-primary"><a href="Student-Update.php?student_id=' . $id . '">Primary</a></button></td>
                                        <td><button type="button" class="btn btn-danger"><a href="Student-Delete.php?student_id=' . $id . '">Danger</a></button></td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="6">No records found</td></tr>';
                        }

                        // Close connection
                        $conn->close();
                        ?>

                    </tbody>
                </table>
            </div>





            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
            <!-- Add any additional scripts for dynamic population of dropdown options if needed -->

</body>

</html>