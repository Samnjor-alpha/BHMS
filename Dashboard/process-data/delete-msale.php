<?php
session_start();

$_SESSION['msg'] = "";
$_SESSION['msg_class'] = "";
include '../../authentication/config.php';
$mrid = $_GET['delmrecno'];








$sql = "DELETE FROM mcustomer_sales WHERE mr_id='$mrid'";


if (mysqli_query($conn, $sql)) {
    $_SESSION['msg']= "Record  deleted successfully";
    $_SESSION['msg_class'] = "alert-success";

    header("Location:../edit-del-monthly.php");
} else {
    $_SESSION['msg']= "An error occurred";
    $_SESSION['msg_class'] = "alert-danger";
    header("Location:../managedailysales.php");
}

