<?php
include 'includes/navbar.php';
?>
<?php
$questionId = NULL;
$notifId = NULL;
if (isset($_GET['questionId'])) {
    $questionId = $_GET['questionId'];
}
if (isset($_GET['notifId'])) {
    $notifId = $_GET['notifId'];
    notifViewed($notifId);
}
?>

<div class="container">
    <?php include 'includes/search.php' ?>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-lg-10 offset-md-1 offset-lg-1">
            <div class="alert alert-success" id="msg-div" style="margin: 5px; display: none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong id="msg"></strong>
            </div>
            <div class="alert alert-danger" id="error-div" style="margin: 5px; display: none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong id="error-msg"></strong>
            </div>
            <?php
            $questionDetails = getQuestionDetails($questionId);
            if ($questionDetails == "") {
                echo '<h5 style="color:darkred;">No Question Found</h5>';
            } else {
                $row = mysqli_fetch_assoc($questionDetails);
                ?>
                <div class="row mt-1">
                    <div class="col-lg-11 col-md-11">
                        <h4><?php echo '' . $row['title']; ?></h4>
                    </div>
                    <div class="col-lg-1 col-md-1 d-flex justify-content-end">
                        <p><?php
                            if (isset($_SESSION['userName'])) {
                                if ($_SESSION['userName'] == $row['user_name']) {
                                    ?>
                                    <a style="cursor: pointer; font-size: 20px;" onclick="showDeleteQuestionModal(<?php echo "'deleteQuestion.php?questionId=" . $row['question_id'] . '&&userName=' . $row['user_name'] . "'"; ?>)"><i style="color: red; margin-top: 5px; margin-right: 15px;" class = "fa fa-trash" title = "delete this question"></i></a>
                                    <?php
                                }
                            }
                            ?></p>
                    </div>

                </div>
                <div class="row m-1 mt-1">
                    <p><span style="color: gray;">Asked on: </span><?php echo '' . date_format(date_create($row["date"]), "F d, Y"); ?></p>
                    <p style="margin-left: 10px; padding-left: 10px; border-left: 1px solid gray;"><span style="color: gray;">Asked by: </span><?php echo '<a href="userDetails.php?username=' . $row['user_name'] . '">' . $row['user_name'] . '</a>' ?></p>
                </div>
                <div class="row m-1 mt-1">
                    <?php
                    $tagsOfQuestion = getTagsOfQuestion($row['question_id']);
                    foreach ($tagsOfQuestion as $key => $value) {
                        echo '<a href="questions.php?tagId=' . $key . '"><span class="questions-tag">' . $value . '</span></a>';
                    }
                    ?>
                </div>
                <div class="dropdown-divider sidebar"></div>
                <div class="row m-1 mt-1">
                    <div class="col-lg-1 col-md-1 col-sm-1">
                        <div class="row d-flex justify-content-center"><span class="vote-btn"><i id="up_vote_btn" class="fa fa-caret-up" title="This question is useful"></i></span></div>
                        <div class="row d-flex justify-content-center"><span id="question-vote-count" style="font-size: 30px;"><?php echo '' . getQuestionVoteCount($questionId); ?></span></div>
                        <div class="row d-flex justify-content-center"><span class="vote-btn"><i id="down_vote_btn" class="fa fa-caret-down" title="This question is not useful"></i></span></div>
                    </div>
                    <div class="col-lg-11 col-md-11 col-sm-11">
                        <p><?php echo '' . $row['question_body']; ?></p>
                    </div>
                </div>
                <?php
                $answers = getAnswers($questionId);
                if ($answers != "") {
                    $ansCount = getAnswersCount($questionId);
                    $ansCountRow = mysqli_fetch_assoc($ansCount);
                    ?>
                    <div class="row m-1 mt-1">
                        <h5><?php echo '' . $ansCountRow['ans_count'] . ' '; ?>Answer<?php if ($ansCountRow['ans_count'] > 1) echo 's'; ?></h5>
                    </div>
                    <?php
                    while ($row = mysqli_fetch_assoc($answers)) {
                        ?>
                        <div class="dropdown-divider sidebar"></div>
                        <div class="row m-1 mt-1">
                            <div class="col-md-10 d-flex justify-content-start">
                                <p><span style="color: gray;">Answered on: </span><?php echo '' . date_format(date_create($row["date"]), "F d, Y"); ?></p>
                                <p style="margin-left: 10px; padding-left: 10px; border-left: 1px solid gray;"><span style="color: gray;">Answered by: </span><?php echo '<a href="userDetails.php?username=' . $row['user_name'] . '">' . $row['user_name'] . '</a>' ?></p>
                            </div>
                            <div class="col-md-2 d-flex justify-content-end">
                                <p><?php
                                    if (isset($_SESSION['userName'])) {
                                        if ($_SESSION['userName'] == $row['user_name']) {
                                            ?>
                                            <a style="cursor: pointer; font-size: 20px;" onclick="showDeleteAnsModal(<?php echo "'deleteAns.php?answerId=" . $row['answer_id'] . '&&questionId=' . $questionId . '&&userName=' . $row['user_name'] . "'"; ?>)"><i style="color: red; margin-top: 5px;" class = "fa fa-trash" title = "delete this answer"></i></a>
                                            <?php
                                        }
                                    }
                                    ?></p>
                            </div>
                        </div>
                        <div class="row m-1 mt-1">
                            <div class="col-lg-1 col-md-1 col-sm-1">
                                <div class="row d-flex justify-content-center"><span class="vote-btn"><i id="<?php echo 'up-' . $row['answer_id']; ?>" class="ans_up_vote_btn fa fa-caret-up" title="This answer is useful"></i></span></div>
                                <div class="row d-flex justify-content-center"><span id="ans-vote-count-<?php echo '' . $row['answer_id']; ?>"  style="font-size: 15px;"><?php echo '' . getAnswerVoteCount($row['answer_id']); ?></span></div>
                                <div class="row d-flex justify-content-center"><span class="vote-btn"><i id="<?php echo 'down-' . $row['answer_id']; ?>" class="ans_down_vote_btn fa fa-caret-down" title="This answer is not useful"></i></span></div>
                            </div>
                            <div class="col-lg-11 col-md-11 col-sm-11">
                                <div class="row">
                                    <p><?php echo '' . $row['answer_body']; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }

                if (isset($_SESSION['userName'])) {
                    ?>
                    <form id="answer-form" action="saveAnswer.php" method="post">
                        <input type="hidden" name="answer-submitted"/>
                        <input type="hidden" name="questionId" value="<?php echo '' . $questionId; ?>"/>
                        <div class="row mt-2 m-1">
                            <h5>Your Answer:</h5>
                            <textarea name="editor1" required></textarea>
                        </div>
                        <div class="row mt-2 m-1">
                            <button type="submit" class="btn btn-primary" style="width: 100%;">Submit your answer</button>   
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="row alert alert-info mt-2 m-1 d-flex justify-content-center" style="text-align: center;">
                            You have to login for giving answer to this question.
                        </div>
                        <?php
                    }
                    ?>
                </form>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
    include 'includes/footer.php';
    if (isset($_GET['error'])) {
        ?>
        <script>
            $('#error-msg').empty();
            $('#error-msg').append("You can't submit empty answer.");
            $('#error-div').fadeIn(500).delay(10000).fadeOut(500);
        </script>
        <?php
    }
    ?>

    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <!--                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Delete answer!!</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>-->
                <div id="modal-body-text" class="modal-body">

                </div>
                <div class="modal-footer">
                    <a id="modal-yes-btn" class="btn btn-primary">Yes</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="notif-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div id="notif-text" class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Okay</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replace('editor1', {
        height: 200,
        filebrowserUploadUrl: 'ckeditor/ckImageUpload.php',
        filebrowserUploadMethod: 'form'
    });</script>
