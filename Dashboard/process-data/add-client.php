<?php
$msg = "";
$msg_class = "";


if (isset($_POST['addclient'])) {
    // for the database

    $fname = mysqli_real_escape_string($conn,$_POST['fname']);
    $lname = mysqli_real_escape_string($conn,$_POST['lname']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $tel = mysqli_real_escape_string($conn,$_POST['mobile']);
    $biz = mysqli_real_escape_string($conn,$_POST['biz']);
    $rate = mysqli_real_escape_string($conn,$_POST['rate']);




    $sql_e = "SELECT * FROM monthly_clients WHERE tel_phone='$tel'";

    $res_e = mysqli_query($conn, $sql_e);

    if (mysqli_num_rows($res_e) > 0) {
        $msg = "The mobile number  is already associated with an customer";
        $msg_class = "alert-danger";
    }else{


            if (empty($error)) {

                $sql = "INSERT INTO monthly_clients SET fname='$fname',lname='$lname',biz_name='$biz',tel_phone='$tel',email='$email',rate_unit='$rate',date_registered=current_date() ";
                if (mysqli_query($conn, $sql)) {
                    $msg = "Registered successfully";
                    $msg_class = "alert-success";
                } else {
                    $msg = "There was an Error in the database";
                    $msg_class = "alert-danger";
                }
            }

}}
?>