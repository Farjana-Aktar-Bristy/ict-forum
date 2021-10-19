<?php
include 'includes/navbar.php';
?>
<!--<div class="container fixed-top" style="margin-top:65px; margin-bottom: 10px; border-top: 1px solid white;">
<?php // include 'includes/search.php' ?>
</div>-->
<div class="container">
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
        <div class="col-md-8" id="content">
            <table id="tags" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <!--<th>Description</th>-->
                        <th style="font-size: 12px;">Total Questions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $allTag = getAllTag();
                    while ($row = mysqli_fetch_assoc($allTag)) {
                        $questionCountByTag = getQusetionCountByTag($row['tag_id']);
                        $questionCountByTagRow = mysqli_fetch_assoc($questionCountByTag);
                        ?>
                        <tr>
                            <td><a href="<?php echo 'questions.php?tagId=' . $row['tag_id']; ?>"><?php echo '' . $row['tag_name']; ?></a></td>
                            <!--<td>Best programming language in the world.</td>-->
                            <td style="text-align: center; font-weight: bold;"><?php echo '' . $questionCountByTagRow['question_count_by_tag']; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <!--<th>Description</th>-->
                        <th style="font-size: 12px;">Total Questions</th>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
    <?php include 'includes/footer.php' ?>
</div>
<script>
    $(document).ready(function () {
        $('.sidebar').removeClass('active');
        $('#tags-sidemenu').addClass('active');
    });

</script>

<script>
    $(document).ready(function () {
        $('#tags').DataTable({
            bAutoWidth: false,
            aoColumns: [
                {sWidth: '80%'},
                {sWidth: '20%'}
            ]
        });
//        $('input').addClass('form-control');
//        $('select').addClass('form-control');
    });
</script>
