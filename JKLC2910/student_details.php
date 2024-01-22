<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        canvas {
            margin-top: 20px;
        }
    </style>
</head>
<body>

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


if (isset($_GET['student'])) {
    $studentID = $_GET['student'];
    // Fetch student details from sregister table

    $studentDetailsQuery = "SELECT * FROM sregister WHERE id = '$studentID'";
   # $studentName = "SELECT student_name FROM sregister WHERE id= '$studentID'";
    $studentDetailsResult = $conn->query($studentDetailsQuery);

    if ($studentDetailsResult->num_rows > 0) {
        $studentDetails = $studentDetailsResult->fetch_assoc();
        ?>

    
   
  <!-- Display student details -->
  <hr>
  <center><h3>Student Details</h3></center>
  <hr>
  <br>
        <table>
             <tr>
                <th>Student ID</th>
                <td><?php echo $studentDetails['id']; ?></td>
            </tr>
            <tr>
                <th>Student Name</th>
                <td><?php echo $studentDetails['student_name']; ?></td>
            </tr>
            <tr>
                <th>Primary Contact</th>
                <td><?php echo $studentDetails['pcontact']; ?></td>
            </tr>
            <tr>
                <th>Alternate Contact</th>
                <td><?php echo $studentDetails['altcontact']; ?></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td><?php echo $studentDetails['gender']; ?></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><?php echo $studentDetails['saddress']; ?></td>
            </tr>
            <tr>
                <th>Class</th>
                <td><?php echo $studentDetails['class']; ?></td>
            </tr>
            <tr>
                <th>Branch</th>
                <td><?php echo $studentDetails['sbranch']; ?></td>
            </tr>
            <tr>
                <th>Email Address</th>
                <td><?php echo $studentDetails['semail']; ?></td>
            </tr>
        </table>
        <br><br><hr>
<?php
    }
    else{
        echo '<p>No student details found.</p>';
    }
} else {
    echo '<p>No student selected.</p>';
}



// Fetch test results from test_data table
$testResultsQuery = "SELECT * FROM test_data WHERE student_id = '$studentID'";
$testResultsResult = $conn->query($testResultsQuery);


if($testResultsResult->num_rows >0){

    ?>

    <!--Display Test Results -->
    <center><h3>Test Results</h3></center>
    <hr><br>
    <table>
        <tr>
            <th>Test Name</th>
            <th>Test Date</th>
            <th>Marks</th>
            <th>Total Marks</th>
        </tr>
        <?php while($row = $testResultsResult->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $row['test_name'];?></td>
            <td><?php echo $row['test_date'];?></td>
            <td><?php echo $row['marks'];?></td>
            <td><?php echo $row['total_marks'];?></td>
        </tr>
        <?php
        } ?>
    </table>
    <br><br><hr>
<?php
}
else{
    echo '<p>No test results found.</p>';
}
  

 // Fetch fees details from fees_entry table
 $feesDetailsQuery = "SELECT * FROM fees_entry WHERE student_id = '$studentID'";
 $feesDetailsResult = $conn->query($feesDetailsQuery);

 if ($feesDetailsResult->num_rows > 0) {
     ?>

        <!-- Display fees details -->
        <h3>Fees Details</h3>
        <table>
            <!-- Add rows for fees details -->
            <tr>
                <th>Entry ID</th>
                <th>Entry Date</th>
                <th>Fees Paid</th>
            </tr>

            <?php while ($row = $feesDetailsResult->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['entry_id']; ?></td>
                    <td><?php echo $row['entry_date']; ?></td>
                    <td><?php echo $row['fees_paid']; ?></td>
                </tr>
            <?php } ?>
        </table>

        <?php
    } else {
        echo '<p>No fees details found.</p>';
    }
$conn->close();
?>
</body>
</html>