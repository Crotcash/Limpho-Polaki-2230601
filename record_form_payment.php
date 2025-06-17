<?php
$conn = new mysqli("localhost", "root", "", "maluti_school");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$students = [];
$result = $conn->query("SELECT id, full_name FROM students");
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = $_POST['student_id'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $date_paid = date('Y-m-d');

    $stmt = $conn->prepare("INSERT INTO fee_payments (student_id, amount, date_paid, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("idss", $student_id, $amount, $date_paid, $description);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<p style='color:green;'>Payment recorded successfully.</p>";
    } else {
        echo "<p style='color:red;'>Failed to record payment.</p>";
    }

    $stmt->close();
}
?>

<h2>Record Fee Payment</h2>
<form method="POST">
    <label>Student:
        <select name="student_id" required>
            <option value="">-- Select Student --</option>
            <?php foreach ($students as $s): ?>
                <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['full_name']) ?></option>
            <?php endforeach; ?>
        </select>
    </label><br><br>

    <label>Amount Paid: <input type="number" name="amount" required></label><br><br>
    <label>Description: <input type="text" name="description"></label><br><br>

    <button type="submit">Submit Payment</button>
</form>
