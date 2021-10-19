<?php
include 'includes/navbar.php';
?>
<?php
$noticeId = NULL;
$userName = NULL;
if (isset($_SESSION['userName'])) {
    $userName = $_SESSION['userName'];
} else {
    header("Location: login.php");
}
if (isset($_GET['noticeId'])) {
    $noticeId = $_GET['noticeId'];
}
?>
<div class="container">
    <?php include 'includes/search.php' ?>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-lg-10 offset-md-1 offset-lg-1">
            <?php
            $noticeDetails = getNoticeDetails($noticeId);
            if ($noticeDetails == "") {
                echo '<h5 style="color:darkred;">No Notice Found</h5>';
            } else {
                $row = mysqli_fetch_assoc($noticeDetails);
                ?>
                <div class="row m-1 mt-1">
                    <h5><?php echo 'Notice for ICT-' . $row['batch'] . ' Batch'; ?></h5>
                </div>
                <div class="row m-1 mt-1">
                    <p><span style="color: gray;">Posted on: </span><?php echo '' . date_format(date_create($row["date"]), "F d, Y"); ?></p>
                    <p style="margin-left: 10px; padding-left: 10px; border-left: 1px solid gray;"><span style="color: gray;">Posted by: </span><?php echo '<a href="userDetails.php?username=' . $row['user_name'] . '">' . $row['user_name'] . '</a>' ?></p>
                </div>
                <div class="dropdown-divider sidebar mb-1"></div>
                <div class="row mt-1">
                    <div class="col-lg-11 col-md-11">
                        <h4><?php echo '' . $row['title']; ?></h4>
                    </div>

                    <div class="col-lg-1 col-md-1 d-flex justify-content-end">
                        <p><?php
                            if (isset($_SESSION['userName'])) {
                                if ($_SESSION['userName'] == $row['user_name']) {
                                    ?>
                                    <a style="cursor: pointer; font-size: 20px;" href="<?php echo "deleteNotice.php?noticeId=" . $row['notice_id'] . '&&userName=' . $row['user_name']; ?>"><i style="color: red; margin-top: 5px; margin-right: 15px;" class = "fa fa-trash" title = "delete this question"></i></a>
                                    <?php
                                }
                            }
                            ?></p>
                    </div>

                </div>
                <div class="dropdown-divider sidebar"></div>
                <div class="row m-1 mt-1">
                    <p><?php echo '' . $row['notice_body']; ?></p>
                </div>

                <?php
            }
            ?>
        </div>
    </div>
</div>
<?php
noticeViewed($noticeId, $userName);
?>
<script>hljs.initHighlightingOnLoad();</script>