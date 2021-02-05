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




    $sql_l = "SELECT * FROM monthly_clients WHERE tel_phone='$tel'";

    $res_l = mysqli_query($conn, $sql_l);

    if (mysqli_num_rows($res_l) > 0) {
        echo "<script type='text/javascript'>
  					swal('', 'The phone no  is already associated with an customer!!!', 'error');
</script>";
    }else{


        if (empty($error)) {

            $sql = "INSERT INTO monthly_clients SET fname='$fname',lname='$lname',biz_name='$biz',tel_phone='$tel',email='$email',rate_unit='$rate',date_registered=current_date() ";
            if (mysqli_query($conn, $sql)) {
                echo "<script type='text/javascript'>
  					swal('', 'Client registered successfully!!!', 'success');	
  					
</script>";
            } else {
                echo "<script type='text/javascript'>
  					swal('', 'There was an Error in the database!!!', 'error');
</script>";
            }
        }

    }}
?>