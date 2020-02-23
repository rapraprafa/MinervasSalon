<?php

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$homeAddress = $_POST['homeAddress'];
$phoneNumber = $_POST['phoneNumber'];
$timePreferred = $_POST['timePreferred'];
$serviceType = $_POST['serviceType'];

if (!empty($firstName) || !empty($lastName) || !empty($gender) || !empty($email) || !empty($homeAddress) || !empty($phoneNumber) || !empty($timePreferred) || !empty($serviceType))
{
    $host = "sql12.freemysqlhosting.net";
    $dbUsername = "sql12286772";
    $dbPassword = "qDpvgqB9k8";
    $dbname = "sql12286772"; //insert database name here

    //creating the connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if (mysqli_connect_error()){
        die('Connect Error('.mysqli_connect_errno().')'. mysqli_connect_error());
    }
    else{
        $SELECT = "SELECT timePreferred From customerreserve Where timePreferred = ? Limit 1";
        $INSERT = "INSERT Into customerreserve(firstName, lastName, gender, email, homeAddress, phoneNumber, timePreferred, serviceType) values (?,?,?,?,?,?,?,?)";
        
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $timePreferred);
        $stmt->execute();
        $stmt->bind_result($timePreferred);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if($rnum==0){
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sssssiss", $firstName, $lastName, $gender, $email, $homeAddress, $phoneNumber, $timePreferred, $serviceType);
            $stmt->execute();
            echo file_get_contents("successfulreserve.html");
        }
        else {
            echo file_get_contents("alreadyreserved.html");
        }
    
        $stmt->close();
        $conn->close();
}
}
else
{
    echo "All field are required";
    die();
 }   
?>