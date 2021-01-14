
<?php
session_start();

$as_id=$_SESSION['id'];


include '../../authentication/config.php';

$del_stoken="DELETE  FROM sessions where admin_id='$as_id'";

if (mysqli_query($conn, $del_stoken)) {

    session_unset();
    session_destroy();

    header('location:../../authentication');

}else{

    header('Location:../../Error/500.php');

}

?>
