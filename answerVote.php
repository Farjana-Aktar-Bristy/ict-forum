<?php

$answerId = NULL;
$userName = NULL;
include 'DatabaseConnection.php';
session_start();
if (isset($_GET['answerId'])) {
    $answerId = $_GET['answerId'];
    $userName = $_SESSION['userName'];
    if (isset($_GET['upvote'])) {
        echo '' . answerUpVote($answerId, $userName);
    } elseif (isset($_GET['downvote'])) {
        echo '' . answerDownVote($answerId, $userName);
    }
}
?>