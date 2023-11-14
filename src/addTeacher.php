<?php
session_start();
// Inclure le fichier Database.php
include '../Database.php';

// Démarre session 
if (!isset($_SESSION["user"])) {
    $isUserConnected = false;
    header("Location: index.php");
} else {
    $isUserConnected = true;
    $userName = $_SESSION["user"];
}

$idTeacher = isset($_GET["idTeacher"]) ? $_GET["idTeacher"] : null;

// Créer une instance de la classe Database
$db = new Database();
// Récupérez toutes les sections
$sections = $db->getAllSections();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="./css/style.css" rel="stylesheet">
    <title>Version statique de l'application des surnoms</title>
</head>

<body>

    <header>
        <div class="container-header">
            <div class="titre-header">
                <h1>Surnom des enseignants</h1>
            </div>
            <div class="login-container">
                <?php if ($isUserConnected === true && $_SESSION["user"]["useAdministrator"]===1) :?>                     
                    <h2>Bonjour <?php echo $_SESSION["user"]['useLogin'];?> (admin)</h2>  
                    <form action="logout.php" method="post">
                        <button type="submit" name="logout">Se déconnecter</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <nav>
            <h2>Zone pour le menu</h2>
            <a href="./index.php">Accueil</a>
            <a href="addTeacher.php">Ajouter un enseignant</a>
        </nav>
    </header>

    <div class="container">
        <div class="user-body">
            <form action="./checkAddTeacherForm.php" method="post" id="form">
                <h3>Ajout d'un enseignant</h3>
                <p>
                    <input type="radio" id="genre1" name="genre" value="M" checked>
                    <label for="genre1">Homme</label>
                    <input type="radio" id="genre2" name="genre" value="F">
                    <label for="genre2">Femme</label>
                    <input type="radio" id="genre3" name="genre" value="A">
                    <label for="genre3">Autre</label>
                </p>
                <p>
                    <label for="firstName">Nom :</label>
                    <input type="text" name="firstName" id="firstName" value="">
                </p>
                <p>
                    <label for="name">Prénom :</label>
                    <input type="text" name="name" id="name" value="">
                </p>
                <p>
                    <label for="nickName">Surnom :</label>
                    <input type="text" name="nickName" id="nickName" value="">
                </p>
                <p>
                    <label for="origin">Origine :</label>
                    <textarea name="origin" id="origin"></textarea>
                </p>
                <p>
                    <label style="display: none" for="section"></label>
                    <select name="section" id="section">
                        <option value="">Section</option>
                        <?php
                            // Parcourt les sections de la db
                            foreach ($sections as $section) {
                                echo "<option value='" . $section['idSection'] . "'>" . $section['secName'] . "</option>";
                            }
                        ?>
                    </select>
                </p>
                <p>
                    <input type="submit" value="Ajouter">
                    <button type="button" onclick="document.getElementById('form').reset();">Effacer</button>
                </p>
            </form>
        </div>
        <div class="user-footer">
            <a href="./index.php">Retour à la page d'accueil</a>
        </div>
    </div>

    <footer>
        <p>Copyright GCR - bulle web-db - 2022</p>
    </footer>

</body>

</html>