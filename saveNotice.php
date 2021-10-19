<?php
include 'includes/navbar.php';
?>
<div class="container">
    <?php
    $content = NULL;
    $title = NULL;
    $batch = NULL;
    if (isset($_POST['notice-submitted'])) {
        $content = $_POST['notice'];
        $title = $_POST['title'];
        $batch = $_POST['batch'];
        if (trim($content, " ") == "") {
            header("Location: addNotice.php?error=emptyNoticeBody&&title=$title");
            exit();
        } else {
            ?>
            <div class="container">
                <div class="row card card-body bg-light mt-2">
                    <h4 style="text-align: center;">Review notice before submitting.</h4>
                </div>
                <div class="row card card-body bg-light mt-2">
                    <p><?php echo '<b>Notice for : ICT-' . $batch . ' batch</b>'; ?></p>
                </div>
                <div class="row card card-body bg-light mt-2">
                    <p><?php echo '<b>Title:</b> ' . $title; ?></p>
                </div>
                <div class="row card card-body bg-light mt-2">
                    <p><?php echo '<b>Notice:</b> <br/>' . $content; ?></p>
                </div>
            </div>
            <div class="card card-body bg-light mt-2">
                <div>
                    <h3 style="text-align: center;">Do you want to save notice?</h5>
                </div>
                <div class="row mt-2">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <a id="yes-btn" href="saveNotice.php?option=yes" class="btn btn-primary" style="width: 100%;">Yes</a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <a id="no-btn" href="saveNotice.php?option=no" class="btn btn-danger" style="width: 100%;">No</a>
                    </div>
                </div>
            </div>
            <?php
            $_SESSION['noticeBody'] = '' . $content;
            $_SESSION['title'] = '' . $title;
            $_SESSION['$batch'] = '' . $batch;
        }
    }
    if (isset($_GET['option'])) {
        $option = $_GET['option'];
        if ($option == 'yes') {
            $noticeBody = $_SESSION['noticeBody'];
            $title = $_SESSION['title'];
            $batch = $_SESSION['$batch'];
            $userName = $_SESSION['userName'];
            $noticeId = saveNotice($userName, $title, $noticeBody, $batch);
            $_SESSION['noticeBody'] = '';
            $_SESSION['title'] = '';
            $_SESSION['$batch'] = '';
            header("Location: noticeDetails.php?noticeId=$noticeId");
        } elseif ($option == 'no') {
            header("Location: index.php");
        }
    }
    ?>
    <script>hljs.initHighlightingOnLoad();</script>
    <script>
        var unsaved = true;
        $('#yes-btn').click(function () {
            unsaved = false;
        });
        $('#no-btn').click(function () {
            unsaved = false;
        });

        function unloadPage() {
            if (unsaved) {
                return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
            }
        }
        window.onbeforeunload = unloadPage;
    </script>
    <?php include 'includes/footer.php' ?>
</div>
<script>hljs.initHighlightingOnLoad();</script>
