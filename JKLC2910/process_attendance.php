<?php
$servername = "localhost";  // Change to your database server
$username = "root";     // Change to your database username
$password = "";     // Change to your database password
$database = "jklc"; // Change to your database name

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the list of students from the database
$sql = "SELECT student_name FROM sregister"; // Modify the query according to your database structure
$result = $conn->query($sql);

$students = array(); // Create an array to store student names

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row["student_name"];
    }
} else {
    echo "No students found in the database.";
}

// Process the form submission
if (isset($_POST['submit']) && isset($_POST['attendance']) && isset($_POST['date'])) {
    $attendanceDate = $_POST['date'];

    foreach ($_POST['attendance'] as $studentName => $status) {
        // Insert or update the attendance data in the database for the specified date
        $sql = "INSERT INTO student_attendance (student_name, attendance_date, status) 
                VALUES ('$studentName', '$attendanceDate', '$status') 
                ON DUPLICATE KEY UPDATE status = '$status'";
        $conn->query($sql);
    }

    // Redirect to a confirmation page or perform other actions as needed.
    header("Location: attendance_confirmation.html");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance</title>
</head>
<body>

<form method="post" action="">
    <label for="date">Select Date:</label>
    <input type="date" id="date" name="date">
    <table>
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($students as $studentName) {
                echo '<tr>';
                echo '<td>' . $studentName . '</td>';
                echo '<td>
                        <select name="attendance[' . $studentName . ']">
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                        </select>
                    </td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>

    <button type="submit" name="submit">Submit</button>
</form>

</body>
</html>

<?php
if ($conn) {
    $conn->close(); // Close the database connection
}
?>
