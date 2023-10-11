<?php

include("../Database.php");
$db = new Database();

//Ouverture de la session
session_start();

//Tableau contenant les erreurs lors du remplissage du formulaire
$errors = array();

//Vérification des champs remplis
$fields = [
    "name" => "Le champ \"Prénom\" est obligatoire.",
    "firstName"      => "Le champ \"Nom\" est obligatoire.",
    "genre"     => "Vous devez cocher Homme, Femme ou Autre.",
    "nickName"  => "Le champ \"Surnom\" est obligatoire.",
    "origin"    => "Le champ \"Origine\" est obligatoire.",
    "section"   => "Vous devez choisir une section."
];

foreach ($fields as $field => $message) {
    if (empty($_POST[$field])) {
        $errors[] = $message;
    }
}

//Si erreurs --> affiche les erreurs. Sinon enregistre les champs dans la session
if (count($errors) > 0) {
    foreach($errors as $error) {
        echo $error . "<br>";
    }
}
else{
    //Modification des information dans la base de données
    $db->modifyTeacher($_POST["firstName"], $_POST["name"], $_POST["genre"], $_POST["nickName"], $_POST["origin"], $_POST["section"]);
    header("Location: ./index.php");
}
?>