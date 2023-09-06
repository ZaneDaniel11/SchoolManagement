<?php

$host = 'localhost';
$dbname = 'school_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $courseName = $_POST['course_name'];

    try {
        // Prepare the SQL statement
        $insertQuery = "INSERT INTO courses (CourseName) VALUES (:courseName)";
        $statement = $pdo->prepare($insertQuery);

        // Bind parameters
        $statement->bindParam(':courseName', $courseName, PDO::PARAM_STR);

        // Execute the query
        $statement->execute();

        // Redirect to a success page or display a success message
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        // Handle any errors during the insert process
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect if the form is not submitted via POST
    header("Location:  index.php");
    exit();
}


?>
