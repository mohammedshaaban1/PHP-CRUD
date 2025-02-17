<?php
require_once '../inc/connection.php';
if (!isset($_SESSION['user_id'])) {
    header("location: ../login.php");
    exit;
} else {
if (isset($_POST['submit'])) {
    $id = $_GET['id'];
    extract($_POST);
    $errors = [];
    if (empty($title)) {
        $errors[] = "Please enter a title";
    } elseif (is_numeric($title)) {
        $errors[] = "The title must be string";
    } elseif (strlen($title) < 3) {
        $errors[] = "The title must be more";
    }
    if (empty($body)) {
        $errors[] = "Please enter a body";
    } elseif (is_numeric($body)) {
        $errors[] = "The body must be string";
    } elseif (strlen($body) < 3) {
        $errors[] = "The body must be more";
    }
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $name = $image['name'];
        $tmp_name = $image['tmp_name'];
        $size = $image['size'] / (1024 * 1024);
        $error = $image['error'];
        $ext = strtoupper(pathinfo($name, PATHINFO_EXTENSION));
        $arr = ["PNG", "JPG", "JPEG"];
        if ($error != 0) {
            $errors[] = "Choose correct image";
        } elseif ($size > 1) {
            $errors[] = "Image large size";
        } elseif (!in_array($ext, $arr)) {
            $errors[] = "Image not correct";
        }
        $random = uniqid();
        $newName = $random . "." . $ext;
    } else {
        $query = "SELECT `image` FROM `posts` WHERE `id`=$id";
        $runQuery = mysqli_query($con, $query);
        if ($runQuery) {
            $photo = mysqli_fetch_assoc($runQuery);
            $newName = $photo['image'];
        }
    }
    if (empty($errors)) {
        $query = "UPDATE `posts` SET `title`='$title',`image`='$newName',`body`='$body',`user_id`=1 WHERE `id` = $id";
        $runQuery = mysqli_query($con, $query);
        if ($runQuery) {
            if (!empty($_FILES['image']['name'])) {
                move_uploaded_file($tmp_name, "../uploads/$newName");
            }
            $_SESSION['upSuccess'] = "Post updated successfuly";
            header("location:../index.php");
            exit;
        } else {
            $_SESSION['errors'] = ['$errors'];
            $_SESSION['title'] = $title;
            $_SESSION['body'] = $body;
            header("location:../create-post.php");
            exit;
        }
    } else {
        $_SESSION['errors'] = $errors;
        $_SESSION['title'] = $title;
        $_SESSION['body'] = $body;
        header("location:../create-post.php");
        exit;
    }
} else {
    header("location:../index.php");
    exit;
}}


