<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$servername = "localhost";
$username = "root";
$password = "Gauthu@2004"; 
$dbname = "payment_history"; 
if (isset($_POST['id']) && !empty($_POST['id'])) {
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   
    function sanitize($conn, $input) {
        return mysqli_real_escape_string($conn, $input);
    }

    
    $employeeId = sanitize($conn, $_POST['id']);

    
    $sql = "SELECT payslip_number, employee_id, employee_name, account_number, total_salary FROM payment_history WHERE employee_id = $employeeId";

    
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
           
            echo "<table>";
            echo "<thead><tr><th>Payslip Number</th><th>Employee ID</th><th>Employee Name</th><th>Account Number</th><th>Total Salary</th></tr></thead>";
            echo "<tbody>";

            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['payslip_number'] . "</td>";
                echo "<td>" . $row['employee_id'] . "</td>";
                echo "<td>" . $row['employee_name'] . "</td>";
                echo "<td>" . $row['account_number'] . "</td>";
                echo "<td>$" . $row['total_salary'] . "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "No payment history found for ID: $employeeId";
        }
    } else {
        echo "Error: " . $conn->error;
    }

    
    $conn->close();
} else {
    echo "Please provide an Employee ID to generate payment history.";
}
?>