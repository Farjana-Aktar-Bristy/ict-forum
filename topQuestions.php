<?php
include 'includes/navbar.php';
$criteria = NULL;
$questions = NULL;
$tagsOfQuestion = NULL;
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
        <div class="col-md-10" id="content">
            <div class="row m-1 mt-1">
                <div class="col-md-6 col-sm-6">
                    <h5>Top Questions</h5>
                </div>
                <div class="col-md-6 col-sm-6 d-flex justify-content-end align-items-center">
                    <div class="btn-group" role="group">
                        <a href="questions.php?criteria=new" class="btn btn-secondary border-dark">New</a>
                        <a href="topQuestions.php" class="btn btn-secondary border-dark">Top</a>
                        <a href="questions.php?criteria=week" class="btn btn-secondary border-dark">Week</a>
                        <a href="questions.php?criteria=month" class="btn btn-secondary border-dark">Month</a>
                    </div>
                </div>
            </div>
            <div class="dropdown-divider sidebar" style="margin-bottom: 10px;"></div>
            <table id="top-questions-table" class="table table-bordered" style="width:100%">
                <thead>
                <!--<th style="text-align: center;"><h5>Top Questions</h5></th>-->
                </thead>
                <tbody>
                    <?php
                    $questions = getTopQuestions();
                    foreach ($questions as $key => $row) {
                        $ansCount = getAnswersCount($row['question_id']);
                        $ansCountRow = mysqli_fetch_assoc($ansCount);
                        ?>
                        <tr>
                            <td>
                                <div class="m-1 ml-4 mt-1">
                                    <div class="row">
                                        <span style="color: gray; margin-right: 4px;">votes:</span><?php echo '' . getQuestionVoteCount($row['question_id']); ?>,
                                        <span style="color: gray; margin-left: 5px;margin-right: 4px;">answer<?php if ($ansCountRow['ans_count'] > 1) echo 's'; ?>:</span><?php echo '' . $ansCountRow['ans_count']; ?>
                                    </div>
                                    <div class="row mt-1">
                                        <?php echo '<a href="questionDetails.php?questionId=' . $row['question_id'] . '"><h5>' . $row['title'] . '</h5></a>'; ?>
                                    </div>
                                    <!--                        <div class="row">
                                    <?php //echo '<p>' . substr($row['question_body'], 0, 300) . '...' . '</p>';  ?>
                                                            </div>-->
                                    <div class="row">
                                        <?php
                                        $tagsOfQuestion = getTagsOfQuestion($row['question_id']);
                                        foreach ($tagsOfQuestion as $key => $value) {
                                            echo '<a href="questions.php?tagId=' . $key . '"><span class="questions-tag">' . $value . '</span></a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>
        
    </div>
    <?php include 'includes/footer.php' ?>
</div>
<script>
    $(document).ready(function () {
        $('.sidebar').removeClass('active');
    });
    $(document).ready(function () {
        $('#top-questions-table').DataTable();
    });
</script>
