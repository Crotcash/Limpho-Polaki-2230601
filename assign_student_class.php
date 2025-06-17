<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "maluti_school");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize
$student = null;
$message = "";

// Handle search
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['search'])) {
    $student_id = $_POST['student_id'];
    $sql = "SELECT * FROM students WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();
}

// Handle assignment
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['assign'])) {
    $student_id = $_POST['student_id'];
    $class_id = $_POST['class_id'];

    // Check if the class exists
    $check = $conn->prepare("SELECT * FROM classes WHERE id = ?");
    $check->bind_param("i", $class_id);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        $update = $conn->prepare("UPDATE students SET class_id = ? WHERE id = ?");
        $update->bind_param("ii", $class_id, $student_id);
        if ($update->execute()) {
            $message = "Student assigned to class successfully!";
        } else {
            $message = "Failed to assign class.";
        }
        $update->close();
    } else {
        $message = "Class does not exist.";
    }
    $check->close();
}

// Get classes for dropdown
$classes = $conn->query("SELECT * FROM classes");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Student to Class</title>
	<link rel="stylesheet" href="assign_student_class.css">
</head>
<body>
<div class="container">

<h2>Assign Student to Class</h2>

<form method="POST">
    <label>Enter Student ID:</label>
    <input type="number" name="student_id" required>
    <button type="submit" name="search">Search</button>
	<button type="submit"><a href="student_management.html">Back</a></button>
</form>

<?php if ($student): ?>
    <h3>Student Details</h3>
    <p><strong>Full Name:</strong> <?= $student['full_name'] ?></p>
    <p><strong>Current Class ID:</strong> <?= $student['class_id'] ?></p>

    <form method="POST">
        <input type="hidden" name="student_id" value="<?= $student['id'] ?>">
        <label>Select Class:</label>
        <select name="class_id" required>
            <option value="">-- Select Class --</option>
            <?php while ($row = $classes->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['class_name'] ?></option>
            <?php endwhile; ?>
        </select>
        <br><br>
        <button type="submit" name="assign">Assign Class</button><br><br>
		<button type="submit"><a href="student_management.html">Back</a></button>
    </form>
<?php elseif (!empty($_POST['search'])): ?>
    <p style="color:red;">Student not found.</p>
<?php endif; ?>

<?php if ($message): ?>
    <p style="color:blue;"><?= $message ?></p>
<?php endif; ?>
</div>
</body>
</html>

