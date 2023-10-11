<?php
    // Inclure le fichier Database.php
    include '../Database.php';

    $idTeacher = $_GET["idTeacher"];
    // Créer une instance de la classe Database
    $db = new Database();

    // Récupérer la liste des enseignants depuis la base de données et leurs sections
    $enseignant = $db->getOneTeacher($idTeacher);
    $section = $db->getTeacherSection($idTeacher);  
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
                <form action="#" method="post">
                    <label for="user"> </label>
                    <input type="text" name="user" id="user" placeholder="Login">
                    <label for="password"> </label>
                    <input type="password" name="password" id="password" placeholder="Mot de passe">
                    <button type="submit" class="btn btn-login">Se connecter</button>
                </form>
            </div>
        </div>
        <nav>
            <h2>Zone pour le menu</h2>
            <a href="./index.php">Accueil</a>
            <a href="addTeacher.php">Ajouter un enseignant</a>
        </nav>
    </header>

    <div class="container">
        <div class="user-head">
            <h3>Détail : 
                <?php 
                    echo $enseignant["teaFirstname"] . " " . $enseignant["teaName"];
                ?>
                <img style="margin-left: 1vw;" height="20em" src="./img/male.png" alt="male symbole">
            </h3>
            <p>
                <?php
                    echo $section["secName"];
                ;?>
            </p>
            <div class="actions">
                <!-- Lien qui mène vers la page détail de chaque enseignant -->
                <a href="./detailTeacher.php?idTeacher=<?= $enseignant["idTeacher"]; ?>">
                    <img src="./img/detail.png" alt="detail">
                </a>
                <a href="./updateTeacher.php?idTeacher=<?= $enseignant["idTeacher"]; ?>">
                    <img height="20em" src="./img/edit.png" alt="edit icon"></a>
                <a href="javascript:confirmDelete()">
                    <img height="20em" src="./img/delete.png" alt="delete icon"> </a>

            </div>
            </div>
            <div class="user-body">
                <div class="left">
                    <p>Surnom : 
                        <?php
                            echo $enseignant["teaNickname"];
                        ?>
                    </p>
                    <p>
                        <?php
                            echo $enseignant["teaOrigine"];
                        ;?>
                    </p>
                </div>
            </div>
        <div class="user-footer">
            <a href="./index.php">Retour à la page d'accueil</a>
        </div>

    </div>

    <footer>
        <p>Copyright GCR - bulle web-db - 2022</p>
    </footer>

    <script src="js/script.js"></script>

</body>

</html>