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
          <form action="Semester-Insert.php" method="post" enctype="multipart/form-data">
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Semester</label>
              <div class="col-sm-10" style="margin-right: 5px;">
                <input type="text" class="form-control" id="inputEmail3" name="subject_name" placeholder="Enter Semester Name">
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">YearLevel</label>
              <div class="col-sm-10" style="margin-right: 5px;">
                <input type="number" class="form-control" id="inputEmail3" name="year" placeholder="Enter Year Level">
              </div>
            </div>

            <div class="row mb-3">
              <label for="course_id" class="col-sm-2 col-form-label">Select The Subjects</label>
              <div class="col-sm-10">
                <select class="form-select" name="course_id" id="course_id" aria-label="Default select example">
                  <option selected>Select Subjects</option>
                  <?php
                  include('../Public/Connection2.php');

                  // Fetch all courses from the database
                  $courseQuery = "SELECT * FROM subjects";

                  $courseResult = mysqli_query($conn, $courseQuery);

                  while ($row = mysqli_fetch_assoc($courseResult)) {
                    $id = $row['SubjectID'];
                    $name = $row['SubjectName'];
                    echo "<option value='$id'>$name</option>";
                  }

                  // Close the MySQLi connection
                  mysqli_close($conn);
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
        <th>Semester ID</th>
        <th scope="col">Semester Name</th>
        <th scope="col">Year Level</th>
        <th scope="col">Subject Name</th>
        <th colspan="2">Operation</th>
      </tr>
    </thead>
    <tbody>

      <?php
      include('../Public/Connection2.php');
      $sql = $sql = "SELECT semesters.SemesterID, semesters.SemesterName, semesters.YearLevel, subjects.SubjectName
      FROM semesters
      INNER JOIN subjects ON semesters.SubjectID = subjects.SubjectID";


      $result = mysqli_query($conn, $sql);
      while ($row = mysqli_fetch_assoc($result)) {

        $id = $row['SemesterID'];
        $name = $row['SemesterName'];
        $level = $row['YearLevel'];
        $subjectName = $row['SubjectName'];
        echo '
                <tr>
                    <th>' . $id . '</th>
                    <td>' . $name . '</td>
                    <td>' . $level . '</td>
                    <td>' . $subjectName . '</td>
                    <td><button type="button" class="btn btn-primary"><a href="Semester-Update.php?subject_id=' . $id . '">Primary</a></button></td>
                    <td><button type="button" class="btn btn-danger"><a href="Semester-Delete.php?delete_id=' . $id . '">Danger</a></button></td>
                </tr>';
      }
      ?>

    </tbody>
  </table>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>