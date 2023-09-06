<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school_db";

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

if (isset($_POST['submit'])) {
    $department_name = $_POST['Department'];

    $img_name = $_FILES['my_image']['name'];
    $img_size = $_FILES['my_image']['size'];
    $tmp_name = $_FILES['my_image']['tmp_name'];
    $error = $_FILES['my_image']['error'];

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

                // Insert into Database
                $sql = "INSERT INTO departments(DepartmentName, DepartmentLogo) 
                        VALUES(:department_name, :department_logo)";
                
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':department_name', $department_name);
                $stmt->bindParam(':department_logo', $new_img_name);

                if ($stmt->execute()) {
                    header("Location: 01-Department-index.php");
                    exit();
                } else {
                    $em = "Failed to execute the SQL statement.";
                    header("Location: 01-Department-index.php?error=$em");
                    exit();
                }
            } else {
                $em = "You can't upload files of this type";
                header("Location: 01-Department-index.php?error=$em");
                exit();
            }
        }
    } else {
        $em = "Unknown error occurred!";
        header("Location: 01-Department-index.php?error=$em");
        exit();
    }
} else {
    header("Location: 01-Department-index.php");
    exit();
}
?>
