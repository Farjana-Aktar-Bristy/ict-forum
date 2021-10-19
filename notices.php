<?php
include 'includes/navbar.php';
$header = NULL;
$notices = NULL;
$userName = NULL;
if (isset($_SESSION['userName'])) {
    $userName = $_SESSION['userName'];
} else {
    header("Location: login.php");
}
?>
<!--<div class="container fixed-top" style="margin-top:65px; margin-bottom: 10px; border-top: 1px solid white;">
    <?php // include 'includes/search.php' ?>
</div>-->
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="row">
            <div class="alert alert-success" id="msg-div" style="margin: 5px; display: none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong id="msg"></strong>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="bg-light" style="align-content: center; text-align: center;">
                <!--                <div class="dropdown-divider sidebar"></div>
                                <a id="posts-sidemenu" class="dropdown-item sidebar" href="#">Posts</a>-->
                <div class="dropdown-divider sidebar"></div>
                <a id="notices-sidemenu" class="dropdown-item sidebar" href="notices.php?criteria=new">Notices</a>
                <div class="dropdown-divider sidebar"></div>
                <a id="tags-sidemenu" class="dropdown-item sidebar" href="tags.php">Tags</a>
                <div class="dropdown-divider sidebar"></div>
                <a id="users-sidemenu" class="dropdown-item sidebar" href="users.php">Users</a>
                <div class="dropdown-divider sidebar"></div>
            </div>
        </div>
        <div class="col-md-10" id="content">
            <div class="row m-1 mt-1">
                <div class="col-md-6 col-sm-6">
                    <h4>
                        <?php
                        if (isset($_GET['criteria'])) {
                            $criteria = $_GET['criteria'];
                            if ($_GET['criteria'] == 'new') {
                                $header = '<h5>New Notices</h5>';
                            } elseif ($_GET['criteria'] == 'week') {
                                $header = '<h5>Notices posted in this week</h5>';
                            } elseif ($_GET['criteria'] == 'month') {
                                $header = '<h5>Notices posted in this month</h5>';
                            }
                        } else {
                            $criteria = 'new';
                            $header = '<h5>New Notices</h5>';
                        }
                        ?>
                    </h4>
                </div>
                <div class="col-md-6 col-sm-6 d-flex justify-content-end align-items-center">
                    <div class="btn-group" role="group">
                        <a href="notices.php?criteria=new" class="btn btn-secondary border-dark">New</a>
                        <a href="notices.php?criteria=week" class="btn btn-secondary border-dark">Week</a>
                        <a href="notices.php?criteria=month" class="btn btn-secondary border-dark">Month</a>
                    </div>
                </div>
            </div>
            <div class="dropdown-divider sidebar" style=" margin-bottom: 10px;"></div>
            <?php
            if ($criteria == 'new') {
                $notices = getNewNotices($userName);
            } elseif ($criteria == 'week') {
                $notices = getNoticesOfWeek($userName);
            } elseif ($criteria == 'month') {
                $notices = getNoticesOfMonth($userName);
            }
            if ($notices == "") {
                echo '<h5 style="color:darkred;">No Notice Found</h5>';
            } else {
                ?>
                <table id="notice-table" class="table table-bordered" style="width:100%;">
                    <thead>
                    <th style="text-align: center;"><?php echo '' . $header; ?></th>
                    <th class="hidden"></th>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($notices)) {
                            $isViewed = isViewed($row['notice_id'], $userName);
                            ?>
                            <tr <?php if ($isViewed == 'unviewed') echo 'style="background-color: lightgrey"'; ?>>
                                <td>
                                    <div class="m-1 ml-4">
                                        <div class="row">
                                            <p><span style="color: gray;">Posted on: </span><?php echo '' . date_format(date_create($row["date"]), "F d, Y"); ?></p>
                                            <p style="margin-left: 10px; padding-left: 10px; border-left: 1px solid gray;"><span style="color: gray;">Posted by: </span><?php echo '<a href="userDetails.php?username=' . $row['user_name'] . '">' . $row['user_name'] . '</a>' ?></p>
                                        </div>
                                        <!--<div class="dropdown-divider sidebar mb-1"></div>-->

                                        <div class="row">
                                            <?php echo '<a href="noticeDetails.php?noticeId=' . $row['notice_id'] . '"><h5>' . $row['title'] . '</h5></a>'; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden"><?php echo '' . $row['date']; ?></td>
                            </tr>

                        <?php }
                        ?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            <?php }
            ?>
        </div>
        
    </div>
    <?php include 'includes/footer.php' ?>
</div>
<script>
    $(document).ready(function () {
        $('.sidebar').removeClass('active');
        $('#notices-sidemenu').addClass('active');
    });
    $(document).ready(function () {
        $('#notice-table').dataTable({
            "order": [1, 'desc'],
            "columnDefs": [
                {
                    "targets": [1],
                    "visible": false
                }
            ]
        });
    });
</script>

<?php
if (isset($_GET['msg'])) {
    ?>
    <script>
        $('#msg').empty();
        $('#msg').append("Notice deleted successfully.");
        $('#msg-div').fadeIn(500).delay(10000).fadeOut(500);
    </script>
    <?php
}
?>
