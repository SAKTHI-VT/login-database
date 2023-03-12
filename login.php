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
/*$conn = new mysqli('localhost','root','','project');
if($conn->connect_error)
{
    die('connection failed : '.$conn->connect_error);
}
else
{
    $stmt = $conn->prepare("insert into register(uname,email,pass,cpass)values(?,?,?,?)");
    $stmt->bind_param("ssss",$uname,$email,$pass,$cpass);
    $stmt->execute();
    echo "registered Successfully....";
    $stmt->close();
}*/
?>