<script>
    function showDeleteAnsModal(url) {
        console.log(url);
        $('#delete-modal').modal();
        setTimeout(function () {
            $("#modal-yes-btn").attr("href", url);
            $("#modal-body-text").empty();
            $("#modal-body-text").append("Do you want to delete this answer?");
        }, 50);
    }

    function showDeleteQuestionModal(url) {
        console.log(url);
        $('#delete-modal').modal();
        setTimeout(function () {
            $("#modal-yes-btn").attr("href", url);
            $("#modal-body-text").empty();
            $("#modal-body-text").append("Do you want to delete this question?");
        }, 50);
    }
</script>
<?php
if (isset($_GET['msg'])) {
    ?>
    <script>
        $('#msg').empty();
        $('#msg').append("Answer deleted successfully.");
        $('#msg-div').fadeIn(500).delay(10000).fadeOut(500);</script>
    <?php
}
?>
<?php if (!isset($_SESSION['userName'])) { ?>
    <script>
        $('#up_vote_btn').click(function () {
            $('#notif-modal').modal();
            setTimeout(function () {
                $("#notif-text").empty();
                $("#notif-text").append("You have to login to vote");
            }, 50);
        });</script>
<?php } else { ?>
    <script>
        $('#up_vote_btn').click(function () {
            $.ajax({
                url: 'questionVote.php',
                type: 'get',
                data: {"questionId": <?php echo $questionId; ?>,
                    "upvote": "true"
                },
                success: function (response) {
                    if (response === "") {
                        $('#notif-modal').modal();
                        setTimeout(function () {
                            $("#notif-text").empty();
                            $("#notif-text").append("You've already given up-vote to this question.");
                        }, 50);
                    } else {
                        $('#question-vote-count').html(response);
                    }
                }
            });
        });</script>
<?php } ?>
<?php if (!isset($_SESSION['userName'])) { ?>
    <script>
        $('#down_vote_btn').click(function () {
            $('#notif-modal').modal();
            setTimeout(function () {
                $("#notif-text").empty();
                $("#notif-text").append("You have to login to vote");
            }, 50);
        });</script>
<?php } else { ?>
    <script>
        $('#down_vote_btn').click(function () {
            $.ajax({
                url: 'questionVote.php',
                type: 'get',
                data: {"questionId": <?php echo $questionId; ?>,
                    "downvote": "true"
                },
                success: function (response) {
                    if (response === "") {
                        $('#notif-modal').modal();
                        setTimeout(function () {
                            $("#notif-text").empty();
                            $("#notif-text").append("You've already given down-vote to this question.");
                        }, 50);
                    } else {
                        $('#question-vote-count').html(response);
                    }
                }
            });
        });</script>
<?php } ?>

