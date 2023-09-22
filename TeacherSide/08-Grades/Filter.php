<?php
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

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit();
}
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

    <div class="container mt-5" style="margin-left: 100px;">
        <h2>Student Information Table</h2>

        <!-- Filter Form -->
        <form method="post">
            <div class="row mb-3">
                <div class="col">
                    <label for="departmentFilter" class="form-label">Filter by Department:</label>
                    <select class="form-select" name="departmentFilter" id="departmentFilter">
                        <option value="">All Departments</option>
                        <!-- Populate dropdown with department options -->
                        <?php
                        // Fetch department options from the database
                        $departmentQuery = "SELECT DISTINCT DepartmentName FROM departments";
                        $departmentStmt = $conn->prepare($departmentQuery);
                        $departmentStmt->execute();

                        while ($departmentRow = $departmentStmt->fetch(PDO::FETCH_ASSOC)) {
                            $selected = ($_POST['departmentFilter'] == $departmentRow['DepartmentName']) ? 'selected' : '';
                            echo '<option value="' . $departmentRow['DepartmentName'] . '" ' . $selected . '>' . $departmentRow['DepartmentName'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col">
                    <label for="yearFilter" class="form-label">Filter by Year Level:</label>
                    <select class="form-select" name="yearFilter" id="yearFilter">
                        <option value="">All Year Levels</option>
                        <!-- Populate dropdown with year level options -->
                        <?php
                        // Fetch year level options from the database
                        $yearQuery = "SELECT DISTINCT YearLevel FROM students";
                        $yearStmt = $conn->prepare($yearQuery);
                        $yearStmt->execute();

                        while ($yearRow = $yearStmt->fetch(PDO::FETCH_ASSOC)) {
                            $selected = ($_POST['yearFilter'] == $yearRow['YearLevel']) ? 'selected' : '';
                            echo '<option ' . $selected . '>' . $yearRow['YearLevel'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </div>
        </form>

        <!-- Student Information Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Department</th>
                    <th>Course</th>
                    <th>Year Level</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $departmentFilter = isset($_POST['departmentFilter']) ? $_POST['departmentFilter'] : '';
                $yearFilter = isset($_POST['yearFilter']) ? $_POST['yearFilter'] : '';
                // Modify your query based on the selected filters

                $query = "SELECT students.StudentID, students.StudentName, departments.DepartmentName, courses.CourseName, students.YearLevel
                          FROM students
                          INNER JOIN departments ON students.DepartmentID = departments.DepartmentID
                          INNER JOIN courses ON students.CourseID = courses.CourseID
                          WHERE (:departmentFilter = '' OR departments.DepartmentName = :departmentFilter)
                          AND (:yearFilter = '' OR students.YearLevel = :yearFilter)";

                $stmt = $conn->prepare($query);
                $stmt->bindParam(':departmentFilter', $departmentFilter);
                $stmt->bindParam(':yearFilter', $yearFilter);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $id = $row['StudentID'];
                        echo '<tr>';
                        echo '<td>' . $row['StudentID'] . '</td>';
                        echo '<td>' . $row['StudentName'] . '</td>';
                        echo '<td>' . $row['DepartmentName'] . '</td>';
                        echo '<td>' . $row['CourseName'] . '</td>';
                        echo '<td>' . $row['YearLevel'] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">No records found</td></tr>';
                }

                // Close connection
                $conn = null;
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
