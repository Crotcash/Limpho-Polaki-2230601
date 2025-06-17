<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "maluti_school");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student = null;
$message = "";

// Search for student
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['search'])) {
    $student_id = $_POST['student_id'];

    $sql = "SELECT students.*, users.username, users.password 
            FROM students 
            JOIN users ON students.user_id = users.id 
            WHERE students.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();
}

// Update academic details
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
    $student_id = $_POST['student_id'];
    $user_id = $_POST['user_id'];
    $class_id = $_POST['class_id'];
    $parent_id = $_POST['parent_id'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Update students table
    $stmt1 = $conn->prepare("UPDATE students SET class_id=?, parent_id=?, dob=?, gender=?, address=?, full_name=? WHERE id=?");
    $stmt1->bind_param("iissssi", $class_id, $parent_id, $dob, $gender, $address, $full_name, $student_id);

    // Update users table
    $stmt2 = $conn->prepare("UPDATE users SET username=?, password=? WHERE id=?");
    $stmt2->bind_param("ssi", $username, $password, $user_id);

    if ($stmt1->execute() && $stmt2->execute()) {
        $message = "Academic details updated successfully!";
    } else {
        $message = "Failed to update academic details.";
    }

    $stmt1->close();
    $stmt2->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Academic Details</title>
	<link rel="stylesheet" href="update_academic_details.css">
</head>
<body>
<div class="container">

<h2>Update Academic Details</h2>

<form method="POST">
    <label>Enter Student ID:</label>
    <input type="number" name="student_id" required>
    <button type="submit" name="search">Search</button>
	<button type="submit"><a href="student_management.html">Back</a></button>
</form>

<?php if ($student): ?>
    <form method="POST">
        <input type="hidden" name="student_id" value="<?= $student['id'] ?>">
        <input type="hidden" name="user_id" value="<?= $student['user_id'] ?>">

        <h3>Academic Info</h3>

        <label>Username:</label>
        <input type="text" name="username" value="<?= $student['username'] ?>">

        <label>Password:</label>
        <input type="text" name="password" value="<?= $student['password'] ?>">

        <label>Class ID:</label>
        <input type="number" name="class_id" value="<?= $student['class_id'] ?>">

        <label>Parent ID:</label>
        <input type="number" name="parent_id" value="<?= $student['parent_id'] ?>">

        <label>Date of Birth:</label>
        <input type="date" name="dob" value="<?= $student['dob'] ?>">

        <label>Gender:</label>
        <input type="text" name="gender" value="<?= $student['gender'] ?>">

        <label>Address:</label>
        <input type="text" name="address" value="<?= $student['address'] ?>">

        <label>Full Name:</label>
        <input type="text" name="full_name" value="<?= $student['full_name'] ?>">

        <button type="submit" name="update">Update Details</button>
    </form>
<?php elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['search'])): ?>
    <p class="error">Student not found.</p>
<?php endif; ?>

<?php if ($message): ?>
    <p class="info"><?= $message ?></p>
<?php endif; ?>

</div>
</body>

</html>

