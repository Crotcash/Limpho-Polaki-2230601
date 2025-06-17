<?php
$conn = new mysqli("localhost", "root", "", "maluti_school");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student = null;
$payments = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = $_POST['student_id'];

    $stmt = $conn->prepare("SELECT full_name FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $student_result = $stmt->get_result();
    $student = $student_result->fetch_assoc();

    $stmt = $conn->prepare("SELECT * FROM fee_payments WHERE student_id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $payments = $stmt->get_result();
}
?>

<h2>View Student Fee Payments</h2>

<form method="POST">
    <label>Enter Student ID:</label>
    <input type="number" name="student_id" required>
    <button type="submit">View Payments</button>
</form>

<?php if ($student): ?>
    <h3>Payments for <?= htmlspecialchars($student['full_name']) ?></h3>
    <?php if ($payments->num_rows > 0): ?>
        <table border="1" cellpadding="5">
            <tr>
                <th>Date Paid</th>
                <th>Amount</th>
                <th>Description</th>
            </tr>
            <?php while ($row = $payments->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['date_paid'] ?></td>
                    <td>R<?= number_format($row['amount'], 2) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No payments recorded for this student.</p>
    <?php endif; ?>
<?php endif; ?>
