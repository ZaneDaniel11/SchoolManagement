<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="../01-Department/CSS-Department/Index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <?php
    include('../Public/navbar.html');

    try {
        $conn = new PDO("mysql:host=localhost;dbname=school_db", 'root', '');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the form is submitted
        if (isset($_POST['submit'])) {
            $subjectName = $_POST['subject_name'];
            $courseID = $_POST['course_id'];

            // Insert query using prepared statement
            $insertQuery = "INSERT INTO subjects (SubjectName, CourseID) VALUES (:subjectName, :courseID)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bindParam(':subjectName', $subjectName);
            $stmt->bindParam(':courseID', $courseID);
            $stmt->execute();

            // Redirect to the page where you list subjects
            header('Location: Subject-Index.php');
            exit();
        }

        // Fetch subjects data
        $selectQuery = "SELECT subjects.SubjectID, subjects.SubjectName, courses.CourseName
                        FROM subjects
                        INNER JOIN courses ON subjects.CourseID = courses.CourseID";

        $result = $conn->query($selectQuery);

    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    ?>

    <!-- ADD modal -->
    <div class="modal fade" id="add_data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- FORM STARTS -->
                    <form action="Subject-Insert.php" method="post" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Subject</label>
                            <div class="col-sm-10" style="margin-right: 5px;">
                                <input type="text" class="form-control" id="inputEmail3" name="subject_name" placeholder="Enter Subject">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="course_id" class="col-sm-2 col-form-label">Select The Course</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="course_id" id="course_id" aria-label="Default select example">
                                    <option selected>Select The Course</option>
                                    <?php
                                    // Fetch all courses using PDO
                                    $courseQuery = "SELECT * FROM courses";
                                    $courseResult = $conn->query($courseQuery);

                                    while ($row = $courseResult->fetch(PDO::FETCH_ASSOC)) {
                                        $id = $row['CourseID'];
                                        $name = $row['CourseName'];
                                        echo "<option value='$id'>$name</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">Insert</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="Insert-Button-Container"><button class="button-41" role="button" data-bs-toggle="modal" data-bs-target="#add_data">Button 41</button></div>

    <table class="table table-bordered" style="margin-left: 100px;">
        <thead>
            <tr>
                <th>Subject ID</th>
                <th scope="col">Subject Name</th>
                <th scope="col">Course</th>
                <th colspan="2">Operation</th>
            </tr>
        </thead>
        <tbody>

            <?php
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $id = $row['SubjectID'];
                $name = $row['SubjectName'];
                $courseName = $row['CourseName'];
                echo '
                    <tr>
                        <th>' . $id . '</th>
                        <td>' . $name . '</td>
                        <td>' . $courseName . '</td>
                        <td><button type="button" class="btn btn-primary"><a href="Subject-Update.php?subject_id=' . $id . '">Primary</a></button></td>
                        <td><button type="button" class="btn btn-danger"><a href="Subject-Delete.php?subject_id=' . $id . '">Danger</a></button></td>
                    </tr>';
            }
            ?>

        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
