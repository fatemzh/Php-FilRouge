<?php
    // Inclure le fichier Database.php
    include '../Database.php';

    // Créer une instance de la classe Database
    $db = new Database();

    // Récupérer la liste des enseignants depuis la base de données
    $enseignants =  $db->getAllTeachers();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../src/css/style.css" rel="stylesheet">
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
        <h3>Liste des enseignants</h3>
        <form action="#" method="post">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Surnom</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <!-- Affichage de chaque ligne d'enseignant avec son nom et son surnom -->
                <?php foreach ($enseignants as $enseignant) : ?>
                    <tr>
                        <td><?php echo $enseignant['teaFirstname']; ?></td>
                        <td><?php echo $enseignant['teaNickname']; ?></td>
                        <td class="containerOptions">
                            <a href="./updateTeacher.php?idTeacher=<?= $enseignant["idTeacher"]; ?>">
                                <img src="./img/edit.png" alt="edit">
                            </a>
                            <a href="javascript:confirmDelete(<?= $enseignant["idTeacher"]; ?>)">
                                <img src="./img/delete.png" alt="delete">
                            </a>
                            <a href="./detailTeacher.php?idTeacher=<?= $enseignant["idTeacher"]; ?>">
                                <img src="./img/detail.png" alt="detail">
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </form>
        <script src="js/script.js"></script>
    </div>

    <footer>
        <p>Copyright GCR - bulle web-db - 2022</p>
    </footer>

</body>

</html>