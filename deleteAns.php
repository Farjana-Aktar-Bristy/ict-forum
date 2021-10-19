<?php
include 'findImagesName.php';
include 'DatabaseConnection.php';
$loggedInUserName = NULL;
$userName = NULL;
$questionId = NULL;
$answerId = NULL;
session_start();
if (isset($_SESSION['userName'])) {
    $loggedInUserName = $_SESSION['userName'];
}
if (isset($_GET['userName'])) {
    $userName = $_GET['userName'];
}
if (isset($_GET['questionId'])) {
    $questionId = $_GET['questionId'];
}
if (isset($_GET['answerId'])) {
    $answerId = $_GET['answerId'];
}
if ($loggedInUserName == $userName) {
    $answerRow = mysqli_fetch_assoc(getAnswerById($answerId));
    $answerBody = $answerRow['answer_body'];
    $imagesAttachedToAnswer = findAttachedImagesToPost($answerBody);
    for ($i = 0; $i < count($imagesAttachedToAnswer); $i++) {
        unlink("ckeditor/uploads/" . $imagesAttachedToAnswer[$i]);
    }
    deleteAnswer($answerId, $questionId);
}
?>

