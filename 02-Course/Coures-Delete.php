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

if (isset($_GET['course_id'])) {
    $id = $_GET['course_id'];

    try {
        // Create a PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the delete query
        $deleteQuery = "DELETE FROM courses WHERE CourseID = :id";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Check if the deletion was successful
        if ($stmt->rowCount() > 0) {
            // Successful deletion
            header('Location: Index.php');
            exit();
        } else {
            // No records were affected, meaning the course with the given ID doesn't exist
            header('Location: Index.php?error=Course not found');
            exit();
        }
    } catch (PDOException $e) {
        // Error in deletion
        header('Location: Index.php?error=' . $e->getMessage());
        exit();
    } finally {
        // Close the PDO connection
        $conn = null;
    }
}
?>
