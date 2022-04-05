
<?php
date_default_timezone_set("Africa/Nairobi");
session_start();
$msg = "";
$msg_class = "";




?>
<?php

$token = bin2hex(random_bytes(32));
//mt_srand(10);


//echo $vcodee;
include 'config.php';
// $date2 = new DateTime();
// $dt2=$date2->format();



if(isset($_POST['signin'])){
    $username = $_POST['email'];
    $password = $_POST['password'];

    $query = "select * from admin_user where email='$username'";
    $result = $conn->query($query);
    if ($result->num_rows<1){
        $msg = "Email is not registered!!".' '."<a href='register.php'>Register here</a>";
        $msg_class = "alert-danger";
    }else {

        $query = "select * from admin_user where email='$username' and verified='1'";
        $result = $conn->query($query);
        if ($result->num_rows < 1) {
            $msg = "Verify your email  to login!!";
            $msg_class = "alert-danger";
        }
    }        if ($result->num_rows == 1) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if (!password_verify($_POST['password'], $row['password'])) {
            $msg = "Cross-check your password!!";
            $msg_class = "alert-danger";
        }else  if (password_verify($_POST['password'], $row['password'])) {


            $_SESSION['id'] = $row['a_id'];// Password matches, so create the sessions
            $_SESSION['bhmsuser'] = $row['username'];
            $_SESSION['bhmsemail'] = $row['email'];




                        //send verification code to email
                        header('Location:../Dashboard/home.php');


                     }}}
























?>