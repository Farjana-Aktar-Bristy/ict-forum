<?php include 'includes/navbar.php'; ?>
<?php
$token = NULL;
$email = NULL;
if (isset($_GET['email'])) {
    $email = $_GET['email'];
}
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    if (isTokenValid($email, $token) == "false") {
        echo '<div class="container"><p><h5 style="color:red; text-align:center;">Token invalid</h5></p></div>';
        exit();
    }
}

if (isTokenValid($email, $token) == "true") {
    ?>

    <div class="container">
        <div class="col-lg-6 col-md-6 col-sm-6 offset-lg-3 offset-md-3 offset-sm-3" style="border: 1px solid darkblue; padding: 25px;">

            <form id="recover-password-form" action="#" method="post" role="form">
                <input type="hidden" name="recover-password-submit"/>
                <input type="hidden" name="email" value="<?php echo '' . $email; ?>"/>
                <h5 style="background-color: lightgray; padding: 10px; text-align: center; color: darkblue; margin: -25px -25px 25px -25px;">Recover Password</h5>
                <div class="alert alert-danger" id="notif-div" style="margin: 5px; display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong id="notif"></strong>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-prepend">
                        <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-lock"></i></div>
                    </span>
                    <input id="password" class="form-control py-2 border-left-0 border" type="password" name="password" 
                           placeholder="New Password" required/>
                </div>
                <div class="input-group mt-3">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Submit</button>
                </div>
            </form>
        </div>
        <?php include 'includes/footer.php' ?>
    </div>
<?php } ?>
<?php
if (isset($_POST['recover-password-submit'])) {
    $email = $_POST['email'];
    $newPassword = $_POST['password'];
    $recoverPassword = recoverPassword($email,$newPassword);
    if($recoverPassword == "success") {
        header("Location:login.php?passwordRecoverySuccess=true");
    }
}
?>
