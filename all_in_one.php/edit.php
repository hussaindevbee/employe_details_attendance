<?php
$con = new mysqli('localhost','root','','dummy');
if ($con->connect_error){
    die("connection failed:".$con->connect_error );
};

if(!isset($_REQUEST['id'])){
    echo "Please provide id";
    return;
};
$id=$_REQUEST['id'];
  $sql="select * from employee_details where employeeid=$id";
  $result = $con->query($sql);

if($result->num_rows > 0){
    $res=$result->fetch_assoc();

    //    print_r($res);exit;
    $get_name = $res['Name'];
    $get_phone = $res['Phone'];
    $get_address = $res['Address'];
    $get_age = $res['Age'];
    $get_gender = $res['Gender'];
    $get_salary = $res['Salary'];
    $get_city = $res['City'];
    $get_state = $res['State'];
}else{
    echo "No data available";
};
?>        
        
        <title>USER DATAS</title>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                background-color: #f0f0f0;
            }

            form {
                width: 400px;
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px
                    rgba(0, 0, 0, 0.1);
            }

            fieldset {
                border: 1px solid black;
                padding: 10px;
                margin: 0;
            }

            legend {
                font-weight: bold;
                margin-bottom: 10px;
            }

            label {
                display: block;
                margin-bottom: 5px;
            }

            input[type="text"],
            input[type="email"],
            input[type="number"]{
                margin-left:20px;
            },
            input[type="text"]{
                margin-left:20px;
            },
            textarea,

            input[type="radio"] {
                margin-left: 20px;
            }

            input[type="submit"] {
                padding: 10px 20px;
                
                border-radius: 5px;
                cursor: pointer;
            }
        </style>

        <form action="edit.php" method="post">
            <fieldset>
                <legend>
                    User personal information
                </legend>
                <label
                    >Enter Your Full Name</label
                >
                <input 
                type="text", 
                name="name",
                required="true",
                value="<?= $get_name;?>",
                 />
                
                <label>Enter Your Phone Number</label>
                <input
                    type="number",
                    name="phone_number",
                    value="<?= intval($get_phone); ?>"
                    />

                <label>Enter Your Address:</label>
                <textarea
                    type="text"
                    name="address"><?= $get_address?>
                   </textarea>

                <label>Enter Your Age</label>
                <input
                    type="text"
                    name="age"
                    value="<?= $get_age ?>"
                    />

                <label>Enter Your Gender</label>
                <input
                    type="radio"
                    name="gender"
                    value="male"
                    <?php  if(strtolower($get_gender)=='male'){ echo "checked"; } ?>
                    
                />Male

                <input
                    type="radio"
                    name="gender"
                    value="female"
                    <?php  if(strtolower($get_gender)=='female'); ?>
                />Female

                <input
                    type="radio"
                    name="gender"
                    value="others"
                    <?php  if(strtolower($get_gender)=='others'){ echo "checked"; } ?>
                />Others

                <label>Enter Your Salary</label>
                <input 
                type="number"
                name = "salary" 
                value="<?= $get_salary ?>"
                />

                <label>Enter Your City Name</label>
                <input 
                type="text"
                name = "city_name"
                value="<?= strtolower($get_city)?>">

                <label>Enter Your State Name </label>
                <input 
                type="text"
                name = "state_name"
                value="<?= strtolower($get_state)?>">
                <br> <br>
                <input
                    type="submit"
                    value="submit"
                    name="submit"
                />

                <input type="hidden"  name="id" value="<?= $id;?>">
            </fieldset>
        </form>

<?php
if(isset($_REQUEST['submit'])){
    $id=$_REQUEST['id'];
    $name = $_REQUEST['name'];
    $phone_number = $_REQUEST['phone_number'];
    $address = $_REQUEST['address'];
    $age = $_REQUEST['age'];
    $gender = $_REQUEST['gender'];
    $salary=$_REQUEST['salary'];
    $city_name=$_REQUEST['city_name'];
    $state_name=$_REQUEST['state_name'];
    
    $sql="update employee_details set 
    Name='$name',
    Phone='$phone_number',
    Address='$address',
    Age='$age',
    Gender='$gender',
    Salary='$salary',
    City='$city_name',
    State='$state_name'   
    where EmployeeId=$id";

    // echo $sql;exit;
    if ($con->query($sql) === TRUE) {
        header("Location: index.php");
        echo "Record updated successfully";
      } else {
        echo "Error: " . $sql . "<br>" . $con->error;
      };
};
?>        