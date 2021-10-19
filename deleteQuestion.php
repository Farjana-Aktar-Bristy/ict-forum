<?php

include 'DatabaseConnection.php';
include 'findImagesName.php';
$loggedInUserName = NULL;
$userName = NULL;
$questionId = NULL;
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
if ($loggedInUserName == $userName) {
    $row = mysqli_fetch_assoc(getQuestionDetails($questionId));
    $questionBody = $row['question_body'];
    $imagesAttachedToQuestion = findAttachedImagesToPost($questionBody);
    $isQuestionDeleted = deleteQuestion($questionId);
    if ($isQuestionDeleted) {
        for ($i = 0; $i < count($imagesAttachedToQuestion); $i++) {
            unlink("ckeditor/uploads/" . $imagesAttachedToQuestion[$i]);
        }
        header("Location: profile.php?msg=questionDeleted");
    }
}
?>

