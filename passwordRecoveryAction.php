<?php include 'includes/navbar.php'; ?>
<div class="container">
    <div class="col-md-8 offset-md-2">
        <p style="font-size: 20px; text-align: center;">
            <?php
            $email = NULL;
            if (isset($_GET['email'])) {
                $email = $_GET['email'];
            }
            ?>
            Password recovery link has been sent to your email address <?php echo '<a href="mailto:'.$email.'">' . $email . '</a>'; ?>.
            Please check your inbox and click that link to recover your password.
        </p>
    </div>
    <?php include 'includes/footer.php' ?>
</div>


