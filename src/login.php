<?php

/**
 * ETML
 * Autrice:     Abid Fatima
 * Date: 2015   21.11.2023
 * Description: page permettant la connexion du compte logué
 */

session_start();
include '../Database.php';

//affecter à $useLogin la valeur de $_POST["useLogin"] s'il existe, sinon une chaîne vide.
$useLogin = $_POST["useLogin"] ?? "";
$userPassword = $_POST["usePassword"] ?? "";

$db = new Database();
// Appelle la méthode 'login' avec les identifiants fournis par l'utilisateur.
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