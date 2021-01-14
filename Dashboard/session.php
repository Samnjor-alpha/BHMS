
<?php
session_start();
include_once '../authentication/config.php';
$_SESSION['msg'] = "";
$_SESSION['msg_class'] = "";

$atv= $_SESSION['id'];
$sql_tv = "SELECT * FROM sessions WHERE admin_id='$atv' AND created_at=CURRENT_DATE()";
$result_atv=mysqli_query($conn,$sql_tv);


if (mysqli_num_rows($result_atv) < 1){

    $_SESSION['msg'] = "Not authorised...";
    $_SESSION['msg_class'] = "alert-danger";
    header('location:../authentication');
}else{

    $atv_row = $result_atv->fetch_assoc();

    $ssid=$atv_row['session_id'];
    $as_id=$_SESSION['id'];
    if (hash_equals($_SESSION['bhmstoken'], $atv_row['session_token'])) {




        if (!isset($_SESSION['bhmsemail'])) {

            $del_stoken="DELETE  FROM sessions where admin_id='$as_id' and session_id = '$ssid'";

            unset($_SESSION['bhmsemail']);
            unset($_SESSION['bhmsuser']);
            unset($_SESSION['bhmstoken']);
            if (mysqli_query($conn, $del_stoken)) {
                $_SESSION['msg_class'] = "alert-danger";
                $_SESSION['msg'] = "Login to continue...";
                header('location:../authentication');
            }
        }else {
            $time = $_SERVER['REQUEST_TIME'];

            /**
             * for a 10 minute timeout, specified in seconds
             */
            $timeout_duration = 600;

            /**
             * Here we look for the user's LAST_ACTIVITY timestamp. If
             * it's set and indicates our $timeout_duration has passed,
             * blow away any previous $_SESSION data and start a new one.
             */
            if (isset($_SESSION['LAST_ACTIVITY']) &&
                ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
                unset($_SESSION['bhmsemail']);
                unset($_SESSION['bhmsuser']);
                unset($_SESSION['bhmstoken']);

                $_SESSION['msg'] = "Your session has expired...";
                $_SESSION['msg_class'] = "alert-danger";

                $del_stoken="DELETE  FROM sessions where admin_id='$as_id' and session_id = '$ssid'";

                if (mysqli_query($conn, $del_stoken)) {
                    $_SESSION['msg'] = "Your session has expired...";
                    $_SESSION['msg_class'] = "alert-danger";
                    header('location:../authentication');
                }

            }
        }
        /**
         * Finally, update LAST_ACTIVITY so that our timeout
         * is based on it and not the user's login time.
         */
        $_SESSION['LAST_ACTIVITY'] = $time;
    }else{

        $_SESSION['msg'] = "token Verification failed";
        $_SESSION['msg_class'] = "alert-danger";
        unset($_SESSION['bhmsemail']);
        unset($_SESSION['bhmsuser']);
        unset($_SESSION['bhmstoken']);
        $del_stoken="DELETE  FROM sessions where admin_id='$as_id' and session_id = '$ssid'";

        if (mysqli_query($conn, $del_stoken)) {

            header('location:../authentication');
        }

    }}