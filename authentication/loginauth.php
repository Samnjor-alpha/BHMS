<?php
session_start();
$msg = "";
$msg_class = "";

$token = bin2hex(random_bytes(32));

include 'config.php';
// $date2 = new DateTime();
// $dt2=$date2->format();

// select * from your_table where  <> DATE(NOW());
$del_ext="DELETE FROM sessions WHERE DATE(created_at) <> DATE(NOW())";
mysqli_query($conn,$del_ext);

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
                        header('Location:../Dashboard/home.php');



                    }else{

                        $msg = "application failed to initiate session.Try again!";
                        $msg_class = "alert-danger";
                    }





                }
                /*---------------------------------------------------*/
                else {


                    $update_token="UPDATE sessions SET session_token = '$token' where admin_id='$sid'AND created_at=CURRENT_DATE()";
                    if (mysqli_query($conn, $update_token)) {

                        $_SESSION['bhmstoken'] = $token;




                        header('Location:../Dashboard/home.php');







                    }else{

                        $msg = "application failed to initiate session.Try again!";
                        $msg_class = "alert-danger";
                    }




                    /*---------------------------------------------------*/

                }
            }else{

                $msg = "application failed to initiate session.Try again!";
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