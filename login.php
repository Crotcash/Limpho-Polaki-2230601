<?php
session_start();

// Connect to the database
$conn = new mysqli("localhost", "root", "", "maluti_school");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($user = $result->fetch_assoc()) {
        // Set session variables
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user['id'];        
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        switch ($user['role']) {
            case 'admin':
                header("Location: admin_dashboard.html");
                break;
            case 'teacher':
                header("Location: teacher_dashboard.html");
                break;
            case 'student':
                header("Location: students_dashboard.html");
                break;
            case 'parent':
                header("Location: parent_dashboard.html");
                break;
            default:
                echo "<script>alert('Unknown role'); window.location='login.html';</script>";
        }
    } else {
        // Invalid login
        echo "<script>alert('Invalid username or password'); window.location='login.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>

