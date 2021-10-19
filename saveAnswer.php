<?php
include 'includes/navbar.php';
include 'findImagesName.php';
?>
<div class="container">
    <?php
    $content = NULL;
    $questionId = NULL;
    if (isset($_POST['answer-submitted'])) {
        $content = $_POST['editor1'];
        $questionId = $_POST['questionId'];
        if (trim($content, " ") == "") {
            header("Location: questionDetails.php?questionId=" . $questionId . "&&error=noQuestionBody");
            exit();
        } else {
            ?>
            <div class="container">
                <div class="row card card-body bg-light mt-2">
                    <h4 style="text-align: center;">Review your answer before submitting.</h4>
                </div>
                <div class="row card card-body bg-light mt-2">
                    <p><?php echo '' . $content; ?></p>
                </div>
            </div>
            <div class="card card-body bg-light mt-2">
                <div>
                    <h3 style="text-align: center;">Do you want to submit your answer?</h5>
                </div>
                <div class="row mt-2">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <a id="yes-btn" href="saveAnswer.php?option=yes" class="btn btn-primary" style="width: 100%;">Yes</a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <a id="no-btn" href="saveAnswer.php?option=no" class="btn btn-danger" style="width: 100%;">No</a>
                    </div>
                </div>
            </div>
            <?php
            $_SESSION['answerBody'] = '' . $content;
            $_SESSION['questionId'] = '' . $questionId;
        }
    }
    if (isset($_GET['option'])) {
        $option = $_GET['option'];
        if ($option == 'yes') {
            $answerBody = $_SESSION['answerBody'];
            $userName = $_SESSION['userName'];
            $questionId = $_SESSION['questionId'];
            saveAnswer($questionId, $userName, $answerBody);
            if ($questionId != '') {
                $_SESSION['answerBody'] = '';
                $_SESSION['questionId'] = '';
                header("Location:questionDetails.php?questionId=" . $questionId);
            }
        } elseif ($option == 'no') {
            $content = $_SESSION['answerBody'];
            $imagesAttachedToPost = findAttachedImagesToPost($content);
            for ($i = 0; $i < count($imagesAttachedToPost); $i++) {
                unlink("ckeditor/uploads/" . $imagesAttachedToPost[$i]);
            }
            $questionId = $_SESSION['questionId'];
            $_SESSION['questionId'] = '';
            $_SESSION['answerBody'] = '';
            header("Location:questionDetails.php?questionId=" . $questionId);
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
