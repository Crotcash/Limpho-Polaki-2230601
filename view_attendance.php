<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "maluti_school");
if ($conn->connect_error) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT a.id, a.date, a.status, a.class_id, s.id AS student_id, s.full_name 
        FROM attendance a
        JOIN students s ON a.student_id = s.id
        ORDER BY a.date DESC";

$result = $conn->query($sql);

$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode($rows);
?>
