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

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $studentName = $_POST['studentName'];
    $entryDate = $_POST['entryDate'];
    $feesPaid = $_POST['feesPaid'];

    // Insert data into the database
    $sql = "INSERT INTO fees_entry (student_name, entry_date, fees_paid) 
            VALUES ('$studentName', '$entryDate', '$feesPaid')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: TFees_confirmation.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

