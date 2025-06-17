<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "maluti_school");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all students
$students = [];
$sql = "SELECT id, full_name FROM students";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Term Exam Results</title>
    <link rel="stylesheet" href="results.css">
</head>
<body>

<div class="container">
    <h2>Add Term Exam Results</h2>

    <form method="POST" action="submit_results.php" class="form-box">
        <label>Class ID:
            <input type="number" name="class_id" required>
        </label>

        <label>Subject:
            <input type="text" name="subject" required>
        </label>

        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Term 1</th>
                    <th>Term 2</th>
                    <th>Term 3</th>
                    <th>Term 4</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($student['full_name']); ?>
                            <input type="hidden" name="student_ids[]" value="<?php echo $student['id']; ?>">
                        </td>
                        <td><input type="number" name="term1[]" required></td>
                        <td><input type="number" name="term2[]" required></td>
                        <td><input type="number" name="term3[]" required></td>
                        <td><input type="number" name="term4[]" required></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button type="submit" class="submit-btn">Submit Results</button><br><br>
		<button type="submit"><a href="teacher_dashboard.html">Back</a><button>
    </form>
</div>

</body>
</html>




