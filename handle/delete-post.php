<?php
require_once '../inc/connection.php';
if (!isset($_SESSION['user_id'])) {
    header("location: ../login.php");
    exit;
} else {
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "select id,image from posts WHERE id=$id";
    $runQuery = mysqli_query($con, $query);
    if (mysqli_num_rows($runQuery) == 1) {
        $post = mysqli_fetch_assoc($runQuery);
        $imageName = $post['image'];
        unlink("../uploads/$imageName");
        header("location:../index.php");
        $query = "delete from posts WHERE id=$id";
        $runQuery = mysqli_query($con, $query);
        if ($runQuery) {
            $_SESSION['success'] = "The post has deleted";
            header("location: ../index.php");
            exit;
        } else {
            $_SESSION['errors'] = ["error while deleting"];
            header("location:../index.php");
        }
    } else {
        $_SESSION['errors'] = ["post not found"];
        header("location:../index.php");
        exit;
    }
} else {
    header("location:../index.php");
    exit;
}
}