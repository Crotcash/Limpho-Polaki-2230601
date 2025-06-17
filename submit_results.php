<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "maluti_school");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $class_id = $_POST['class_id'];
    $subject = $_POST['subject'];
    $student_ids = $_POST['student_ids'];
    $term1 = $_POST['term1'];
    $term2 = $_POST['term2'];
    $term3 = $_POST['term3'];
    $term4 = $_POST['term4'];

    $stmt = $conn->prepare("INSERT INTO exam_results (student_id, class_id, subject, term1, term2, term3, term4)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("<div class='message error'>Prepare failed: " . $conn->error . "</div>");
    }

    $successCount = 0;
    for ($i = 0; $i < count($student_ids); $i++) {
        $stmt->bind_param(
            "iisdddd",
            $student_ids[$i],
            $class_id,
            $subject,
            $term1[$i],
            $term2[$i],
            $term3[$i],
            $term4[$i]
        );

        if ($stmt->execute()) {
            $successCount++;
        }
    }

    $stmt->close();
    $conn->close();

    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <title>Results Submission</title>
        <link rel='stylesheet' href='submit_results.css'>
    </head>
    <body>
        <div class='container'>
            <div class='message success'>
                <p>$successCount student result(s) submitted successfully.</p>
            </div>
            <a class='back-btn' href='results.php'>Back</a>
        </div>
    </body>
    </html>";
} else {
    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <title>Error</title>
        <link rel='stylesheet' href='submit_results.css'>
    </head>
    <body>
        <div class='container'>
            <div class='message error'>
                <p>No data submitted.</p>
            </div>
            <a class='back-btn' href='results.php'>Back</a>
        </div>
    </body>
    </html>";
}
?>

