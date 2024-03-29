<?php
include 'config.php';
$msg="";
$msg_class="";
if(isset($_GET['token']))
{
            $usertoken=$_GET['token'];
            $user=$_GET['email'];
    $query = "SELECT * FROM admin_user WHERE token='$usertoken' and email ='$user'";
    $res_e = mysqli_query($conn, $query);


if(mysqli_num_rows($res_e) > 0)
{

    $row = $res_e->fetch_array(MYSQLI_ASSOC);
{
if($row['verified'] == '0')
{
$update_query = "UPDATE admin_user SET verified = '1'  WHERE  a_id = '".$row['a_id']."'";
      $res_up = mysqli_query($conn, $update_query);


if(isset($res_up))
{
$msg = 'Your Email Address Successfully Verified';
$msg_class='alert-success';
}
}
else
{
$msg = 'Your Email Address Already Verified';
$msg_class='alert-info';
}
}
}
else
{
$msg = 'Invalid Link';
$msg_class='alert-danger';

}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Activate account</title>

    <link href="../dist/css/styles.css" rel="stylesheet" />

    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
</head>
<style>
    body{

        background-color: #979797;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='800' height='800' viewBox='0 0 200 200'%3E%3Cdefs%3E%3ClinearGradient id='a' gradientUnits='userSpaceOnUse' x1='88' y1='88' x2='0' y2='0'%3E%3Cstop offset='0' stop-color='%23000000'/%3E%3Cstop offset='1' stop-color='%23000000'/%3E%3C/linearGradient%3E%3ClinearGradient id='b' gradientUnits='userSpaceOnUse' x1='75' y1='76' x2='168' y2='160'%3E%3Cstop offset='0' stop-color='%23707070'/%3E%3Cstop offset='0.09' stop-color='%238c8c8c'/%3E%3Cstop offset='0.18' stop-color='%239e9e9e'/%3E%3Cstop offset='0.31' stop-color='%23acacac'/%3E%3Cstop offset='0.44' stop-color='%23b6b6b6'/%3E%3Cstop offset='0.59' stop-color='%23bebebe'/%3E%3Cstop offset='0.75' stop-color='%23c4c4c4'/%3E%3Cstop offset='1' stop-color='%23c8c8c8'/%3E%3C/linearGradient%3E%3Cfilter id='c' x='0' y='0' width='200%25' height='200%25'%3E%3CfeGaussianBlur in='SourceGraphic' stdDeviation='12' /%3E%3C/filter%3E%3C/defs%3E%3Cpolygon fill='url(%23a)' points='0 174 0 0 174 0'/%3E%3Cpath fill='%23000' fill-opacity='.5' filter='url(%23c)' d='M121.8 174C59.2 153.1 0 174 0 174s63.5-73.8 87-94c24.4-20.9 87-80 87-80S107.9 104.4 121.8 174z'/%3E%3Cpath fill='url(%23b)' d='M142.7 142.7C59.2 142.7 0 174 0 174s42-66.3 74.9-99.3S174 0 174 0S142.7 62.6 142.7 142.7z'/%3E%3C/svg%3E");
        background-attachment: fixed;
        background-repeat: no-repeat;
        background-position: top left;


    }
    #login .container #login-row #login-column #login-box {


        border: 1px solid #000000;
        background-color: #fff;
    }
    #login .container #login-row #login-column #login-box #login-form {
        padding: 20px;
    }

</style>
<body class="sb-nav-fixed">
<main>
    <div id="login">
        <h3 class="text-center text-white pt-5">PPF</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6 col-sm-12 col-lg-6 col-xl-6">
                    <div id="login-box" class="col-md-12 col-sm-12 col-lg-12 col-xl-12">

                        <form id="login-form" class="form" action="" method="post">
                            <h3 class="text-center text-info">Account Verification</h3>
                            <div>
                                <?php if (!empty($msg)): ?>
                                    <div class="alert <?php echo $msg_class ?> alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <?php echo $msg; ?>
                                    </div>
                                <?php endif; ?>
                            </div>


                            <div class="form-group blockquote-footer">

                                <a  class="btn btn-info btn-block" href="login.php">Login</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
<?php  include '../public/scripts.php'?>

</body>
</html>