<?php if (!isset($_SESSION['userName'])) { ?>
    <script>
        $('.ans_up_vote_btn').click(function () {
            $('#notif-modal').modal();
            setTimeout(function () {
                $("#notif-text").empty();
                $("#notif-text").append("You have to login to vote");
            }, 50);
        });</script>
<?php } else { ?>
    <script>
        $('.ans_up_vote_btn').click(function () {
            var id = $(this).attr('id');
            var ansId = id.substring(3, id.length);
            $.ajax({
                url: 'answerVote.php',
                type: 'get',
                data: {"answerId": ansId,
                    "upvote": "true"
                },
                success: function (response) {
                    if (response === "") {
                        $('#notif-modal').modal();
                        setTimeout(function () {
                            $("#notif-text").empty();
                            $("#notif-text").append("You've already given up-vote to this answer.");
                        }, 50);
                    } else {
                        $('#ans-vote-count-' + ansId).html(response);
                    }
                }
            });
        });
    </script>
<?php } ?>
<?php if (!isset($_SESSION['userName'])) { ?>
    <script>
        $('.ans_down_vote_btn').click(function () {
            $('#notif-modal').modal();
            setTimeout(function () {
                $("#notif-text").empty();
                $("#notif-text").append("You have to login to vote");
            }, 50);
        });</script>
<?php } else { ?>
    <script>
        $('.ans_down_vote_btn').click(function () {
            var id = $(this).attr('id');
            var ansId = id.substring(5, id.length);
            $.ajax({
                url: 'answerVote.php',
                type: 'get',
                data: {"answerId": ansId,
                    "downvote": "true"
                },
                success: function (response) {
                    if (response === "") {
                        $('#notif-modal').modal();
                        setTimeout(function () {
                            $("#notif-text").empty();
                            $("#notif-text").append("You've already given up-vote to this answer.");
                        }, 50);
                    } else {
                        $('#ans-vote-count-' + ansId).html(response);
                    }
                }
            });
        });</script>
<?php } ?>
<script>hljs.initHighlightingOnLoad();</script>