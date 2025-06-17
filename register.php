<?php
// DB CONNECTION (contents of includes/db.php)
$conn = new mysqli("localhost", "root", "", "maluti_school");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);
    if ($stmt->execute()) {
        echo "<script>alert('Registered successfully'); window.location='login.html';</script>";
    } else {
        echo "<script>alert('Registration failed'); window.location='register.html';</script>";
    }
}
?>
