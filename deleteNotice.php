<?php

include 'DatabaseConnection.php';
$loggedInUserName = NULL;
$userName = NULL;
$noticeId = NULL;
session_start();
if (isset($_SESSION['userName'])) {
    $loggedInUserName = $_SESSION['userName'];
}
if (isset($_GET['userName'])) {
    $userName = $_GET['userName'];
}
if (isset($_GET['noticeId'])) {
    $noticeId = $_GET['noticeId'];
}
if ($loggedInUserName == $userName) {
    $isNoticeDeleted = deleteNotice($noticeId);
    if ($isNoticeDeleted) {
        header("Location: notices.php?msg=success");
    }
}
?>

