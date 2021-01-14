<?php
include '../authentication/config.php';
session_start();

$_SESSION['msg'] = "";
$_SESSION['msg_class'] = "";


$id = $_GET['client-d'];
$check_due = "SELECT sum(amount_due) FROM mcustomer_sales where client_id='$id'";

$result_due = mysqli_query($conn, $check_due);
for($i=0; $rb = $result_due->fetch_assoc(); $i++){

    $amount=$rb['sum(amount_due)'];

}
if ($amount>500){
    $_SESSION['msg']="The client cannot be deleted. He owes ksh. $amount.";
    $_SESSION['msg_class']="alert-danger";

    header("Location:view-customers.php");
}else{




    $sql = "DELETE FROM monthly_clients WHERE mc_id='$id'";


    if (mysqli_query($conn, $sql)) {
        $_SESSION['msg']= "Client deleted successfully";
        $_SESSION['msg_class'] = "alert-success";

        header("Location:view-customers.php");
    } else {
        $_SESSION['msg']= "An error occurred";
        $_SESSION['msg_class'] = "alert-danger";
        header("Location:view-customers.php");
    }

}