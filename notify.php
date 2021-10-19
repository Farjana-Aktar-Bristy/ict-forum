<?php
include 'DatabaseConnection.php';
session_start();
$userName = NULL;
if (isset($_SESSION['userName'])) {
    $userName = $_SESSION['userName'];
}
$unviewedNotices = getUnviewedNoticeCount($userName);
if ($unviewedNotices == 0) {
    echo '';
} else {
    echo '(' . $unviewedNotices . ')';
}
?>