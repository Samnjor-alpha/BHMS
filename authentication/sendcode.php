<?php

use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/autoload.php';
include 'vcode.php';
function get_include_contents($filename, $variablesToMakeLocal) {
    extract($variablesToMakeLocal);
    if (is_file($filename)) {
        ob_start();
        include $filename;
        return ob_get_clean();
    }
    return false;
}
$expFormat = mktime(
date("H"), date("i")+15, date("s"), date("m") ,date("d"), date("Y")
);
$expDate = date("Y-m-d H:i:s",$expFormat);


// Insert Temp Table

$mail = new PHPMailer;
$mail->isSMTP();
$mail = new PHPMailer(true);


$mail->IsSMTP();
$mail->SMTPDebug = 2;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Host = "mail.developforme.co.ke";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->Username = 'bhmsnoreply@developforme.co.ke';
$mail->Password = '@dfm2021Ke.';
$mail->setFrom('bhmsnoreply@developforme.co.ke');

try {
    $mail->setFrom('myemail@gmail.com');
} catch (\PHPMailer\PHPMailer\Exception $e) {
}
$mail->addAddress($row['email']);
$subject = "Verification Code - Tomai water supplies";
$body = file_get_contents('email_template.html');
$body = str_replace('$vcodee', $vcodee, $body);

// strip backslashes
$body = preg_replace('/\\\\/', '', $body);
// mail settings below including these:
$mail->MsgHTML($body);
$mail->Subject = $subject;
$mail->IsHTML(true); // send as HTML
$mail->CharSet="utf-8"; // use utf-8 character encoding

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
mail($mail->addAddress($row['email']), $subject, $body, $headers);
    if (!$mail->send()) {
    $msg="ERROR: " . $mail->ErrorInfo;
    $msg_class="alert-danger";
    } else {
    mysqli_query($conn,  "INSERT INTO auth_code (admin_id, verify_code, expDate) VALUES ('".$row['a_id']."', '".$vcodee."', '".$expDate."');");
    echo "<script type='text/javascript'>
        //  					swal('', 'Verification send successfully.Press okey to continue', 'success').then(function() {
        //  					window.location.href='2factorauth.php';
        //  					});
        alert('Verification send successfully.Press okey to continue');
        window.location.href='2factorauth.php';
    </script>";
    }
