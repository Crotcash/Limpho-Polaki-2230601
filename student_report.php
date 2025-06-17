<?php
$conn = new mysqli("localhost", "root", "", "maluti_school");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student = null;
$results = [];
$report_generated = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];

    $stmt = $conn->prepare("SELECT id, full_name FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $student_result = $stmt->get_result();
    $student = $student_result->fetch_assoc();
    $stmt->close();

    if ($student) {
        $stmt = $conn->prepare("SELECT subject, term1, term2, term3, term4 FROM exam_results WHERE student_id = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $results = $stmt->get_result();
        $report_generated = true;
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Generate Student Report</title>
    <link rel="stylesheet" href="report.css">
</head>
<body>
<div class="container">
    <h2>Generate Student Report</h2>

    <form method="POST">
        <label>Enter Student ID:</label>
        <input type="number" name="student_id" required><br><br>
        <button type="submit">Generate Report</button><br><br>
		
		<button type="submit"><a href="teacher_dashboard.html">Back</a></button>
    </form>

    <?php if ($report_generated): ?>
        <?php if ($student): ?>
            <div class="report-box">
                <h3>Report for <?= htmlspecialchars($student['full_name']) ?> (ID: <?= $student['id'] ?>)</h3>

                <?php if ($results->num_rows > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Term 1</th>
                                <th>Term 2</th>
                                <th>Term 3</th>
                                <th>Term 4</th>
                                <th>Average</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $results->fetch_assoc()):
                                $average = ($row['term1'] + $row['term2'] + $row['term3'] + $row['term4']) / 4;
                                $status = $average >= 50 ? "Pass" : "Fail";
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($row['subject']) ?></td>
                                <td><?= $row['term1'] ?></td>
                                <td><?= $row['term2'] ?></td>
                                <td><?= $row['term3'] ?></td>
                                <td><?= $row['term4'] ?></td>
                                <td><?= number_format($average, 2) ?></td>
                                <td class="<?= $status == 'Pass' ? 'pass' : 'fail' ?>"><?= $status ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="warning">No exam results found for this student.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p class="error">Student not found.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>
</body>
</html>


