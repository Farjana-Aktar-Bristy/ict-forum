<?php
include 'includes/navbar.php';
include 'findImagesName.php';
?>
<div class="container">
    <?php
    $title = NULL;
    $content = NULL;
    $tags = NULL;
    if (isset($_POST['question-submitted'])) {
        $title = $_POST['title'];
        $content = $_POST['editor1'];
        $tags = $_POST['tags-form-input'];
        if (trim($content, " ") == "") {
            header("Location: askQuestion.php?error=no_content&&title=" . $_POST['title']);
            exit();
        } else {
            ?>
            <div class="container">
                <div class="row card card-body bg-light mt-2">
                    <h4 style="text-align: center;">Review your question before posting.</h4>
                </div>
                <div class="row card card-body bg-light mt-2">
                    <h6><span style="font-weight: bold;">Title:</span> <?php echo '' . $title; ?></h6>
                </div>
                <div class="row card card-body bg-light mt-2">
                    <h6><span style="font-weight: bold;">Tags:</span> <?php echo '' . $tags; ?></h6>
                </div>
                <div class="row card card-body bg-light mt-2">
                    <p><?php echo '' . $content; ?></p>
                </div>
            </div>
            <div class="card card-body bg-light mt-2">
                <div>
                    <h3 style="text-align: center;">Do you want to post your question?</h5>
                </div>
                <div class="row mt-2">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <a id="yes-btn" href="saveQuestion.php?option=yes" class="btn btn-primary" style="width: 100%;">Yes</a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <a id="no-btn" href="saveQuestion.php?option=no" class="btn btn-danger" style="width: 100%;">No</a>
                    </div>
                </div>
            </div>
            <?php
            $_SESSION['title'] = '' . $title;
            $_SESSION['tags'] = '' . $tags;
            $_SESSION['questionBody'] = '' . $content;
        }
    }
    if (isset($_GET['option'])) {
        $option = $_GET['option'];
        if ($option == 'yes') {
            $questionBody = $_SESSION['questionBody'];
            $userName = $_SESSION['userName'];
            $title = $_SESSION['title'];
            $tags = $_SESSION['tags'];
            //Question saving to database have to done here
            $questionId = saveQuestion($userName, $title, $tags, $questionBody);
            if ($questionId != '') {
                $_SESSION['questionBody'] = '';
                $questionBody = $_SESSION['questionBody'];
                $title = '';
                $tags = '';
                header("Location:questionDetails.php?questionId=" . $questionId);
            }
        } elseif ($option == 'no') {
            $content = $_SESSION['questionBody'];
            $imagesAttachedToPost = findAttachedImagesToPost($content);
            for ($i = 0; $i < count($imagesAttachedToPost); $i++) {
                unlink("ckeditor/uploads/" . $imagesAttachedToPost[$i]);
            }
            $_SESSION['questionBody'] = '';
            header("Location:index.php");
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
        window.onbeforeunload = unloadPage;</script>
    <?php include 'includes/footer.php' ?>
</div>

