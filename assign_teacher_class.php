<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "maluti_school");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Assign multiple classes to a teacher
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['assign'])) {
    $teacher_id = $_POST['teacher_id'];
    $class_ids = $_POST['class_ids'] ?? [];

    foreach ($class_ids as $class_id) {
        // Check if already assigned
        $check = $conn->prepare("SELECT * FROM teacher_classes WHERE teacher_id = ? AND class_id = ?");
        $check->bind_param("ii", $teacher_id, $class_id);
        $check->execute();
        $result = $check->get_result();
        if ($result->num_rows === 0) {
            $stmt = $conn->prepare("INSERT INTO teacher_classes (teacher_id, class_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $teacher_id, $class_id);
            $stmt->execute();
            $stmt->close();
        }
        $check->close();
    }
    $message = "Class(es) assigned successfully.";
}

// Unassign a class
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['unassign_id'])) {
    $unassign_id = $_POST['unassign_id'];
    $stmt = $conn->prepare("DELETE FROM teacher_classes WHERE id = ?");
    $stmt->bind_param("i", $unassign_id);
    if ($stmt->execute()) {
        $message = "Unassigned successfully.";
    } else {
        $message = "Failed to unassign.";
    }
    $stmt->close();
}

// Get teachers and classes for dropdown
$teachers = $conn->query("SELECT * FROM teachers");
$classes = $conn->query("SELECT * FROM classes");

// Fetch assignments
$assigned_classes = $conn->query("
    SELECT tc.id, t.full_name AS teacher_name, c.class_name 
    FROM teacher_classes tc
    JOIN teachers t ON tc.teacher_id = t.id
    JOIN classes c ON tc.class_id = c.id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Classes to Teacher</title>
	<link rel="stylesheet" href="assign_teacher_class.css">
</head>
<body>
<div class="container">

<h2>Assign Multiple Classes to Teacher</h2>

<form method="POST">
    <label>Select Teacher:</label>
    <select name="teacher_id" required>
        <option value="">--Select Teacher--</option>
        <?php while ($teacher = $teachers->fetch_assoc()): ?>
            <option value="<?= $teacher['id'] ?>"><?= $teacher['full_name'] ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Select Classes (hold Ctrl to select multiple):</label><br>
    <select name="class_ids[]" multiple size="5" required>
        <?php
        $classes->data_seek(0); 
        while ($class = $classes->fetch_assoc()): ?>
            <option value="<?= $class['id'] ?>"><?= $class['class_name'] ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <button type="submit" name="assign">Assign Classes</button>
</form>

<p style="color: green;"><?= $message ?></p>

<hr>

<h2>Assigned Classes</h2>
<table border="1" cellpadding="6">
    <tr>
        <th>Teacher</th>
        <th>Class</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $assigned_classes->fetch_assoc()): ?>
        <tr>
            <td><?= $row['teacher_name'] ?></td>
            <td><?= $row['class_name'] ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="unassign_id" value="<?= $row['id'] ?>">
                    <button type="submit">Unassign</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table><br><br>
<button type="submit"><a href="student_management.html">Back</a></button>
</div>
</body>
</html>
