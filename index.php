<?php

// Informations de connexion à la base de données
$host = 'localhost:6033';   // Nom d'hôte (peut être localhost si la base de données est sur le même serveur) + numéro port docker
$dbname = 'db_nickname';    // Nom de la base de données 
$user = 'root';             // ID phpMyAdmin
$pass = 'root';             // Mdp phpMyAdmin

try {
    // Se connecter via PDO
    $connector = new PDO(
        "mysql:host=localhost:6033;dbname=$dbname;charset=utf8",
        $user,
        $pass
    );
    // Vous êtes maintenant connecté à la base de données
    echo "Connexion à la base de données réussie.";
}
catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage() . "<br>";
    echo "Code d'erreur MySQL : " . $e->getCode();
}


// Vous pouvez maintenant exécuter des requêtes SQL et interagir avec votre base de données ici

// N'oubliez pas de fermer la connexion lorsque vous avez terminé pour libérer les ressources
$connector = null;

?>
