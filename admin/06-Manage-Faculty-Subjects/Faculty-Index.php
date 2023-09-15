<!doctype html>
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
                    <form action="Faculty-Insert.php" method="post" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <label for="teacher_id" class="col-sm-2 col-form-label">Teacher</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="teacher_id" id="teacher_id" aria-label="Default select example">
                                    <option selected>Select The Teacher</option>
                                    <?php
                                    include('../Public/Connection.php');

                                    // Fetch all teachers from the database
                                    $teacherQuery = "SELECT * FROM teachers";
                                    $stmt = $conn->query($teacherQuery);

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $id = $row['TeacherID'];
                                        $name = $row['TeacherName'];
                                        echo "<option value='$id'>$name</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="subject_id" class="col-sm-2 col-form-label">Subject</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="subject_id" id="subject_id" aria-label="Default select example">
                                    <option selected>Select The Subject</option>
                                    <?php
                                    // Fetch all subjects from the database
                                    $subjectQuery = "SELECT * FROM subjects";
                                    $stmt = $conn->query($subjectQuery);

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $id = $row['SubjectID'];
                                        $name = $row['SubjectName'];
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
                <th>Faculty ID</th>
                <th scope="col">Teacher Name</th>
                <th scope="col">Teacher Subject</th>
                <th colspan="2">Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT facultySubjects.FacultySubjectID, teachers.TeacherName, subjects.SubjectName
        FROM facultySubjects
        INNER JOIN teachers ON facultySubjects.TeacherID = teachers.TeacherID
        INNER JOIN subjects ON facultySubjects.SubjectID = subjects.SubjectID";

            $stmt = $conn->query($sql);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $id = $row['FacultySubjectID'];
                $teacherName = $row['TeacherName'];
                $subjectName = $row['SubjectName'];

                echo '
        <tr>
            <th>' . $id . '</th>
            <td>' . $teacherName . '</td>
            <td>' . $subjectName . '</td>
            <td><button type="button" class="btn btn-primary"><a href="FacultySubject-Update.php?faculty_subject_id=' . $id . '">Primary</a></button></td>
            <td><button type="button" class="btn btn-danger"><a href="FacultySubject-Delete.php?faculty_subject_id=' . $id . '">Danger</a></button></td>
        </tr>';
            }
            ?>
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
