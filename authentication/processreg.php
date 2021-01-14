<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/autoload.php';

$msg = "";
$msg_class = "";

if (isset($_POST['signup'])) {






//    $cpwd = stripslashes($_POST['cpassword']);
    $username = filter_var(stripslashes($_POST['username']), FILTER_SANITIZE_STRING);
    $email = filter_var(stripslashes($_POST['email']), FILTER_SANITIZE_STRING);
    $pwd=filter_var(stripslashes($_POST['password']),FILTER_SANITIZE_STRING);
    $cpwd = filter_var(stripslashes($_POST['cpassword']),FILTER_SANITIZE_STRING);


              $user_token = rand(100000,999999);

             $user_registration_token = md5(rand());




    if (empty($_POST['username']) || empty($_POST['email']|| empty($_POST['password']))) {
        $msg = "inputs can not be empty";
        $msg_class="alert-danger";
    } else{
        if(!empty($_POST["email"])) {
            $email= $_POST["email"];
            if (filter_var($email, FILTER_VALIDATE_EMAIL)===false) {

                $msg='invalid email';
                $msg_class='alert-danger';
            }else{


    $sql_e = "SELECT * FROM admin_user WHERE email='$email'";

    $res_e = mysqli_query($conn, $sql_e);



                if(strlen(trim($pwd)) <6)
                {
                    $msg = "password too short";
                    $msg_class = "alert-danger";
                }else{

               


                    // check if passwords match
    if ($pwd !== $cpwd) {
        $msg = "The passwords do not match";
        $msg_class = "alert-danger";
    } elseif ($pwd == $cpwd) {

        if (mysqli_num_rows($res_e) > 0) {
            $msg = "Email is already associated with an account";
            $msg_class = "alert-danger";
        } else {
            $hash = password_hash($pwd, PASSWORD_DEFAULT);

            // For image upload

            // Upload image only if no errors
            if (empty($error)) {

               
                    $mail = new PHPMailer;
                    $mail->isSMTP();
                    $mail = new PHPMailer(true);


                    $mail->IsSMTP();
                    $mail->SMTPDebug = 0;
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = 'ssl';
                    $mail->Host = "smtp.gmail.com";
                    $mail->Port = 465; // or 587
                    $mail->IsHTML(true);
                    $mail->Username = 'samnjorm@gmail.com';
                    $mail->Password = 'samnjormessy';
                    $mail->setFrom('myemail@gmail.com');
                    $mail->addAddress($email);
                    $output='<p>Dear Admin,</p>';
                    $output.='<p>Please click on the following link to verify your account.</p>';
                    $output.='<p>-------------------------------------------------------------</p>';
                    $output.='<p><a href="http://bhms.herokuapp.com/authentication/verify?token='.$user_registration_token.'&email='.$email.'&action=reset" target="_blank">
http://bhms.herokuapp.com/authentication/verify?key='.$user_registration_token.'&email='.$email.'&action=reset</a></p><br>';
                    $output.='<p>-------------------------------------------------------------</p>';
                    $output.='<p>Please be sure to copy the entire link into your browser.
The link will expire after 1 day for security reason.</p>';

                    $output.='<p>Thanks,</p>';
                    $output.='<p>Tomai water supplies</p>';
                    $body = $output;
                    $subject = "Account Activation - Tomai water supplies";
                    $body = $output;
                    $mail->Subject= $subject;
                    $mail->Body = $body;


//        $headers = array ('From' => $from, 'To' => $to,'Subject' => $subject, 'MIME-Version' => 1,
//            'Content-type' => 'text/html;charset=iso-8859-1');
                    if (!$mail->send()) {
                        $msg="ERROR: " . $mail->ErrorInfo;
                        $msg_class="alert-danger";
                    } else {
                         $sql = "INSERT INTO admin_user SET username='$username',email='$email',password='$hash',token='$user_registration_token'";
                if (mysqli_query($conn, $sql)) {
                    $msg = "Registered successfully.Check email for account activation";
                    $msg_class = "alert-success";
                        
                    }
                }



                } else {
                    $msg = "There was an Error in the database";
                    $msg_class = "alert-danger";
                }
            }
        }
    }

}}}}
?>