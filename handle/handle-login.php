<?php
require_once '../inc/connection.php';
if (isset($_POST["submit"])) {
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $errors = [];
    // email
    if (empty($email)) {
        $errors[] = "Please enter your email";
    } elseif (is_numeric($email)) {
        $errors[] = "Your email must be string";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Your email is wrong";
    }
    // password
    if (empty($password)) {
        $errors[] = "Please enter your password";
    } elseif (strlen($password) < 5) {
        $errors[] = "Your password must be more";
    }
    //=======

    if (empty($errors)) {
        $query = "SELECT * FROM `users` WHERE email='$email'";
        $runQuery = mysqli_query($con, $query);
        if (mysqli_num_rows($runQuery) == 1) {
            $user = mysqli_fetch_assoc($runQuery);
            $oldpassword = $user['password'];
            $is_true = password_verify($password, $oldpassword);
            if ($is_true) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['success'] = "welcome" ." ". $user['name'];
                header("location: ../index.php");
                exit;
            } else {
                $_SESSION['errors'] = ["credintials not correct"];
                header("location: ../login.php");
                exit;
            }
        } else {
            $_SESSION['errors'] = ["this account not exist"];
            header("location: ../login.php");
            exit;
        }
    } else {
        $_SESSION['errors'] = $errors;
        header("location: ../login.php");
        exit;
    }
} else {
    header("location: ../login.php");
    exit;
}
