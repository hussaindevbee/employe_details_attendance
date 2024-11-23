<?php
// Database connection
$con = new mysqli("localhost", "root", "", "dummy");

// Check if the connection was successful
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Get the current date
$current_date = date("Y-m-d");

// Get data from the database with LEFT JOIN
$sql = "
    SELECT 
        Employee_details.EmployeeId, 
        Employee_details.Name, 
        Employee_details.Phone, 
        Attendance_list.attendance, 
        Attendance_list.date_present
    FROM 
        Employee_details
    LEFT JOIN 
        Attendance_list 
    ON 
        Employee_details.EmployeeId = Attendance_list.employee_id 
    AND 
        Attendance_list.date_present = '$current_date'
";
$result = $con->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Prevent duplicate attendance for the same date
    $get_attendance_sql = "SELECT * FROM attendance_list WHERE date_present = '$current_date'";
    $attendance_data = $con->query($get_attendance_sql);

    if ($attendance_data->num_rows > 0) {
        echo "<h2 style='color:red'>Attendance already entered</h2>";
    } else {
        // Process submitted attendance data
        $attendance = $_POST['attendance'];
        $stmt = $con->prepare("INSERT INTO Attendance_list (employee_id, attendance, date_present) VALUES (?, ?, ?)");

        foreach ($attendance as $employee_id => $attend_status) {
            $stmt->bind_param("iss", $employee_id, $attend_status, $current_date);
            $stmt->execute();
        }
        $stmt->close();
        echo "<h2 style='color:green'>Attendance data has been successfully stored!</h2>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Attendance</title>
    <style>
        table {
            font-family: Arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
    <h1>Employee Attendance</h1>

    <form action="" method="POST">
        <table>
            <?php
            if ($result->num_rows > 0) {
                // Table headers
                echo "<tr>
                        <th>S.NO</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Attendance</th>
                        <th>Attendance status</th>
                      </tr>";

                // Display each row with existing attendance or option to mark attendance
                $sno = 1;
                while ($row = $result->fetch_assoc()) {
                    $attendance_status = $row['attendance'] ? $row['attendance'] : "Fill the attendance";
                    echo "<tr>
                            <td>" . $sno++ . "</td>
                            <td>" . $row['Name'] . "</td>
                            <td>" . $row['Phone'] . "</td>
                            <td>" . ($row['date_present'] ? $row['date_present'] : $current_date) . "</td>
                            <td>" . $attendance_status . "</td>
                            <td>";
                    if ($row['attendance']) {
                        echo "Already filled attendance";
                    } else {
                        echo "
                            <label>
                                <input type='radio' name='attendance[" . $row['EmployeeId'] . "]' value='Present' required checked> Present
                            </label>
                            <label>
                                <input type='radio' name='attendance[" . $row['EmployeeId'] . "]' value='Absent' required> Absent
                            </label>";
                    }
                    echo "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No records found.</td></tr>";
            }
            ?>
        </table>
        <button type="submit">Submit Attendance</button>
    </form>
</body>
</html>

<?php
$con->close();
?>
