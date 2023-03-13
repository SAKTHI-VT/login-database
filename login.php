<?php
$uname = $_POST['uname'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$cpass = $_POST['cpass'];
if(!empty($uname) || !empty($email) || !empty($pass) || !empty($cpass))
{
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "project";

    $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);
    if(mysqli_connect_error())
    {
        die('connect Error ('.mysqli_connect_errno().')'
        .mysqli_connect_error());
    }
    else
    {
        $SELECT = "SELECT email From register Where email=? Limit 1";
        $INSERT = "INSERT Into register(uname,email,pass,cpass) values(?,?,?,?)";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum==0) 
        {
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssss", $uname,$email,$pass,$cpass);
            $stmt->execute();
            echo "New record inserted sucessfully";
        }
        else 
        {
            echo "Someone already register using this email";
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

$con = new mysqli("localhost","root","","project");
if($con->connect_error)
{
    die("Failed to connect : ".$con->connect_error);
}
else
{
    $stmt = $con->prepare("select * from register where uname = ?");
    $stmt->bind_param("s",$uname);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    if($stmt_result->num_rows>0)
    {
        $data = $stmt_result->fetch_assoc();
        if($data['pass']==$pass)
        {
            echo "Login Successfull";
        }
        else
        {
            echo "<h2>Invalid Credintials</h2>";
        }
    }
    else
    {
        echo "<h2>Invalid Credintials</h2>";
    }
}
?>