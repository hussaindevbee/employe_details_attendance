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

        <form action="details.php" method="post">
            <fieldset>
                <legend>
                    User personal information
                </legend>
                <label>
                    Enter Your Full Name
                </label>
                <input 
                type="text" 
                name="name"
                required="true",
                value=""
                 />
                
                <label>Enter Your Phone Number</label>
                <input
                    type="number"
                    name="phone_number"/>

                <label>Enter Your Address:</label>
                <textarea
                    type="text"
                    name="address"
                ></textarea>

                <label>Enter Your Age</label>
                <input
                    type="text"
                    name="age"
                />

                <label>Enter Your Gender</label>
                <input
                    type="radio"
                    name="gender"
                    value="male"
                />Male

                <input
                    type="radio"
                    name="gender"
                    value="female"
                />Female

                <input
                    type="radio"
                    name="gender"
                    value="others"
                />Others

                <label>Enter Your Salary</label>
                <input 
                type="number"
                name = "salary">

                <label>Enter Your City Name</label>
                <input 
                type="text"
                name = "city_name">

                <label>Enter Your State Name </label>
                <input 
                type="text"
                name = "state_name">
                <br> <br>
                <button>SUBMIT</button>
            </fieldset>
        </form>

<?php
if($_REQUEST){

    // print_r($_REQUEST);exit;
    $name = $_REQUEST['name'];
    $phone_number = $_REQUEST['phone_number'];
    $address = $_REQUEST['address'];
    $age = $_REQUEST['age'];
    $gender =$_REQUEST['gender'];
    $salary=$_REQUEST['salary'];
    $city_name=$_REQUEST['city_name'];
    $state_name=$_REQUEST['state_name'];
    
    $sql="insert into employee_details(Name,Phone,Address,Age,Gender,Salary,City,State) values('$name','$phone_number','$address','$age','$gender','$salary','$city_name','$state_name')";
    // echo $sql;exit;
    $con = new mysqli('localhost','root','','dummy');
    if ($con->connect_error){
        die("connection failed:".con->connect_error );
    };
    if ($con->query($sql) === TRUE) {
        echo "New record created successfully";
        header("Location: index.php");
      } else {
        echo "Error: " . $sql . "<br>" . $con->error;
      }   
}
?>