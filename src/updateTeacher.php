<?php
session_start();
// Inclure le fichier Database.php
include '../Database.php';

if (!isset($_SESSION["user"]) ) {
    $isUserConnected = false;
} else {
    $isUserConnected = true;
    $userName = $_SESSION["user"];
}

// Créer une instance de la classe Database
$db = new Database();

// Récupère les informations sur l'enseignant et sa section 
$sections = $db->getAllSections();

$idTeacher = $_GET['idTeacher'];
$infos = $db->getOneTeacher($idTeacher);
$sectionTeacher = $db->getTeacherSection($idTeacher);
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
            <a href="./addTeacher.php">Ajouter un enseignant</a>
        </nav>
    </header>

    <div class="container">
        <div class="user-body">
            <form action="./checkUpdateForm.php" method="post" id="form">
                <h3>Modification d'un enseignant</h3>
                <input type="hidden" name="idTeacher" value="<?= $idTeacher; ?>">
                <input type="radio" id="genre1" name="genre" value="M" <?= $infos['teaGender'] == 'M' ? 'checked' : ''; ?>>
                <label for="genre1">Homme</label>
                <input type="radio" id="genre2" name="genre" value="F" <?= $infos['teaGender'] == 'F' ? 'checked' : ''; ?>>
                <label for="genre2">Femme</label>
                <input type="radio" id="genre3" name="genre" value="A" <?= $infos['teaGender'] == 'A' ? 'checked' : ''; ?>>
                <label for="genre3">Autre</label>

                <p>
                    <label for="firstName">Nom :</label>
                    <input type="text" name="firstName" id="firstName" value=<?= $infos['teaFirstname']; ?>>
                </p>
                <p>
                    <label for="name">Prénom :</label>
                    <input type="text" name="name" id="name"  value=<?= $infos['teaName']; ?>>
                </p>
                <p>
                    <label for="nickName">Surnom :</label>
                    <input type="text" name="nickName" id="nickName" value=<?= $infos['teaNickname']; ?>>
                </p>
                <p>
                    <label for="origin">Origine :</label>
                    <textarea name="origin" id="origin"><?= $infos['teaOrigine']; ?></textarea>
                </p>
                <p>
                    <label style="display: none" for="section"></label>
                    <select name="section" id="section">
                        <option value="">Section</option>
                        <?php
                            foreach ($sections as $section) {
                                $selected = ($sectionTeacher['secName'] == $section['secName']) ? "selected" : "";
                                echo "<option value='" . $section['idSection'] . "' $selected>" . $section['secName'] . "</option>";
                            }                                                      
                        ?>
                    </select>
                </p>
                <p>
                    <input type="submit" value="Enregistrer les modifications">
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