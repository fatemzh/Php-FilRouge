<?php
session_start();
// Inclure le fichier Database.php
include '../Database.php';
include '../src/auth.php';

// Démarre session 
if ($user) {
    $_SESSION['user_id'] = $user[0]["idUser"];  
    $isUserConnected = true;
} else {
    $isUserConnected = false;
}

$db = new Database();

if (isset($_GET['idTeacher'])) {
    $idTeacher = $_GET['idTeacher'];
    $db->deleteTeacher($idTeacher);
    header("Location: ./index.php"); // Redirigez vers la liste des enseignants après la suppression
} else {
    echo "Erreur : ID de l'enseignant non fourni.";
}
?>
