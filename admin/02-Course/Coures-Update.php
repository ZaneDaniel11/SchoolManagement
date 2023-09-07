<?php
include('../Public/Connection.php');

// Check if the 'update_id' parameter is set
if (isset($_GET['update_id'])) {
    $id = $_GET['update_id'];

    // Select the course data for the specified ID
    $selectQuery = "SELECT * FROM courses WHERE CourseID = :id";
    $stmt = $conn->prepare($selectQuery);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $id = $row['CourseID'];
    $name = $row['CourseName'];

    // Close the PDO statement
    $stmt = null;
} else {
    // 'update_id' parameter is not set
    header("Location: Index.php?error=Invalid request");
    exit();
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

    <form method="post">
        <input type="text" name="course_id" value="<?php echo $id; ?>" readonly>
        <div class="form-group">
            <label for="exampleInputPassword1">Course Name</label>
            <input type="text" class="form-control" name="new_course_name" id="exampleInputPassword1" placeholder="course name" value="<?php echo $name; ?>">
        </div>

        <button type="submit" name="Update_btn" class="btn btn-primary">Submit</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>

<?php
// Check if the form is submitted
if (isset($_POST['Update_btn'])) {
    $id = $_POST['course_id'];
    $name = $_POST['new_course_name'];

    try {
        // Update the course data using a prepared statement
        $updateQuery = "UPDATE courses SET CourseName = :name WHERE CourseID = :id";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Redirect to the page where you list courses
        header('Location: Index.php');
        exit();
    } catch (PDOException $e) {
        // Error in update
        echo "Error updating record: " . $e->getMessage();
    } finally {
        // Close the PDO statement
        $stmt = null;
    }
}
?>
