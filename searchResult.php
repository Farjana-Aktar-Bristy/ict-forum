<?php
include 'includes/navbar.php';
$criteria = NULL;
$questions = NULL;
$tagsOfQuestion = NULL;
$searchValue = NULL;
if (isset($_GET['search_value'])) {
    $searchValue = $_GET['search_value'];
}
?>
<div class="container">
    <?php include 'includes/search.php' ?>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1" id="content">
            <table id="search-result" class="table table-bordered" style="width:100%">
                <thead>
                <th style="text-align: center;"><h5>Search Result</h5></th> 
                </thead>
                <tbody>
                    <?php
                    $questions = getSearchedQuestions($searchValue);
                    if ($questions != "") {
                        while ($row = mysqli_fetch_assoc($questions)) {
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
        $('#search-result').DataTable();
    });
</script>
