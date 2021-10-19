<?php include 'includes/navbar.php'; ?>

<div class="container">
    <div class="col-lg-6 col-md-6 col-sm-6 offset-lg-3 offset-md-3 offset-sm-3" style="border: 1px solid darkblue; padding: 25px;">

        <form id="login-form" action="#" method="post" role="form">
            <input type="hidden" name="login-submit"/>
            <h5 style="background-color: lightgray; padding: 10px; text-align: center; color: darkblue; margin: -25px -25px 25px -25px;">Login</h5>
            <div class="alert alert-danger" id="notif-div" style="margin: 5px; display: none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong id="notif"></strong>
            </div>
            <div class="alert alert-success" id="notif-msg-div" style="margin: 5px; display: none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong id="notif-msg"></strong>
            </div>
            <div class="input-group mt-3">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-user"></i></div>
                </span>
                <input id="username-or-email" class="form-control py-2 border-left-0 border" type="text" name="usernameOrEmail" 
                       placeholder="Username or Email" required/>
            </div>
            <div class="input-group mt-3">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-lock"></i></div>
                </span>
                <input id="password" class="form-control py-2 border-left-0 border" type="password" name="password" 
                       placeholder="Password" required/>
            </div>
            <div class="input-group mt-3">
                <a href="recoverPassword.php">Forgot Password?</a>
            </div>
            <div class="input-group mt-3">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Submit</button>
            </div>
        </form>
    </div>
    <?php include 'includes/footer.php' ?>
</div>

<?php
$usernameOrEmail = NULL;
$password = NULL;
$frompage = NULL;
if (isset($_GET['page'])) {
    $frompage = $_GET['page'];
} else {
    $frompage = "index.php";
}
if (isset($_POST['usernameOrEmail'])) {
    $usernameOrEmail = $_POST['usernameOrEmail'];
}
if (isset($_POST['password'])) {
    $password = $_POST['password'];
}
if (isset($_POST['login-submit'])) {
    $result = login($usernameOrEmail, $password, $frompage);
    if ($result == "userNotFound") {
        ?>
        <script>
            $('#notif').empty();
            $('#notif').append('Incorrect username/email or password');
            $('#notif-div').fadeIn(500).delay(10000).fadeOut(500)
        </script>
        <?php
    }
}
if (isset($_GET['passwordRecoverySuccess'])) {
    ?>
    <script>
        $('#notif-msg').empty();
        $('#notif-msg').append('Password recovered. Please login');
        $('#notif-msg-div').fadeIn(500).delay(10000).fadeOut(500)
    </script>
    <?php
}
?>
