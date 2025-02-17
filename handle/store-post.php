<?php
require_once "../inc/connection.php";
if (!isset($_SESSION['user_id'])) {
    header("location: ../login.php");
    exit;
} else {
if (isset($_POST['submit'])) {
    $title = trim(htmlspecialchars($_POST['title']));
    $body = trim(htmlspecialchars($_POST['body']));
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
        $newName = null;
    }
    if (empty($errors)) {
        $query = "INSERT INTO `posts`(`title`, `image`, `body`, `user_id`) VALUES ('$title','$newName','$body',1)";
        $runQuery = mysqli_query($con, $query);
        if ($runQuery) {
            if (!empty($_FILES['image']['name'])) {
                move_uploaded_file($tmp_name, "../uploads/$newName");
            }
            $_SESSION['success'] = "Post inserted successfuly";
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
    header("location: ../index.php");
    exit;
}
}
