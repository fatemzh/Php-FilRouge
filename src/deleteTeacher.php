<?php
include '../Database.php';
$db = new Database();

if (isset($_GET['idTeacher'])) {
    $idTeacher = $_GET['idTeacher'];
    $db->deleteTeacher($idTeacher);
    header("Location: ./index.php"); // Redirigez vers la liste des enseignants après la suppression
} else {
    echo "Erreur : ID de l'enseignant non fourni.";
}
?>
