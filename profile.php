<?php include 'includes/navbar.php'; ?>
<?php
$userId = NULL;
$userName = NULL;
if (isset($_SESSION['userName'])) {
    $userName = $_SESSION['userName'];
} else {
    header("Location:login.php?page=profile.php");
}
$result = getUserDetails($userName);
$row = NULL;
if ($result != "") {
    $row = mysqli_fetch_assoc($result);
}
?>
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
<div class="container">
    <div class="row" style="margin: 5px;">
        <div class="col-lg-2 offset-lg-10">
            <a href="editProfile.php" class="btn btn-primary" style="width: 100%;">Edit Profile</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="row">
                <div class="col-md-8">
                    <img src="<?php
                    if ($row['profile_picture'] != "")
                        echo 'images/' . $row['profile_picture'];
                    else {
                        echo 'images/avatar.png';
                    }
                    ?>" class="img-fluid img-thumbnail rounded-circle" height="200px;" width="200px;"/>
                </div>
            </div>
            <div class="row m-2">
                <h3><?php echo '' . $row['fullname']; ?></h3>
            </div>
            <div class="row m-2">
                <?php
                if ($row['role'] == "STUDENT") {
                    echo '<h6>' . $row['student_id'] . ', ICT ' . $row['batch'] . ' Batch, MBSTU</h6>';
                } elseif ($row['role'] == "TEACHER") {
                    echo '<h6>' . $row['designation'] . ', Dept of ICT, MBSTU' . $row['batch'] . '</h6>';
                }
                ?>
            </div>
            <div class="dropdown-divider sidebar"></div>
            <div class="row" style="margin-top: 1px; margin-bottom: 1px;">
                <div class="col-md-3 col-sm-12">
                    Username:                </div>
                <div class="col-md-9 col-sm-12">
                    <strong><?php echo '' . $row['user_name']; ?></strong>
                </div>
            </div>
            <div class="dropdown-divider sidebar"></div>
            <div class="row" style="margin-top: 1px; margin-bottom: 1px;">
                <div class="col-md-3 col-sm-12">
                    Email:
                </div>
                <div class="col-md-9 col-sm-12">
                    <strong><?php echo '' . $row['email']; ?></strong>
                </div>
            </div>
            <div class="dropdown-divider sidebar"></div>
            <div class="row" style="margin-bottom: 1px; margin-top: 1px;">
                <div class="col-md-3 col-sm-12">
                    Expert in: 
                </div>
                <div class="col-md-9 col-sm-12">
                    <strong>
                        <?php
                        if ($row['expert_in'] != "")
                            echo '' . $row['expert_in'];
                        else {
                            echo 'Not specified';
                        }
                        ?>
                    </strong>
                </div>
            </div>
            <div class="dropdown-divider sidebar"></div>
            <div class="row" style="margin: 2px; margin-top: 8px;">
                <strong>Bio:</strong>
            </div>
            <div class="row" style="margin: 2px;">
                <p><?php echo '' . $row['description']; ?></p>
            </div>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8">
            <?php
            $questions = getQuestionsByUser($userName);
            if ($questions == "") {
                echo "<h4 style = 'text-align: center'>Haven't asked any question yet</h4>";
            } else {
                echo '<h4 style = "text-align: center">Asked questions</h4>';
                echo '<div class="dropdown-divider sidebar"></div>';
                while ($row = mysqli_fetch_assoc($questions)) {
                    $ansCount = getAnswersCount($row['question_id']);
                    $ansCountRow = mysqli_fetch_assoc($ansCount);
                    ?>
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
                    <div class="dropdown-divider sidebar"></div>
                    <?php
                }
            }
            ?>

            <?php
            $answeredQuestions = getAnsweredQuestionsByUser($userName);
            if ($answeredQuestions == "") {
                echo "<h4 style = 'text-align: center; margin-top: 30px;'>Haven't answered to any question yet</h4>";
            } else {
                echo '<h4 style = "text-align: center; margin-top: 30px;">Answered to following questions</h4>';
                echo '<div class="dropdown-divider sidebar"></div>';
                while ($row = mysqli_fetch_assoc($answeredQuestions)) {
                    $ansCount = getAnswersCount($row['question_id']);
                    $ansCountRow = mysqli_fetch_assoc($ansCount);
                    ?>
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
                    <div class="dropdown-divider sidebar"></div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</div>
<?php
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == "questionDeleted") {
        ?>
        <script>
            $('#msg').empty();
            $('#msg').append("Question deleted successfully.");
            $('#msg-div').fadeIn(500).delay(10000).fadeOut(500);
        </script>
        <?php
    } else if ($_GET['msg'] == "passwordChanged") {
        ?>
        <script>
            $('#msg').empty();
            $('#msg').append("Password Changed successfully.");
            $('#msg-div').fadeIn(500).delay(10000).fadeOut(500);
        </script>
        <?php
    }
}
?>