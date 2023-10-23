<?php
    // Inclure le fichier Database.php
    include '../Database.php';

    // Créer une instance de la classe Database
    $db = new Database();
    
    // Récupère les informations sur l'enseignant et sa section 
    $sections = $db->getAllSections();
    $idTeacher = $_GET['idTeacher'];
    $teacherInfo = $db->getOneTeacher($idTeacher);
    $teacherSection = $db->getTeacherSection($idTeacher);
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
            <a href="./addTeacher.php">Ajouter un enseignant</a>
        </nav>
    </header>

    <div class="container">
        <div class="user-body">
            <form action="./checkUpdateForm.php" method="post" id="form">
                <h3>Modification d'un enseignant</h3>
                <input type="radio" id="genre1" name="genre" value="M" <?= $teacherInfo['teaGender'] == 'M' ? 'checked' : ''; ?>>
                <label for="genre1">Homme</label>
                <input type="radio" id="genre2" name="genre" value="F" <?= $teacherInfo['teaGender'] == 'F' ? 'checked' : ''; ?>>
                <label for="genre2">Femme</label>
                <input type="radio" id="genre3" name="genre" value="A" <?= $teacherInfo['teaGender'] == 'A' ? 'checked' : ''; ?>>
                <label for="genre3">Autre</label>

                <p>
                    <label for="firstName">Nom :</label>
                    <input type="text" name="firstName" id="firstName" value=<?= $teacherInfo['teaFirstname']; ?>>
                </p>
                <p>
                    <label for="name">Prénom :</label>
                    <input type="text" name="name" id="name"  value=<?= $teacherInfo['teaName']; ?>>
                </p>
                <p>
                    <label for="nickName">Surnom :</label>
                    <input type="text" name="nickName" id="nickName" value=<?= $teacherInfo['teaNickname']; ?>>
                </p>
                <p>
                    <label for="origin">Origine :</label>
                    <textarea name="origin" id="origin"><?= $teacherInfo['teaOrigine']; ?></textarea>
                </p>
                <p>
                    <label style="display: none" for="section"></label>
                    <select name="section" id="section">
                        <option value="">Section</option>
                        <?php
                            foreach ($sections as $section) {
                                $teacherSection['secName'] == $section['secName'];
                                echo "<option value='" . $section['idSection'] . "' $selected>" . $section['secName'] . "</option>";
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