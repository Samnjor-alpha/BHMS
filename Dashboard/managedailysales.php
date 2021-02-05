
<?php
include '../authentication/config.php';
require  'session.php';
require 'query.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Manage daily sales</title>
    <? include '../public/stylesheet.php'?>

</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="home.php">Tomai water supplies</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    <form class="  form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

    </form>

    <ul class="navbar-nav ml-sm-auto ml-md-auto ml-lg-auto ml-auto d-none d-sm-none d-md-inline-block d-lg-inline-block d-xl-inline-block ml-sm-0 ml-lg-0 ml-xl-0 ml-md-0 align-right">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">

                <a class="dropdown-item" href="process-data/logout.php">Logout</a>
            </div>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
    <?php require 'navbar.php';?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h3 class="mt-4">Manage Sales</h3>
                <div class="mt-4 mb-2 text-center">
                    <form method="post" action="">
                        <select id="dt1" name="edr1">
                            <?php
                            for ($i = 0; $i < 12; $i++) {
                                $time = strtotime(sprintf('%d months', $i));
                                $label = date('F', $time);
                                $value = date('n', $time);
                                echo "<option value='$value'>$label</option>";
                            }
                            ?>
                        </select>
                        <input class="btn btn-info btn-sm" name="editr" value="View sales" type="submit">
                    </form></div>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Manage  <?php
                        // PHP program to convert number to month name
                        if (isset($_POST['editr'])) {
                        // Declare month number and initialize it
                        $month_num = $_POST['edr1'];

                        // Use mktime() and date() function to
                        // convert number to month name
                        $month_name = date("F", mktime(0, 0, 0, $month_num, 10));

                        // Display month name
                        echo $month_name . "\n records";
                        }else {
                        $time = strtotime(sprintf('%d months', $i));
                        $label = date('F', $time);
                        $value = date('n', $time);
                        echo $label.' '.'records';
                        }
                        ?> daily sales</li>
                </ol>
            </div>

            <div class="container">
                <div  class="row justify-content-center">
                    <div id="login-column" class="col-md-12 col-sm-12 col-lg-12 col-xl-12">
                        <div id="login-box" class="col-md-12 col-sm-12 col-lg-12 col-xl-12">
                        <div>
                            <?php if (!empty($_SESSION['msg'])): ?>
                                <div class="alert <?php echo $_SESSION['msg_class'] ?> alert-dismissible fade show col justify-content-center align-items-center text-center" id="login-box" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <?php echo $_SESSION['msg']; ?>
                                </div>
                            <?php endif; ?>
                            <?php
                            unset($_SESSION['msg']);
                            unset($_SESSION['msg_class'])
                            ?>
                        </div>









                <div class="card">
                    <div class="card-body">
                        <div  id="divToPrint">

<?php if (mysqli_num_rows($result_drecords) <1){?>
                            <div class="row justify-content-center">
                                <div class="">

                                    <strong>No Records for this month</strong>
                                </div>
                            </div>
<?php }else {?>


                            <table class="table  table-responsive" >
                                <thead class="small justify-content-center">
                                <tr>
                                    <th> Date sold</th>
                                    <th>Units Sold</th>
                                    <th> Amount collected </th>
                                    <th> Expenditures </th>
                                    <th> Spent Expenditures </th>
                                    <th>Final Amount</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                for ($i = 0; $row_dsale = $result_drecords->fetch_assoc(); $i++) {
                                ?>
                                <tr class="small" >
                                    <td class="">
                                        <?php
                                        $dy=$row_dsale['recorded_date'];
                                        $date2 = new DateTime("$dy");
                                        echo $dt2=$date2->format("D,d-M-Y");

                                        ?></td>

                                    <td><?php echo $row_dsale['units'] . ' '.'m<sup>3<sup></sup>'; ?></td>
                                    <td><?php   $dsdsd = $row_dsale['Amount'];
                                        echo 'ksh. '.formatMoney($dsdsd, true); ?></td>
                                    <td class="text-monospace"><?php echo $row_dsale['Expenditures']; ?></td>
                                    <td><?php
                                        $dsdsd = $row_dsale['Amount_Exp'];
                                        echo 'ksh. '.formatMoney($dsdsd, true);
                                        ?></td>
                                    <td><?php
                                        $dsdsd = $row_dsale['Final_Amount'];
                                        echo 'ksh. '.formatMoney($dsdsd, true);
                                        ?></td>
                                    <td><a href="edit-del-daily.php?recordno=<?php echo$row_dsale['dr_id'];?>" class="text-success">Edit</a>|<a  class="text-danger" onclick="return confirm('Do you want to delete');" href="process-data/delete-dsale.php?delrecno=<?php echo $row_dsale['dr_id']?>">Delete</a></td>
                                </tr>

                                </tbody>
                                <?php }}?>

                            </table>

                        </div>



                    </div>
                </div>
            </div>
            </div>
                </div>
            </div>



        </main>

        <? include '../public/footer.php'?>

        <? include '../public/scripts.php'?>


</body>
</html>
