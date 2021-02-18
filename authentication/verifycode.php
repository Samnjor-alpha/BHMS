<?php
$msg="";
    $msg_class="";

if(isset($_POST['verify'])){
    date_default_timezone_set("Africa/Nairobi");
    $vcode=$_POST['vcode'];
    $ad_id=$_SESSION['id'];
    $actual_minute = date("i");
    $query = "select * from auth_code where verify_code='$vcode' and is_expired='0' AND admin_id='$ad_id'";
    $resultverify=mysqli_query($conn,$query);
    if (mysqli_num_rows($resultverify)>0){
$row_verify=$resultverify->fetch_assoc();
$xdate=$row_verify['expDate'];
    $checkdate = $row_verify['expDate'];
        $date2 = new DateTime($checkdate);
        $dt2=$date2->format('Y-m-d');

        $td= date('Y-m-d');
        if ($dt2<$td){
        $msg="Code is expired.Request a new one";
        $msg_class="alert-danger";
    }else{

        $update_token="UPDATE sessions SET logged_in = '1' where admin_id='$ad_id'AND created_at=CURRENT_DATE()";
        if (mysqli_query($conn, $update_token)) {
            $del_ext="DELETE FROM auth_code WHERE admin_id='$ad_id' AND verify_code='$vcode'";

            if(mysqli_query($conn,$del_ext)){
                header('Location:../Dashboard/home.php');
            }

        }
    }



}else{
  $msg="invalid code.Check your mail again";
  $msg_class="alert-danger";
}}