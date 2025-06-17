<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "maluti_school");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Record fee payment
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['record_payment'])) {
    $student_id = $_POST['student_id'];
    $amount_paid = $_POST['amount_paid'];
    $term = $_POST['term'];
    $year = $_POST['year'];

    $stmt = $conn->prepare("INSERT INTO fee_payments (student_id, amount_paid, payment_date, term, year)
                            VALUES (?, ?, CURDATE(), ?, ?)");
    $stmt->bind_param("idsi", $student_id, $amount_paid, $term, $year);

    if ($stmt->execute()) {
        $message = "Payment recorded successfully.";
    } else {
        $message = "Error recording payment: " . $stmt->error;
    }

    $stmt->close();
}

// View fee summary
$summary = null;
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['view_summary'])) {
    $student_id = $_POST['view_student_id'];

    // Total Due
    $stmt_due = $conn->prepare("SELECT COALESCE(SUM(total_fee), 0) AS total_due FROM fee_structure WHERE student_id = ?");
    $stmt_due->bind_param("i", $student_id);
    $stmt_due->execute();
    $result_due = $stmt_due->get_result()->fetch_assoc();
    $stmt_due->close();

    // Total Paid
    $stmt_paid = $conn->prepare("SELECT COALESCE(SUM(amount_paid), 0) AS total_paid FROM fee_payments WHERE student_id = ?");
    $stmt_paid->bind_param("i", $student_id);
    $stmt_paid->execute();
    $result_paid = $stmt_paid->get_result()->fetch_assoc();
    $stmt_paid->close();

    $balance = $result_due['total_due'] - $result_paid['total_paid'];
    $summary = [
        'student_id' => $student_id,
        'total_due' => $result_due['total_due'],
        'total_paid' => $result_paid['total_paid'],
        'balance' => $balance
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fee Management</title>
	<link rel="stylesheet" href="fee_management.css">
</head>
<body>
<div class="container">

<h2>Fee Management System</h2>

<!-- Record Fee Payment Form -->
<h3>Record Fee Payment</h3>
<?php if (!empty($message)) echo "<p class='success-message'>$message</p>"; ?>
<form method="POST">
    <input type="hidden" name="record_payment" value="1">

    <label for="student_id">Student ID:</label>
    <input type="number" name="student_id" required>

    <label for="amount_paid">Amount Paid:</label>
    <input type="number" step="0.01" name="amount_paid" required>

    <label for="term">Term:</label>
    <input type="text" name="term" required>

    <label for="year">Year:</label>
    <input type="number" name="year" required>

    <button type="submit">Record Payment</button>
</form>

<hr>

<!-- View Fee Summary -->
<h3>View Fee Summary</h3>
<form method="POST">
    <input type="hidden" name="view_summary" value="1">

    <label for="view_student_id">Student ID:</label>
    <input type="number" name="view_student_id" required>

    <button type="submit">View Summary</button>
</form>

<?php if ($summary): ?>
    <h4>Summary for Student ID: <?= $summary['student_id'] ?></h4>
    <ul>
        <li>Total Due: <?= number_format($summary['total_due'], 2) ?></li>
        <li>Total Paid: <?= number_format($summary['total_paid'], 2) ?></li>
        <li><strong>Balance: <?= number_format($summary['balance'], 2) ?></strong></li>
    </ul>
<?php endif; ?>

<button type="submit"><a href="admin_dashboard.html">Back</a></button>

</div>
</body>
</html>
