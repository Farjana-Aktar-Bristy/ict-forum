<?php
include 'DatabaseConnection.php';
session_start();
$userName = NULL;
if (isset($_SESSION['userName'])) {
    $userName = $_SESSION['userName'];
}
$unviewedNotifications = getUnviewedNotificationCount($userName);
if ($unviewedNotifications == 0) {
    echo '';
} else {
    echo '(' . $unviewedNotifications . ')';
}
?>