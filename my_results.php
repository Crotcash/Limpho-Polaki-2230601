<?php
session_start();

// Redirect if not logged in or not a student
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "student") {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "maluti_school");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION["user_id"];

// Get student internal ID and full name
$stmt = $conn->prepare("SELECT id, full_name FROM students WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    echo "<p>Student record not found.</p>";
    exit();
}

$student_id = $student["id"];
$student_name = $student["full_name"];

// Fetch exam results
$sql = "SELECT subject, term1, term2, term3, term4 
        FROM Exam_Results 
        WHERE student_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $student_id);
$stmt->execute();
$results = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Exam Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e6f2ff;;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background: #e6f2ff;;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        table th, table td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }

        table th {
            background-color: #004080;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .status-passed {
            color: green;
            font-weight: bold;
        }

        .status-failed {
            color: red;
            font-weight: bold;
        }

        p {
            text-align: center;
            color: #666;
        }
		button {
  width: 100%;
  padding: 12px;
  border: none;
  background-color: #3498db;
  color: white;
  font-weight: bold;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #2980b9;
}

    </style>
</head>
<body>

<div class="container">
    <h2>Exam Report for: <?php echo htmlspecialchars($student_name); ?></h2>

    <?php if ($results->num_rows > 0): ?>
        <table>
            <tr>
                <th>Subject</th>
                <th>Term 1</th>
                <th>Term 2</th>
                <th>Term 3</th>
                <th>Term 4</th>
                <th>Average</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $results->fetch_assoc()): 
                $avg = round(($row['term1'] + $row['term2'] + $row['term3'] + $row['term4']) / 4, 2);
                $status = ($avg >= 50) ? "Passed" : "Failed";
            ?>
                <tr>
                    <td><?= htmlspecialchars($row['subject']) ?></td>
                    <td><?= $row['term1'] ?></td>
                    <td><?= $row['term2'] ?></td>
                    <td><?= $row['term3'] ?></td>
                    <td><?= $row['term4'] ?></td>
                    <td><?= $avg ?></td>
                    <td class="<?= $status === 'Passed' ? 'status-passed' : 'status-failed' ?>"><?= $status ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No exam results found.</p>
    <?php endif; ?>
</div>
<button type="submit"><a href="students_dashboard.html">Back</a></button>

</body>
</html>
