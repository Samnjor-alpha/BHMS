<?php
$msg = "";
$msg_class = "";

if (isset($_POST['SR'])) {
    if (empty($_POST['token'])&& empty($_SESSION['crsftoken'])) {

        header('Location:../../Error/500.php');
    } elseif (hash_equals($_SESSION['crsftoken'], $_POST['token'])) {

        $iR = stripslashes($_POST['iR']);
        $fR = stripslashes($_POST['fR']);
        $iAmount = stripslashes($_POST['iAmount']);
        $units = $fR - $iR;
//      $tags  = json_encode($tags);
        $tags = stripslashes($_POST['tags']);
        $AmExp = stripslashes($_POST['AmExp']);
        $fAmount = stripslashes($_POST['fAmount']);
        $dater = stripslashes($_POST['dater']);
        $date2 = new DateTime($_POST['dater']);
        $dt2 = $date2->format('Y-m-d');
        $date2 = new DateTime($dater);
        $dt2=$date2->format('Y-m-d');

        $td= date('Y-m-d');
        if ($dt2>$td){
            echo "<script type='text/javascript'>
  					swal('', 'You cant add feature records!!!', 'error');
</script>";
        }else{
            if ($units<1){
                $msg='Units cannot be less than 0';

                echo "<script type='text/javascript'>
  					swal('', 'Units cannot be less than 0!!!', 'error');
</script>";
            }else{


                $sql_e = "SELECT * FROM daily_sales WHERE recorded_date='$dt2'";

                $res_e = mysqli_query($conn, $sql_e);

                if (mysqli_num_rows($res_e) > 0) {

                    echo "<script type='text/javascript'>
  					swal('', 'The sale for that date is already recorded!!!', 'error');
</script>";
                } else {
                    if (empty($error)) {

                        $sql = "INSERT INTO daily_sales SET  units='$units',i_reading='$iR',f_reading='$fR',Amount='$iAmount',Expenditures='$tags',Amount_Exp='$AmExp',Final_Amount='$fAmount',recorded_date='$dt2'";
                        //$sql = "INSERT INTO daily_sales(dr_id,units,i_reading,f_reading,Amount,Expenditures,Amount_Exp,Final_Amount,recorded_date) values (UUID(),$units,$iR,$fR,$iAmount,$tags,$AmExp,$fAmount,$dt2)";
                        if (mysqli_query($conn, $sql)) {
                            unset($_POST);

                            echo "<script type='text/javascript'>
  					swal('', 'Record added successfully!!!', 'success');	
  					
</script>";

                        } else {
                            echo "<script type='text/javascript'>
  					swal('', 'There was an Error in the database!!!', 'error');
</script>";
                        }
                    }


                }
            }}}}
?>
































