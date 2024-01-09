<?php
/**
 * ETML
 * Autrice:     Abid Fatima
 * Date: 2015   21.11.2023
 * Description: page d'accueil de l'application permettant d'afficher les enseignants de la base de données et de les ajouter/modifier/supprimer/afficher en détails pour les comptes
 *              admin, et uniquement les afficher pour les comptes utilisateurs
 */

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
    $idTeacher = isset($_GET["idTeacher"]) ? $_GET["idTeacher"] : null;
    // Récupérer la liste des enseignants depuis la base de données
    $enseignants =  $db->getAllTeachers();

    //Initialisation du compteur
    $counter=0;
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
        <!-- Bouton pour ajouter plusieurs votes -->
        <form method='post' action="./checkVotes.php">
            <button type="submit"><a href="./index.php">Elire plusieurs</a></button>
        </form>
        <form action="#" method="post">
            <table>
                <thead>
                    <tr>
                        <td></td>
                        <th>Nom</th>
                        <th>Surnom</th>
                        <th>Options</th>
                        <th>Voter</th>
                        <th>Nombre de voix</th>
                        <th></th>
                    </tr>
                </thead>
                <!-- Affichage de chaque ligne d'enseignant avec son nom et son surnom -->
                <?php foreach ($enseignants as $enseignant) : ?>
                    <tr>
                        <!-- Possibilité de cocher le nom d'un enseignant pour voter pour lui et incrémenter son vote dans la DB -->
                        <td>             
                            <input type="checkbox" id="checkbox" name="checkbox" value="value" />
                            <?php
                                //Vérifie que la checkbox est cochée
                                if (!empty($_POST['checkbox'])) {
                                    //Incrémente le compteur
                                    $counter = $_SESSION['counter']++;
                                    echo $counter;
                                    
                                    // $query = "INSERT INTO t_teacher (teaVoix) VALUES ($counter) 
                                    // WHERE teaVoix = :teaVoix";
                                    // $binds = array(':teaVoix' => $teaVoix);
                                    // //Appeler la méthode pour executer la requête
                                    // $this->queryPrepareExecute($query, $binds);                                     
                                }
                            ?>
                        </td>
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
                        <td>
                            <form method='post' action="./checkVotes.php">
                                <a href="./index.php" name='vote' type="submit" value=''>J'élis</a>
                                <?php
                                //Vérifie que le lien est cliquée
                                if (!isset($_POST['vote'])) {
                                    //Incrémente le compteur
                                    $counter = $_SESSION['counter']++;    
                                    // $query = "INSERT INTO t_teacher (teaVoix) VALUES ($counter) 
                                    // WHERE teaVoix = :teaVoix";
                                    // $binds = array(':teaVoix' => $teaVoix);
                                    // //Appeler la méthode pour executer la requête
                                    // $this->queryPrepareExecute($query, $binds);
                                }
                                ?>
                            </form>
                        </td>
                        <td>
                            <!-- Affiche le  nombre de voix de l'enseignant -->
                            <?php
                                echo $counter;
                            ?>
                        </td>
                        <td>
                            <!-- Affiche texte selon le classement de l'enseignant -->
                            <?php
                                echo "Allez élisez-moi"
                            ?>
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