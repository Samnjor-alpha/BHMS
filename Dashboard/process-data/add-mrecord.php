<?php

$_SESSION['msg'] = "";
$_SESSION['msg_class'] = "";
function createBillno2() {
    $chars = "003232303232023232023456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;
    while ($i <= 4) {

        $num = rand() % 33;

        $tmp = substr($chars, $num, 1);

        $pass = $pass . $tmp;

        $i++;

    }
    return $pass;
}
$billnoe='Bill-'.createBillno2();


if (isset($_POST['SMR'])) {
    if (empty($_POST['token'])&& empty($_SESSION['crsftoken'])) {

        header('Location:../../Error/500.php');
    } elseif (hash_equals($_SESSION['crsftoken'], $_POST['token'])) {
        // for the database$
        $billno = $_GET['billno'];
        $iR = stripslashes($_POST['uiR']);
        $fR = stripslashes($_POST['ufR']);

        $units = stripslashes($_POST['mnits']);
        $client = stripslashes($_POST['mc']);
        $camount = stripslashes($_POST['camount']);
        $sdater = stripslashes($_POST['sdater']);
        $rate= stripslashes($_POST['rate']);
        $endater = stripslashes($_POST['endater']);
        $date1 = new DateTime($sdater);
        $dt1 = $date1->format('Y-m-d');

        $date2 = new DateTime($endater);
        $dt2 = $date2->format('Y-m-d');

        $td = date('Y-m-d');

        if ($dt1 > $dt2) {

            echo "<script type='text/javascript'>
  					swal('', 'Re-check the dates!!!', 'error');
</script>";
        }
        if ($dt2 > $td) {
            echo "<script type='text/javascript'>
  					swal('', 'Cant record future dates!!!', 'error');
</script>";
        } else {
            $start_date = strtotime($sdater);
            $end_date = strtotime($endater);
            $days = ($end_date - $start_date) / 60 / 60 / 24;

            $mc_results = mysqli_query($conn, "SELECT * FROM monthly_clients where mc_id='$client'");
            $cs_row = $mc_results->fetch_assoc();
//        $rate = $cs_row['rate_unit'];

            $fAmount = $rate * $units;
            $cn = $cs_row['fname'] . ' ' . $cs_row['lname'];

            $dates_results = mysqli_query($conn, "SELECT * FROM mcustomer_sales where bill_no='$billno'");
            $date_row = $dates_results->fetch_assoc();
            if (mysqli_num_rows($dates_results) > 1) {
                $_SESSION['msg'] = 'The bill for that date is already recorded';
                $_SESSION['msg_class'] = 'alert-danger';
            } else {
                if ($fAmount > $camount) {
                    $due = $fAmount - $camount;

                    if (empty($error)) {

                        $sql = "INSERT INTO mcustomer_sales SET  client_id='$client',bill_no='$billno',i_reading='$iR',f_reading='$fR',client_name='$cn', units='$units', Amount='$camount',rate_per_unit='$rate', Expected_amount='$fAmount',amount_due='$due', start_date='$sdater',end_date='$endater',days_unit_spent='$days'";


                        if (mysqli_query($conn, $sql)) {

                            echo "<script type='text/javascript'>
  					swal('', 'Monthly record added successfully!!!', 'success').then(function() {
  					window.location.href='monthly-sale.php?billno=$billnoe';
  					});
</script>";



                        } else {

//            echo error_log($sql);

                            echo "<script type='text/javascript'>
  					swal('', 'There was an Error in the database!!!', 'error');
</script>";
                        }
                    }
                } else {
                    if (mysqli_num_rows($dates_results) > 1) {

                        echo "<script type='text/javascript'>
  					swal('', 'The bill for that date is already recorded!!!', 'error');
</script>";
                    } else {
                        $due = $camount - $fAmount;


                        if (empty($error)) {

                            $sql = "INSERT INTO mcustomer_sales SET  client_id='$client',bill_no='$billno',client_name='$cn',i_reading='$iR',f_reading='$fR', units='$units', Amount='$camount', rate_per_unit='$rate',Expected_amount='$fAmount', quittance='$due', start_date='$sdater',end_date='$endater', days_unit_spent='$days'";


                            if (mysqli_query($conn, $sql)) {


                                echo "<script type='text/javascript'>
  					swal('', 'Monthly record added successfully!!!', 'success').then(function() {
  					window.location.href='monthly-sale.php?billno=$billnoe';
  					});
</script>";
                            } else {

//            echo error_log($sql);

                                echo "<script type='text/javascript'>
  					swal('', 'There was an Error in the database!!!', 'error');
</script>";
                            }
                        }


                    }
                }
            }
        }}}

