<?php
$msg = "";
$msg_class = "";
// for the database
$adm_id=$_SESSION['id'];
function createBillno() {
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
$billno='Bill-'.createBillno();
$mc_results = mysqli_query($conn, "SELECT * FROM monthly_clients");
// start query daily sales earnings
if (isset($_POST['query'])){
    $month=$_POST['d1'];
    $date2 = new DateTime('Y');
    $dt2=$date2->format('Y');
    $mon = date('F', $time);



//    $reports="select count(*) as total from mcustomer_sales where year(end_date)='$dt2' and month(end_date)='$month'";
//    $result_report=mysqli_query($conn,$reports);
//    $data_reports=mysqli_fetch_assoc($result_report);

    $dreports="select count(*) as total from daily_sales where year(recorded_date)='$dt2' and month(recorded_date)='$month'";
    $result_dreport=mysqli_query($conn,$dreports);
    $data_dreports=mysqli_fetch_assoc($result_dreport);

//    $monthly_earnings = mysqli_query($conn, "SELECT sum(Amount), sum(amount_due) ,sum(units) FROM mcustomer_sales where year(start_date)='$dt2' and year(end_date)='$dt2' and month(start_date)='$month' and month(end_date)='$month'");
//    $s_row = $monthly_earnings->fetch_assoc();


    $daily_earns = mysqli_query($conn,"SELECT sum(Final_Amount),sum(amount_Exp),sum(units) FROM daily_sales where year(recorded_date)='$dt2' and month(recorded_date)='$month'");
    $daily_row = $daily_earns->fetch_assoc();

//    $Tunits=$daily_row['sum(units)']+$s_row['sum(units)'];

    $GrandEarn=$daily_row['sum(Final_Amount)'];
    $GrandExp=$daily_row['sum(amount_Exp)'];
    $clinets_count = mysqli_query($conn,"SELECT sum(Final_Amount),sum(amount_Exp) FROM daily_sales where year(recorded_date)='$dt2' and month(recorded_date)='$month'");

}else{

    $date2 = new DateTime('Y');
    $dt2=$date2->format('Y');
    $value = date('n', $time);
    $sql2="select count(*) as total from monthly_clients where year(date_registered)='$dt2' and month(date_registered)='$value'";
    $result2=mysqli_query($conn,$sql2);
    $data2=mysqli_fetch_assoc($result2);




    $dreports="select count(*) as total from daily_sales where year(recorded_date)='$dt2' and month(recorded_date)='$value'";
    $result_dreport=mysqli_query($conn,$dreports);
    $data_dreports=mysqli_fetch_assoc($result_dreport);



    $daily_earns = mysqli_query($conn,"SELECT sum(Final_Amount),sum(amount_Exp),sum(units) FROM daily_sales where year(recorded_date)='$dt2' and month(recorded_date)='$value'");
    $daily_row = $daily_earns->fetch_assoc();

//    $Tunits=$daily_row['sum(units)']+$s_row['sum(units)'];

    $GrandEarn=$daily_row['sum(Final_Amount)'];
    $GrandExp=$daily_row['sum(amount_Exp)'];
    $clinets_count = mysqli_query($conn,"SELECT sum(Final_Amount),sum(amount_Exp) FROM daily_sales where year(recorded_date)='$dt2' and month(recorded_date)='$value'");



}
//end of daily sale query earnings
if (isset($_POST['editr'])){
    $month=$_POST['edr1'];
    $date2 = new DateTime('Y');
    $dt2=$date2->format('Y');
    $mon = date('F', $time);


    $drecords="select *  from daily_sales where year(recorded_date)='$dt2' and month(recorded_date)='$month'order by recorded_date ASC ";
    $result_drecords=mysqli_query($conn,$drecords);










}else{
    $date2 = new DateTime('Y');
    $dt2=$date2->format('Y');
    $value = date('n', $time);

    $drecords="select *  from daily_sales where year(recorded_date)='$dt2' and month(recorded_date)='$value'";
    $result_drecords=mysqli_query($conn,$drecords);


}

$daily_row = $daily_earns->fetch_assoc();

function formatMoney($number, $fractional=false) {
    if ($fractional) {
        $number = sprintf('%.2f', $number);
    }
    while (true) {
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
        if ($replaced != $number) {
            $number = $replaced;
        } else {
            break;
        }
    }
    return $number;
}
// start monthly queries
$date2 = new DateTime('Y');
$dt2=$date2->format('Y');
$value = date('n', $time);

$sql2="select count(*) as total from monthly_clients";
$result2=mysqli_query($conn,$sql2);
$data2=mysqli_fetch_assoc($result2);

$reports="select count(*) as total from mcustomer_sales where year(end_date)='$dt2'";
$result_report=mysqli_query($conn,$reports);
$data_reports=mysqli_fetch_assoc($result_report);

$monthly_earnings = mysqli_query($conn, "SELECT sum(Amount), sum(amount_due) ,sum(units) FROM mcustomer_sales where  year(end_date)='$dt2'");
$s_row = $monthly_earnings->fetch_assoc();
$annual_earning= $s_row['sum(Amount)'];
//end of monthly sale queries

if (isset($_POST['USR'])) {
    // for the database

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
    $sql_e = "SELECT * FROM daily_sales WHERE recorded_date='$dt2' and not dr_id='$drid'";

    $res_e = mysqli_query($conn, $sql_e);

    if (mysqli_num_rows($res_e) > 0) {
        $msg = "The sale for that date is already recorded";
        $msg_class = "alert-danger";
    } else {
        if (empty($error)) {

            $sql = "UPDATE daily_sales SET admin_id='$adm_id', units='$units',i_reading='$iR',f_reading='$fR',Amount='$iAmount',Expenditures='$tags',Amount_Exp='$AmExp',Final_Amount='$fAmount',recorded_date='$dater', updated_date=CURRENT_DATE() where dr_id='$drid'";
            if (mysqli_query($conn, $sql)) {
                unset($_POST);

                $msg = "Record updated successfully";
                $msg_class = "alert-success";

            } else {
                $msg = "There was an Error in the database";
                $msg_class = "alert-danger";
            }
        }


    }
}
$date2 = new DateTime('Y');
$dt2=$date2->format('Y');
$value = date('n', $time);

$mrecords="select *  from mcustomer_sales where year(end_date)='$dt2' order by end_date DESC";
$result_mrecords=mysqli_query($conn,$mrecords);

//$sql_clients = "SELECT * FROM monthly_clients  ORDER by mc_id DESC LIMIT 10 OFFSET 11 ";
//$result_clients = mysqli_query($conn, $sql_clients);
if (isset($_GET['page_no']) && $_GET['page_no']!="") {
    $page_no = $_GET['page_no'];
} else {
    $page_no = 1;
}

$total_records_per_page =5;
$offset = ($page_no-1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";

$result_count = mysqli_query($conn,"select count(*) as total_records from monthly_clients");
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1; // total page minus 1

$result_clients = mysqli_query($conn,"SELECT * FROM `monthly_clients` ORDER by mc_id DESC LIMIT $offset, $total_records_per_page");
if (isset($_POST['uMR'])) {
    // for the database
    $iR = stripslashes($_POST['uiR']);
    $fR = stripslashes($_POST['ufR']);
    $units = stripslashes($_POST['mnits']);
    $rate=stripslashes($_POST['rate']);
    $client = stripslashes($_POST['mc']);
    $camount = stripslashes($_POST['camount']);
    $sdater = stripslashes($_POST['sdater']);
    $endater = stripslashes($_POST['endater']);
    $date1 = new DateTime($sdater);
    $dt1 = $date1->format('Y-m-d');

    $date2 = new DateTime($endater);
    $dt2 = $date2->format('Y-m-d');

    $td = date('Y-m-d');

    if ($dt1 > $dt2) {

        $msg = "Re-check the dates ";
        $msg_class = "alert-danger";
    }
    if ($dt2 > $td) {
        $msg = "You can't record future records";
        $msg_class = "alert-danger";
    } else {
        $start_date = strtotime($sdater);
        $end_date = strtotime($endater);
        $days = ($end_date - $start_date) / 60 / 60 / 24;

        $mc_results = mysqli_query($conn, "SELECT * FROM monthly_clients where mc_id='$client'");
        $cs_row = $mc_results->fetch_assoc();
//        $rate = $cs_row['rate_unit'];

        $fAmount = $rate * $units;
        $cn = $cs_row['fname'] . ' ' . $cs_row['lname'];

        $dates_results = mysqli_query($conn, "SELECT * FROM mcustomer_sales where client_id='$client' not mr_id='$mrid'");

        if ($fAmount > $camount) {
            $due = "0.00";

            if (empty($error)) {

                $sql = "UPDATE INTO mcustomer_sales SET admin_id='$adm_id', client_id='$client',i_reading='$iR',f_reading='$fR',client_name='$cn', units='$units', Amount='$camount',rate_per_unit='$rate', Expected_amount='$fAmount',amount_due='$due', start_date='$sdater',end_date='$endater',days_unit_spent='$days' where mr_id='$mrid'";


                if (mysqli_query($conn, $sql)) {
                    $_SESSION['msg'] = "Record added successfully";
                    $_SESSION['msg_class'] = "alert-success";

                    echo "<script>alert('Record updated successfully');</script>";
                    echo "<script type='text/javascript'> document.location = 'edit-del-monthly.php'; </script>";


                } else {

//            echo error_log($sql);

                    $_SESSION['msg'] = "Error occurred in the database";

                    $_SESSION['msg_class'] = "alert-danger";

                }
            }
        } else {
//            $due = $camount - $fAmount;

            $due='0.00';

            if (empty($error)) {

                $sql = "UPDATE mcustomer_sales SET admin_id='$adm_id', client_id='$client',client_name='$cn',i_reading='$iR',f_reading='$fR', units='$units', Amount='$camount', rate_per_unit='$rate',Expected_amount='$fAmount',amount_due='$due', quittance='$due', start_date='$sdater',end_date='$endater', days_unit_spent='$days' where mr_id='$mrid'";


                if (mysqli_query($conn, $sql)) {
                    $_SESSION['msg'] = "Record added successfully";
                    $_SESSION['msg_class'] = "alert-success";

                    echo "<script>alert('Record updated successfully');</script>";
                    echo "<script type='text/javascript'> document.location = 'edit-del-monthly.php'; </script>";

                } else {

//            echo error_log($sql);

                    $_SESSION['msg'] = "Error occurred in the database";

                    $_SESSION['msg_class'] = "alert-danger";

                }
            }


        }
    }
//        }
//    }
}