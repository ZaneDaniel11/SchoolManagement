

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Admin Login</h1>

        <?php
        // Display error message if login is unsuccessful
        if (isset($error_message)) {
            echo '<p class="error-message">' . $error_message . '</p>';
        }
        ?>

        <form  method="post">
            <label for="admin_username">Username:</label>
            <input type="text" id="admin_username" name="admin_username" required>

            <label for="admin_password">Password:</label>
            <input type="password" id="admin_password" name="admin_password" required>

            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>

</html>
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
        header("Location:Department.php");
        exit();
    } else {
        // Authentication failed, display an error message or redirect to the login page
        $error_message = "Invalid admin credentials";
    }
}

$conn->close();
?>