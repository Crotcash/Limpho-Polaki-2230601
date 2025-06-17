<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "maluti_school");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student = null; // Fix: Declare $student to avoid undefined variable warning
$message = "";

// Handle update form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_student'])) {
    $student_id = $_POST['student_id'];
    $user_id    = $_POST['user_id'];
    $username   = $_POST['username'];
    $password   = $_POST['password']; 
    $class_id   = $_POST['class_id'];
    $parent_id  = $_POST['parent_id'];
    $dob        = $_POST['dob'];
    $gender     = $_POST['gender'];
    $address    = $_POST['address'];
    $full_name  = $_POST['full_name'];

    // Update users table
    $updateUser = $conn->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
    $updateUser->bind_param("ssi", $username, $password, $user_id);
    $userSuccess = $updateUser->execute();
    $updateUser->close();

    // Update students table
    $updateStudent = $conn->prepare("UPDATE students SET class_id = ?, parent_id = ?, dob = ?, gender = ?, address = ?, full_name = ? WHERE id = ?");
    $updateStudent->bind_param("iissssi", $class_id, $parent_id, $dob, $gender, $address, $full_name, $student_id);
    $studentSuccess = $updateStudent->execute();
    $updateStudent->close();

    if ($userSuccess && $studentSuccess) {
        $message = "<p style='color: green;'>Student updated successfully!</p>";
    } else {
        $message = "<p style='color: red;'>Error updating student record.</p>";
    }
}

// Handle student search
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Student</title>
	<link rel="stylesheet" href="update.css">
</head>
<body>

<h2>Search Student to Edit</h2>

<form method="POST">
    <label>Enter Student ID:</label>
    <input type="number" name="search_id" required>
    <button type="submit">Search</button><br><br>
	<button type="submit"><a href="student_management.html">Back</a></button>
</form>

<div class="message">
    <?php if (!empty($message)) echo $message; ?>
</div>

<?php if ($student): ?>
    <h3>Edit Student Details</h3>
    <form method="POST">
        <input type="hidden" name="student_id" value="<?= $student['id'] ?>">
        <input type="hidden" name="user_id" value="<?= $student['user_id'] ?>">
        <input type="hidden" name="update_student" value="1">

        <label>Username:</label>
        <input type="text" name="username" value="<?= htmlspecialchars($student['username']) ?>" required>

        <label>Password:</label>
        <input type="text" name="password" value="<?= htmlspecialchars($student['password']) ?>" required>

        <label>Class ID:</label>
        <input type="number" name="class_id" value="<?= $student['class_id'] ?>" required>

        <label>Parent ID:</label>
        <input type="number" name="parent_id" value="<?= $student['parent_id'] ?>" required>

        <label>Date of Birth:</label>
        <input type="date" name="dob" value="<?= $student['dob'] ?>" required>

        <label>Gender:</label>
        <input type="text" name="gender" value="<?= htmlspecialchars($student['gender']) ?>" required>

        <label>Address:</label>
        <input type="text" name="address" value="<?= htmlspecialchars($student['address']) ?>" required>

        <label>Full Name:</label>
        <input type="text" name="full_name" value="<?= htmlspecialchars($student['full_name']) ?>" required>

        <button type="submit">Update Student</button>
        <button class="back-button"><a href="student_management.html">Back</a></button>
    </form>
<?php elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['search_id'])): ?>
    <p style="color:red;">Student not found.</p>
<?php endif; ?>

</body>
</html>



