<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "maluti_school";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Only run this after form is submitted
    $student_id = $_POST['id'];
    $user_id = $_POST['user_id'];
    $class_id = $_POST['class_id'];
    $parent_id = $_POST['parent_id'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $role = 'student';

    $conn->begin_transaction();

    try {
        // Insert into users table
        $sqlUser = "INSERT INTO users (id, username, password, role, created_at)
                    VALUES (?, ?, ?, ?, NOW())";
        $stmtUser = $conn->prepare($sqlUser);
        $stmtUser->bind_param("isss", $user_id, $username, $password, $role);
        $stmtUser->execute();

        // Insert into students table
        $sqlStudent = "INSERT INTO students (id, user_id, class_id, parent_id, dob, gender, address, full_name)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtStudent = $conn->prepare($sqlStudent);
        $stmtStudent->bind_param("iiiissss", $student_id, $user_id, $class_id, $parent_id, $dob, $gender, $address, $full_name);
        $stmtStudent->execute();

        $conn->commit();
        echo "Student added successfully.";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    $stmtUser->close();
    $stmtStudent->close();
    $conn->close();
}
?>

