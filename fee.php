<?php
session_start();

// Ensure only logged-in students can access
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "student") {
    header("Location: login.html");
    exit();
}

// Connect to the database
$conn = new mysqli("localhost", "root", "", "maluti_school");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION["user_id"];

// Fetch student ID and full name
$stmt = $conn->prepare("SELECT id, full_name FROM students WHERE user_id = ?");
if (!$stmt) {
    die("Prepare failed for students: " . $conn->error);
}
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

// Fetch total fee due
$due_stmt = $conn->prepare("SELECT SUM(total_fee) AS total_fee FROM fee_structure WHERE student_id = ?");
if (!$due_stmt) {
    die("Prepare failed for fee_structure: " . $conn->error);
}
$due_stmt->bind_param("i", $student_id);
$due_stmt->execute();
$due_result = $due_stmt->get_result();
$fee_structure = $due_result->fetch_assoc();
$total_due = $fee_structure ? $fee_structure['total_fee'] : 0.00;

// Fetch total paid using correct column: amount_paid
$paid_stmt = $conn->prepare("SELECT SUM(amount_paid) AS total_paid FROM fee_payments WHERE student_id = ?");
if (!$paid_stmt) {
    die("Prepare failed for fee_payments: " . $conn->error);
}
$paid_stmt->bind_param("i", $student_id);
$paid_stmt->execute();
$paid_result = $paid_stmt->get_result();
$payment_data = $paid_result->fetch_assoc();
$total_paid = $payment_data['total_paid'] ?? 0.00;

// Calculate balance
$balance = $total_due - $total_paid;
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Fee Status</title>
	<link rel="stylesheet" href="fee.css">
</head>
<body>

<h2>Fee Status for <?php echo htmlspecialchars($student_name); ?></h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Total Due</th>
        <th>Total Paid</th>
        <th>Balance</th>
    </tr>
    <tr>
        <td>R <?php echo number_format($total_due, 2); ?></td>
        <td>R <?php echo number_format($total_paid, 2); ?></td>
        <td>R <?php echo number_format($balance, 2); ?></td>
    </tr>
</table>

<?php if ($balance <= 0): ?>
    <p style="color: green;"><strong>All fees paid.</strong></p>
<?php else: ?>
    <p style="color: red;"><strong>Outstanding balance: R <?php echo number_format($balance, 2); ?></strong></p>
<?php endif; ?>

</body>
</html>
