<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "maluti_school");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$student = null;
$message = "";

// Search
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['search_id'])) {
    $search_id = $_POST['search_id'];

    $sql = "SELECT students.*, users.username, users.password 
            FROM students 
            JOIN users ON students.user_id = users.id 
            WHERE students.id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $search_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();
}

// Delete
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_id'])) {
    $student_id = $_POST['delete_id'];
    $user_id = $_POST['user_id'];

    // Delete from students table
    $stmt1 = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt1->bind_param("i", $student_id);
    $stmt1->execute();
    $stmt1->close();

    // Delete from users table
    $stmt2 = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt2->bind_param("i", $user_id);
    $stmt2->execute();
    $stmt2->close();

    $message = "Student deleted successfully.";
    $student = null;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Student</title>
    <link rel="stylesheet" href="delete_student.css">
</head>
<body>

<div class="container">
    <h2>Delete Student Record</h2>

    <form method="POST">
        <label>Enter Student ID:</label>
        <input type="number" name="search_id" required>
        <button type="submit">Search</button><br><br>
		<button type="submit"><a href="student_management.html">Back</a></button>
    </form>

    <?php if (!empty($student)): ?>
        <h3>Student Details</h3>
        <form method="POST">
            <input type="hidden" name="delete_id" value="<?= $student['id'] ?>">
            <input type="hidden" name="user_id" value="<?= $student['user_id'] ?>">

            Username: <?= htmlspecialchars($student['username']) ?><br>
            Full Name: <?= htmlspecialchars($student['full_name']) ?><br>
            Class ID: <?= $student['class_id'] ?><br>
            Parent ID: <?= $student['parent_id'] ?><br>
            Date of Birth: <?= $student['dob'] ?><br>
            Gender: <?= $student['gender'] ?><br>
            Address: <?= htmlspecialchars($student['address']) ?><br><br>

            <button type="submit">Delete Student</button><br><br>
			<button type="submit"><a href="student_management.html">Back</a></button>
        </form>
    <?php elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['search_id'])): ?>
        <p class="error">Student not found.</p>
    <?php endif; ?>

    <?php if (!empty($message)): ?>
        <p class="success"><?= $message ?></p>
    <?php endif; ?>
</div>

</body>
</html>

