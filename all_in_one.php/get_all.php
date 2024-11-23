<?php

if(isset($_REQUEST['id']) && $_REQUEST['id'] !=""){
    $id=$_REQUEST['id'];
    $sql="select * from employee_details where employeeid=$id";
}else{
    $sql="select * from employee_details";
}

$con = new mysqli('localhost','root','','dummy');
if ($con->connect_error){
    die("connection failed:".con->connect_error );
};

$result = $con->query($sql);

if($result->num_rows > 0){
    echo "<table><tr><th>ID</th><th>Name</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["EmployeeId"]."</td><td>".$row["Name"]."</td></tr>";
      }
      echo "</table>";
}

?>