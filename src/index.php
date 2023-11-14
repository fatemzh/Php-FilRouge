<?php
//phpinfo();
    session_start();

    if (!isset($_SESSION["user"]) ) {
        $isUserConnected = false;
    } else {
        $isUserConnected = true;
        $userName = $_SESSION["user"];
    }

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
                <?php if ($isUserConnected === true && $_SESSION["user"]["useAdministrator"] === 0) : ?>                     
                    <h2>Bonjour <?php echo $_SESSION["user"]['useLogin']; ?> (user)</h2>  
                    <form action="logout.php" method="post">
                        <button type="submit" name="logout">Se déconnecter</button>
                    </form>
                <?php endif; ?>
                <?php if ($isUserConnected === true && $_SESSION["user"]["useAdministrator"]===1) :?>                     
                    <h2>Bonjour <?php echo $_SESSION["user"]['useLogin'];?> (admin)</h2>  
                    <form action="logout.php" method="post">
                        <button type="submit" name="logout">Se déconnecter</button>
                    </form>
                <?php endif; ?>
                <?php if ($isUserConnected === false): ?>
                    <h2>Pas connecté</h2>
                    <form action="login.php" method="post">
                        <label for="user"> </label>
                        <input type="text" name="useLogin" id="user" placeholder="Login">
                        <label for="password"> </label>
                        <input type="password" name="usePassword" id="password" placeholder="Mot de passe">
                        <button type="submit" class="btn btn-login">Se connecter</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <nav>
            <h2>Zone pour le menu</h2>
            <?php if ($isUserConnected === true && $_SESSION["user"]["useAdministrator"]===1) :?>                     
                <a href="./index.php">Accueil</a>
                <a href="addTeacher.php">Ajouter un enseignant</a>
            <?php endif; ?>
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
                        <!-- Affichage des boutons d'édition et de suppression -->
                        <td class="containerOptions">
                            <?php if ($isUserConnected === true && $_SESSION["user"]["useAdministrator"]===0): ?>                     
                                <a href="./detailTeacher.php?idTeacher=<?= $enseignant["idTeacher"]; ?>">
                                <img src="./img/detail.png" alt="detail">
                                </a>
                            <?php endif; ?>
                            <?php if ($isUserConnected === true && $_SESSION["user"]["useAdministrator"]===1): ?>
                                <a href="./updateTeacher.php?idTeacher=<?= $enseignant["idTeacher"]; ?>">
                                    <img src="./img/edit.png" alt="edit">
                                </a>
                                <a href="javascript:confirmDelete(<?= $enseignant["idTeacher"]; ?>)">
                                    <img src="./img/delete.png" alt="delete">
                                </a>
                                <a href="./detailTeacher.php?idTeacher=<?= $enseignant["idTeacher"]; ?>">
                                <img src="./img/detail.png" alt="detail">
                                </a>
                            <?php endif; ?>
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