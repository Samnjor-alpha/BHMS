
<?php
include '../authentication/config.php';
require  'session.php';
include 'query.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Add Customer</title>

    <? include '../public/stylesheet.php'?>

</head>
<body class="sb-nav-fixed">
<? include 'topbar.php'?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
    <?php require 'sidebar.php';?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h3 class="mt-4">Add Client</h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Add New client</li>
                 </ol>
                <div class="row">
                    <div class="float-left">
                        <div class="btn-group">
                            <a href="javascript: history.go(-1)" class="btn  btn-lg"><i class="text-secondary fas fa-arrow-left"></i></a>

                        </div>
                    </div>
                    <!-- /.btn-group -->
                </div>
            </div>
<div>

</div>     <div  class="row justify-content-center">


                        <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8">


                            <div class="card">

                                <div class="card-body">

                                        <?php if (!empty($_SESSION['msg'])): ?>
                                            <div class="alert <?php echo $_SESSION['msg_class'] ?> alert-dismissible fade show"  role="alert">
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

                                    <?php
                                    $sql_sale = "SELECT * FROM monthly_clients  ORDER by mc_id DESC ";
                                    $result_sale = mysqli_query($conn, $sql_sale);
                                    if (mysqli_num_rows($result_sale) <1) {
                                    echo"<div class='alert  alert-warning alert-dismissible'>";
                                        echo"No monthly customers available";
                                        echo"</div>";
                                    }else{


                                    ?>
                                    <table class="table  table-borderless" >
                                        <thead>
                                        <tr>
                                            <th >Biz name</th>
                                            <th> Mobile Number </th>
                                            <th>Action</th>

                                        </tr>
                                        </thead>

                                        <?php
                                        for ($i = 0; $row_sale = $result_sale->fetch_assoc(); $i++) {
                                        ?>
                                        <tbody>

                                            <tr>

                                                <td><?php   echo $row_sale['biz_name']; ?></td>
                                                <td><?php echo '+'.$row_sale['tel_phone']; ?></td>
                                                <td> <a class="btn btn-sm btn-success" href="view-customer.php?client_id=<?php echo $row_sale['mc_id'] ?>">View</a></td>
                                            </tr>



                                        </tbody>
                                        <?php }?>

                                    </table>
                                    <?php }?>






                                </div>
                            </div>


</div>


                </div>

        </main>




                <? include '../public/footer.php'?>

        <? include '../public/scripts.php'?>


</body>
</html>
