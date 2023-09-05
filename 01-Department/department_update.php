<?php
include('../Public/Connection2.php');

if (isset($_GET['update_id'])) {
    $id = $_GET['update_id'];
    
    // Fetch department data from the database
    $department_query = "SELECT * FROM departments WHERE DepartmentID = $id";
    $result = mysqli_query($conn, $department_query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['DepartmentName'];
        $logo = $row['DepartmentLogo'];
    } else {
        // Handle the case where the department with the given ID is not found
        die("Department not found.");
    }
} else {
    // Handle the case where the 'update_id' parameter is not set
    die("Invalid request.");
}

// Process form submission
if (isset($_POST['Update_btn'])) {
    $img_name = $_FILES['my_image']['name'];
    $img_size = $_FILES['my_image']['size'];
    $tmp_name = $_FILES['my_image']['tmp_name'];
    $error = $_FILES['my_image']['error'];
    $department_name = $_POST['name'];

    if ($error === 0) {
        if ($img_size > 125000) {
            $em = "Sorry, your file is too large.";
            header("Location: 01-Department-index.php?error=$em");
            exit();
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
            $allowed_exs = array("jpg", "jpeg", "png");

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $img_upload_path = 'Images-Department/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);

                // Update Database
                $update_query = "UPDATE departments SET DepartmentName = '$department_name', DepartmentLogo = '$new_img_name' WHERE DepartmentID = $id";
               $update_result = mysqli_query($conn, $update_query);
            } else {
                $em = "You can't upload files of this type";
                header("Location: 01-Department-index.php?error=$em");
                exit();
            }
            if($update_result)
            {
              header("Location:01-Department-index.php");
            }
        }
    } else {
        $em = "Unknown error occurred!";
        header("Location: 01-Department-index.php?error=$em");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Department</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <form action="#" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="exampleInputPassword1">Department Name</label>
            <input type="text" class="form-control" name="name" id="exampleInputPassword1" placeholder="department name" value="<?php echo $name; ?>">
        </div>
        <div class="row mb-3">
            <label for="file" class="col-sm-2 col-form-label">Logo</label> <br>
            <div class="col-sm-10">
                <input type="file" name="my_image">
            </div>
        </div>

        <button type="submit" name="Update_btn" class="btn btn-primary">Submit</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
