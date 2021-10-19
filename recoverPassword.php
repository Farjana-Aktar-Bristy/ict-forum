<?php
include 'includes/navbar.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
?>

<div class="container">
    <div class="col-lg-6 col-md-6 col-sm-6 offset-lg-3 offset-md-3 offset-sm-3" style="border: 1px solid darkblue; padding: 25px;">

        <form id="recover-password-form" action="#" method="post" role="form">
            <input type="hidden" name="recover-password-submit"/>
            <h5 style="background-color: lightgray; padding: 10px; text-align: center; color: darkblue; margin: -25px -25px 25px -25px;">Recover Password</h5>
            <p>Enter your email. We will send you a link to recover your password.</p>
            <div class="alert alert-danger" id="notif-div" style="margin: 5px; display: none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong id="notif"></strong>
            </div>
            <div class="input-group mt-3">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-envelope"></i></div>
                </span>
                <input id="email" class="form-control py-2 border-left-0 border" type="text" name="email" 
                       placeholder="Email" required/>
            </div>
            <div class="input-group mt-3">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Submit</button>
            </div>
        </form>
    </div>
    <?php include 'includes/footer.php' ?>
</div>

<?php
$email = NULL;
$isEmailExist = NULL;
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}
if (isset($_POST['recover-password-submit'])) {
    $isEmailExist = emailExists($email);
    if ($isEmailExist == "false") {
        ?>
        <script>
            $('#notif').empty();
            $('#notif').append("email doesn't exist");
            $('#notif-div').fadeIn(500).delay(10000).fadeOut(500)
        </script>
        <?php
    } else {
        $token = bin2hex(random_bytes(50));
        $to = $email;
        $subject = "Reset your password on ict_forum";
        $msg = 'Please click on this <a href="localhost/ict_forum/passwordRecoveryByEmail.php?token=' . $token . '&&email=' . $email . '">link</a> to reset your password on our site';
        $emailUsername = 'ict.forum.mbstu@gmail.com';
        $emailPassword = 'deptofict2020';
        try {
            $mail = new PHPMailer(TRUE);
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = $emailUsername;                     // SMTP username
            $mail->Password = $emailPassword;                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587;
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $msg;
            $mail->setFrom($emailUsername);
            $mail->addAddress($to);
            if ($mail->send()) {
                insertPasswordResetToken($email, $token);
                header("Location:passwordRecoveryAction.php?email=$email");
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>
