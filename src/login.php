<?php
session_start();
include '../Database.php';

$useLogin = $_POST["useLogin"] ?? "";
$userPassword = $_POST["usePassword"] ?? "";

$db = new Database();
$user = $db->login($useLogin, $userPassword);


// Si le tableau 'user' n'est pas vide, cela signifie que l'utilisateur a bien été trouvé en DB
if ($user) {
    $_SESSION['user'] = $user;
    header("Location: index.php");
    exit();
} else {
    var_dump("Problème à l'authentification");
    die();
}

?>