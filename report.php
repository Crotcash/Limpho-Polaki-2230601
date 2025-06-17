<?php
$conn = new mysqli("localhost", "root", "", "maluti_school");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = $_POST['student_id'];
$term = $_POST['term'];
$year = $_POST['year'];

// Get student name
$student_query = $conn->query("SELECT full_name FROM students WHERE id = $student_id");
if ($student_query && $student_query->num_rows > 0) {
    $student = $student_query->fetch_assoc();
    echo "<h2>Report for " . $student['full_name'] . "</h2>";
} else {
    die("Student not found.");
}

echo "<p>Term: $term | Year: $year</p>";
echo "<h3>Exam Results</h3>";

$results = $conn->query("SELECT subject, score, total FROM exam_results WHERE student_id = $student_id AND term = '$term' AND year = $year");

if (!$results) {
    die("Query failed: " . $conn->error);
}

if ($results->num_rows > 0) {
    echo "<table border='1' cellpadding='5'>
            <tr>
              <th>Subject</th>
              <th>Score</th>
              <th>Total</th>
            </tr>";
    while ($row = $results->fetch_assoc()) {
        echo "<tr>
                <td>{$row['subject']}</td>
                <td>{$row['score']}</td>
                <td>{$row['total']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No exam results found for this student in Term $term, $year.</p>";
}
?>

