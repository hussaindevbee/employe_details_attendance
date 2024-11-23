<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $con = mysqli_connect('localhost', 'root', '', 'dummy');
    
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
        exit();
    }

    $Delete = "DELETE FROM employee_details WHERE EmployeeId = $id";
    $result = mysqli_query($con, $Delete);
    
    if ($result) { 
        echo "Successfully deleted";
        header('location:index.php');
    } else {
        echo "Error while deleting records: " . mysqli_error($con);
    }
} else {
    echo "VALUES NOT COME";
}
?>


