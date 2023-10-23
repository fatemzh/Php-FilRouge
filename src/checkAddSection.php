<?php

include("../Database.php");
$db = new Database();

//Ouverture de la session
session_start();

//Tableau contenant les erreurs lors du remplissage du formulaire
$errors = array();

//Vérification des champs remplis
$field = "secName";

if (empty($_POST[$field])) {
    $message = 'Veuillez remplir le champ "nom du formulaire';
    echo $message;
    $errors[] = $message;
}

//Si erreurs --> affiche les erreurs. Sinon enregistre les champs dans la session

if (count($errors) > 0) {
    foreach($errors as $error) {
        echo $error . "<br>";
    }
}
else{
    //Insertion de la nouvelle section dans la base de données
    $db->addSection($_POST["secName"]);
    header("Location: ./index.php");
}
?>