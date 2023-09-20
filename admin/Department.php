<?php
include 'Public/Connection.php';
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location:Login.php");
    exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">



  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


  <link rel="stylesheet" href="01-Department/CSS-Department/Index.css">


  <style>
    .alb {
      width: 50px;
      height: 50px;
      padding: 5px;
    }

    .alb img {
      width: 100%;
      height: 100%;
    }

    a {
      text-decoration: none;
      color: black;
    }

    .navbar-nav
    {
      display: flex;
      flex-direction: column;

    }
  </style>
</head>

<body>
    
<?php
include('Public/navbar.html');
?>
  
  <!-- ADD modal -->
  <div class="modal fade" id="add_data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- FORM STARTS -->
          <form action="01-Department/Department-Code.php" method="post" enctype="multipart/form-data">
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Department</label>
              <div class="col-sm-10" style="margin-right: 5px;">
                <input type="text" class="form-control" id="inputEmail3" name="Department" placeholder="Enter Department Name">
              </div>
            </div>

            <div class="row mb-3">
              <label for="file" class="col-sm-2 col-form-label">Logo</label>
              <div class="col-sm-10">
                <input type="file" name="my_image" enctype="multipart/form-data">
              </div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Insert</button>


          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Add Modal -->

  <!-- Update Modal -->
  <div class="modal fade" id="update_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Update</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- FORM STARTS -->
          <form action="Department-Code.php" method="post" enctype="multipart/form-data">
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Department</label>
              <div class="col-sm-10" style="margin-right: 5px;">
                <input type="text" class="form-control" id="inputEmail3" name="Department" placeholder="Enter Department Name">
              </div>
            </div>

            <div class="row mb-3">
              <label for="file" class="col-sm-2 col-form-label">Logo</label>
              <div class="col-sm-10">
                <input type="file" name="my_image" enctype="multipart/form-data">
              </div>
            </div>
            <button type="submit" name="update_btn" class="btn btn-primary">Insert</button>


          </form>
          <!-- Form -->
        </div>
      </div>
    </div>
  </div>

  <!-- Update Modal -->



  <div class="Insert-Button-Container"><button class="button-41" role="button" data-bs-toggle="modal" data-bs-target="#add_data">Button 41</button></div>


  <table class="table table-bordered" style="margin-left: 100px;">
    <thead>
      <tr>
        <th>Department ID</th>
        <th scope="col">Department Name</th>
        <th scope="col">Department Logo</th>
        <th colspan="2">Operation</th>
      </tr>
    </thead>
    <tbody>

      <?php
      $department = 'SELECT *FROM departments';
      $result = mysqli_query($conn, $department);

      if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
          $id = $row['DepartmentID'];
          $name = $row['DepartmentName'];
          $logo = $row['DepartmentLogo'];

          echo '
                        <tr>
                        <th class="department_id">' . $id . '</th>
                        <td>' . $name . '</td>
                        <td><div class="alb"><img src="../01-Department/Images-Department/' . $logo . '"></div>
                        </td>

                       <td><a href="01-Department/department_update.php?update_id=' . $id . '" class="edit_btn"><button type="button" class="btn btn-primary">Update</button></a></td>
                       <td><a href="01-Department/Department-Delete.php?delete_id=' . $id . '"><button type="button" class="btn btn-danger">Delete</button></a></td>
                        </tr>
                        ';
        }
      }

      ?>
    </tbody>
  </table>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


</body>

</html>