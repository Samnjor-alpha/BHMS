
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

// select * from your_table where  <> DATE(NOW());
$del_ext="DELETE FROM sessions WHERE DATE(created_at) <> DATE(NOW())";
mysqli_query($conn,$del_ext);
$del_code="DELETE FROM auth_code WHERE DATE(expDate) <> DATE(NOW())";
mysqli_query($conn,$del_code);
if (isset($_POST['signin'])) {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $msg = "complete fields!";
        $msg_class="alert-danger";
    } }
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



            if (!empty($token)) {

                $sid=$_SESSION['id'];
                $sql_token = "SELECT * FROM sessions WHERE admin_id='$sid' AND created_at=CURRENT_DATE()";
                $result_atv=mysqli_query($conn,$sql_token);

                /*---------------------------------------------------*/
                if (mysqli_num_rows($result_atv) < 1){

                    $sqltoken = "INSERT sessions SET session_token = '$token', admin_id='$sid',created_at=CURRENT_DATE()";
                    if (mysqli_query($conn, $sqltoken)) {

                        $_SESSION['bhmstoken'] = $token;
                        //send verification code to email

                        include 'sendcode.php';

                    } else {

                        $msg = "application failed to initiate session.Try again!";
                        $msg_class = "alert-danger";
                    }





                }
                /*---------------------------------------------------*/
                else {
                    $unlogged="SELECT * FROM sessions WHERE admin_id='$sid' AND logged_in='0' AND created_at=CURRENT_DATE()";
                    $result_unlogged=mysqli_query($conn,$unlogged);
                    if(mysqli_num_rows($result_unlogged)>0){
                        $update_unloggedtoken = "UPDATE sessions SET session_token = '$token' where admin_id='$sid' AND logged_in='0' AND created_at=CURRENT_DATE()";
                        if (mysqli_query($conn, $update_unloggedtoken)) {

                            $_SESSION['bhmstoken'] = $token;

                            include 'sendcode.php';
                        } else {
                            $msg = "Failed to create session";
                            $msg_class = "alert-danger";
                        }
                    }
                    $loggedtoken = "SELECT * FROM sessions WHERE admin_id='$sid' AND logged_in='1' AND created_at=CURRENT_DATE()";
                    $result_logged = mysqli_query($conn, $loggedtoken);
                    if (mysqli_num_rows($result_logged) > 0) {
                        $update_loggedtoken = "UPDATE sessions SET session_token = '$token' where admin_id='$sid' AND logged_in='1' AND created_at=CURRENT_DATE()";
                        if (mysqli_query($conn, $update_loggedtoken)) {

                            $_SESSION['bhmstoken'] = $token;

                            header('Location:../Dashboard/home.php');
                        } else {
                            $msg = "application failed to initiate session.Try again!";
                            $msg_class = "alert-danger";
                        }
                    }

                }
            } else {

                $msg = "An Error occured in the database!";
                $msg_class = "alert-danger";

            }
















        } else  if ($result->num_rows < 1) {
            $msg = "Incorrect Email or password!!";
            $msg_class = "alert-danger";
        }
    }

    $conn->close();


}
?>