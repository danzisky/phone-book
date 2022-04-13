<?php
session_start();
if(isset($_POST['submit'])) {
    include '../includes/autoloader.inc.php';
    $users = new UsersContr();

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    if($users->createUser($first_name, $last_name, $email, $username)) {
        return header('Location: ../index.php?status=success&message=user successfully created');
    } else {
        return header('Location: ../index.php?status=error&message=unexpected error occurred');
    }

} else {
    return header('Location: ../index.php?notsubmitted="true');
    echo "invalid entry";
}