<?php
$conn = new mysqli("localhost", "root", "", "maluti_school");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo '<!DOCTYPE html>
<html>
<head>
  <title>Send Message Confirmation</title>
  <link rel="stylesheet" href="send_message.css">
</head>
<body>
  <div class="container">';
  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $parent_ids = $_POST['parent_ids'];

    if (in_array('all', $parent_ids)) {
        $result = $conn->query("SELECT id FROM parents");
        $parent_ids = [];
        while ($row = $result->fetch_assoc()) {
            $parent_ids[] = $row['id'];
        }
    }

    $stmt = $conn->prepare("INSERT INTO messages (subject, message) VALUES (?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("ss", $subject, $message);
    $stmt->execute();
    $message_id = $stmt->insert_id;

    $stmt = $conn->prepare("INSERT INTO message_recipients (message_id, parent_id) VALUES (?, ?)");
    if ($stmt === false) {
        die("Error preparing statement for message recipients: " . $conn->error);
    }

    foreach ($parent_ids as $pid) {
        $stmt->bind_param("ii", $message_id, $pid);
        if (!$stmt->execute()) {
            die("Error executing statement: " . $stmt->error);
        }
    }

    echo "<h2>Message Sent Successfully!</h2>";
    echo "<p>The message has been delivered to the following parent(s):</p>";
    echo "<ul class='recipient-list'>";

    $stmt = $conn->prepare("SELECT full_name FROM parents WHERE id IN (" . implode(',', $parent_ids) . ")");
    if ($stmt === false) {
        die("Error preparing statement for parent names: " . $conn->error);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . htmlspecialchars($row['full_name']) . "</li>";
    }
    echo "</ul>";

    echo '<br><a href="send_message.html" class="btn">Send Another Message</a>';
} else {
    echo "<p><strong>Error:</strong> No data submitted.</p>";
}

echo '</div></body></html>';
?>


