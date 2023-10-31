<?php
    // Inclure le fichier Database.php
    include '../Database.php';

    // Créer une instance de la classe Database
    $db = new Database();

    // Récupérer la liste des enseignants depuis la base de données
    $enseignants =  $db->getAllTeachers();

    $users = [];
    $isUserConnected = 0;

    // Récupération du login et password saisi par l'utilisateur
    // A noter que ?? retourne "" si $_POST["useLogin"] est null 
    $useLogin = $_POST["useLogin"] ?? "";
    $userPassword = $_POST["usePassword"] ?? "";

    // Création d'une instance PDO pour se connecter à la base de données
    // ATTENTION si vous n'utilisez pas Docker mais uWamp
    // vous devez supprimer le port du host 
    // "mysql:host=localhost;dbname=challengeInjectionSQL;charset=utf8"
    $connector = new PDO("mysql:host=localhost:6033;dbname=db_nickname;charset=utf8", 'root', 'root');

    // Création de la requête SQL permettant de récupérer les informations de l'utilisateur
    // à partir du login et password saisis par l'utilisateur
    $query = "SELECT * FROM t_user where useLogin = :useLogin and usePassword = :usePassword";

    // Exécution de la requête. A noter l'utilisation de la méthode ->query()
    $req = $connector->prepare($query);
    $req -> bindValue('useLogin', $useLogin, PDO::PARAM_STR);
    $req -> bindValue('usePassword', $userPassword, PDO::PARAM_STR);
    $req -> execute();

    // On convertit le résultat de la requête en tableau
    $user = $req->fetchALL(PDO::FETCH_ASSOC);
    // Si le tableau 'user' n'est pas vide, cela signifie que l'utilisateur a bien été trouvé en DB
    if ($user) {
        $isUserConnected = 1;
    }

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
                <form action="index.php" method="post">
                    <label for="user"> </label>
                    <input type="text" name="useLogin" id="user" placeholder="Login">
                    <label for="password"> </label>
                    <input type="password" name="usePassword" id="password" placeholder="Mot de passe">
                    <button type="submit" class="btn btn-login">Se connecter</button>
                </form>
            </div>
            <div class="block">
            <h2>Utilisateur connecté ? :
                <?php if ($isUserConnected === 1) {
                    echo "Oui";
                } else {
                    echo "Non";
                }  ?>
            </h2>
            <?php if ($isUserConnected) {
                echo "<h2>Bonjour " . $user[0]["useLogin"] . " </h2>";
            } ?>
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
                        <!-- Affichage des boutons d'édition et de suppression -->
                        <td class="containerOptions">
                            <?php if ($isUserConnected === 1) : ?>
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
                            <?php if ($isUserConnected !== 1) : ?>
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