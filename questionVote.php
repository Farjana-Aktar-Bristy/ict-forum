<?php
$questionId = NULL;
$userName = NULL;
include 'DatabaseConnection.php';
session_start();
if (isset($_GET['questionId'])) {
    $questionId = $_GET['questionId'];
    $userName = $_SESSION['userName'];
    if(isset($_GET['upvote'])){
        echo ''.questionUpVote($questionId, $userName);
    } elseif(isset($_GET['downvote'])) {
        echo ''.questionDownVote($questionId, $userName);
    }
}
?>