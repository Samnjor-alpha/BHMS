<?php
session_start();

$_SESSION['msg'] = "";
$_SESSION['msg_class'] = "";
include '../../authentication/config.php';
$drid = $_GET['delrecno'];








    $sql = "DELETE FROM daily_sales WHERE dr_id='$drid'";


    if (mysqli_query($conn, $sql)) {
        $_SESSION['msg']= "Record  deleted successfully";
        $_SESSION['msg_class'] = "alert-success";

        header("Location:../managedailysales.php");
    } else {
        $_SESSION['msg']= "An error occurred";
        $_SESSION['msg_class'] = "alert-danger";
        header("Location:../managedailysales.php");
    }

