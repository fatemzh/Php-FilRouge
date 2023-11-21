<?php
/**
 * ETML
 * Autrice:     Abid Fatima
 * Date: 2015   21.11.2023
 * Description: Page permettant de modifier les informations de l'enseignant sélectionné et d'ajouter ces modifications à la base de données.
 */

session_start();
// Inclure le fichier Database.php
include '../Database.php';
$db = new Database();

if (!isset($_SESSION["user"]) ) {
    $isUserConnected = false;
} else {
    $isUserConnected = true;
    $userName = $_SESSION["user"];
}

//Tableau contenant les erreurs lors du remplissage du formulaire
$errors = array();

//Vérifie que l'id est présent
if (isset($_POST['idTeacher'])) {
    $idTeacher = $_POST['idTeacher'];
    $teacherInfo = $db->getOneTeacher($idTeacher);
} else {
    // Redirigez vers une page d'erreur ou la page d'accueil si l'ID n'est pas défini
    header("Location: ./addTeacher.php");
    exit;
}

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
    $db->modifyTeacher($_POST["idTeacher"], $_POST["firstName"], $_POST["name"], $_POST["genre"], $_POST["nickName"], $_POST["origin"], $_POST["section"]);
    header("Location: ./index.php");
}
?>