<?php
require_once 'connection.php';
if ($_GET['lang']) {
    if ($_GET['lang'] == "ar") {
        $_SESSION['lang'] = "ar";
    } else {
        $_SESSION['lang'] = "en";
    }
} else {
    $_SESSION['lang'] = "en";
}
header("location:" . $_SERVER['HTTP_REFERER']);
exit;
