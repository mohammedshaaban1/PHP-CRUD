<!DOCTYPE html>
<?php
require_once 'connection.php';
if (isset($_SESSION['lang'])) {
    $lang = $_SESSION['lang'];
} else {
    $lang = "en";
}
if ($lang == "en") {
    require_once 'lang-en.php';
} else {
    require_once 'lang-ar.php';
}
?>
<html lang="<?php echo $lang ?>" dir="<?php echo $msg['dir'] ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $msg['blog'] ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body>