<?php
session_start();
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] == "true") {
    $_SESSION['authenticated'] = "false";
    session_destroy();
    header("Location:index.php");
}
?>