<?php include 'includes/navbar.php'; ?>

<div class="container">
    <div class="col-lg-6 col-md-6 col-sm-6 offset-lg-3 offset-md-3 offset-sm-3" style="border: 1px solid darkblue; padding: 25px;">

        <form id="chnage-password-form" action="#" method="post" role="form">
            <input type="hidden" name="change-password-submit"/>
            <h5 style="background-color: lightgray; padding: 10px; text-align: center; color: darkblue; margin: -25px -25px 25px -25px;">Change Password</h5>
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
                <input id="current-password" class="form-control py-2 border-left-0 border" type="password" name="currentPassword" 
                       placeholder="Current Password" required/>
            </div>
            <div class="input-group mt-3">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0"><i class="fa fa-lock"></i></div>
                </span>
                <input id="password" class="form-control py-2 border-left-0 border" type="password" name="newPassword" 
                       placeholder="New Password" required/>
            </div>
            <div class="input-group mt-3">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Submit</button>
            </div>
        </form>
    </div>
    <?php include 'includes/footer.php' ?>
</div>

<?php
$currentPassword = NULL;
$newPassword = NULL;
$userName = NULL;
if (isset($_SESSION['userName'])) {
    $userName = $_SESSION['userName'];
}
if (isset($_POST['currentPassword'])) {
    $currentPassword = $_POST['currentPassword'];
}
if (isset($_POST['newPassword'])) {
    $newPassword = $_POST['newPassword'];
}
if (isset($_POST['change-password-submit'])) {
    $result = changePassword($userName, $currentPassword, $newPassword);
    if ($result == "passwordMismatch") {
        ?>
        <script>
            $('#notif').empty();
            $('#notif').append("Current password doesn't match");
            $('#notif-div').fadeIn(500).delay(10000).fadeOut(500)
        </script>
        <?php
    } else {
        header("Location: profile.php?msg=passwordChanged");
    }
}
?>
