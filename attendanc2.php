<?php
$conn = new mysqli("localhost", "root", "", "maluti_school");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo '<!DOCTYPE html>
<html>
<head>
  <title>Attendance Submitted</title>
  <link rel="stylesheet" href="attendance_result.css">
</head>
<body>
<div class="container">';

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['student_ids']) &&
    isset($_POST['statuses']) &&
    isset($_POST['class_id']) &&
    isset($_POST['date'])) {

    $student_ids = $_POST['student_ids'];
    $statuses    = $_POST['statuses'];
    $class_id    = $_POST['class_id'];
    $date        = $_POST['date'];

    $insertedRecords = [];

    for ($i = 0; $i < count($student_ids); $i++) {
        $sid = $student_ids[$i];
        $status = $statuses[$i];

        // Insert attendance
        $stmt = $conn->prepare("INSERT INTO attendance (student_id, class_id, date, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $sid, $class_id, $date, $status);
        $stmt->execute();

        // Get student full name
        $stmt2 = $conn->prepare("SELECT full_name FROM students WHERE user_id = ?");
        $stmt2->bind_param("i", $sid);
        $stmt2->execute();
        $result = $stmt2->get_result();
        $row = $result->fetch_assoc();

        $insertedRecords[] = [
            'student_id' => $sid,
            'full_name' => $row ? $row['full_name'] : 'Unknown',
            'class_id' => $class_id,
            'date' => $date,
            'status' => $status
        ];
    }

    // Display records
    echo "<h3>Attendance Successfully Marked</h3>";
    echo "<table>
            <tr>
              <th>Student ID</th>
              <th>Name</th>
              <th>Class ID</th>
              <th>Date</th>
              <th>Status</th>
            </tr>";
    foreach ($insertedRecords as $record) {
        echo "<tr>
                <td>{$record['student_id']}</td>
                <td>{$record['full_name']}</td>
                <td>{$record['class_id']}</td>
                <td>{$record['date']}</td>
                <td>{$record['status']}</td>
              </tr>";
    }
    echo "</table>
          <a href='attendance.html'>Back to Attendance Form</a>
          <br><br>
          <a href='teacher_dashboard.html'>Go to Dashboard</a>";

} else {
    echo "<p><b>Error:</b> Attendance form not submitted properly.</p>
          <a href='students_dashboard.html'>Back</a>";
}

echo '</div></body></html>';
?>







