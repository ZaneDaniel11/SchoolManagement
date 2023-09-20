<?php
session_start();

// Replace these with your actual database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['login'])) {
    $admin_username = $_POST['admin_username'];
    $admin_password = $_POST['admin_password'];

    // Perform a simple query to check if the admin exists
    $query = "SELECT * FROM `admin` WHERE admin_username = '$admin_username' AND admin_password = '$admin_password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Admin is authenticated, set session variables
        $_SESSION['admin_username'] = $admin_username;
        header("Location:../01-Department/Department-index.php");
        exit();
    } else {
        // Authentication failed, display an error message
        header("Login.php");
    }
}

$conn->close();
?>
