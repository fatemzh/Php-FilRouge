<?php
 class Database {

    // Propriété de classe pour stocker la connexion
    private $connector;

    // Crée un nouvel objet PDO et connexion à la BD
    public function __construct(){
        // Informations de connexion à la base de données
        $host = 'localhost:6033';   // Nom d'hôte : numéro de port
        $dbname = 'db_nickname';    // Nom de la base de données 
        $user = 'root';             // ID phpMyAdmin
        $pass = 'root';             // Mdp phpMyAdmin

        // Se connecter via PDO et stocker la connexion dans la propriété de classe
        $this->connector = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8",
            $user,
            $pass
        );
    }

    // Méthode pour exécuter une requête simple (sans where)
    private function querySimpleExecute($query){
        try {
            // Exécuter la requête SQL
            $result = $this->connector->query($query);
            return $result;
        } catch (PDOException $e) {
            // Gérer les erreurs de la requête SQL
            echo "Erreur de requête SQL : " . $e->getMessage();
            // Gérer l'erreur de manière appropriée (par exemple, jeter une exception)
            throw $e;
        }
    }

    // Méthode pour formater les résultats d'une requête en un tableau associatif
    private function formatData($result){
        // Vérifier s'il y a des résultats
        if ($result && $result->rowCount() > 0) {
            // Récupérer les données sous forme de tableau associatif
            $teachers = $result->fetchAll(PDO::FETCH_ASSOC);
            return $teachers;
        } else {
            // Gérer le cas où il n'y a aucun enseignant
            return [];
        }
    }

    // Méthode pour récupérer tous les enseignants
    public function getAllTeachers(){
        try {
            // Requête SQL pour récupérer les données des enseignants
            $query = "SELECT teaName, teaNickname FROM t_teacher";

            // Exécuter la requête SQL
            $result = $this->querySimpleExecute($query);

            // Formater les données
            $teachers = $this->formatData($result);
            
            // Renvoie le tableau associatif 
            return $teachers;
        } catch (PDOException $e) {
            // Gérer les erreurs de la requête SQL
            echo "Erreur de requête SQL : " . $e->getMessage();
            // Gérer l'erreur de manière appropriée
            return [];
        }
    }

    // Requête qui permet de préparer, de binder et d’exécuter une requête (select avec where ou insert, update et delete)
    private function queryPrepareExecute($query, $binds){
        
        
    }


    // Vide le jeu d’enregistrement
    private function unsetData($req){

        // TODO: vider le jeu d�enregistrement
    }

    // Récupère la liste des informations pour 1 enseignant
    public function getOneTeacher($id){

        // TODO: r�cup�re la liste des informations pour 1 enseignant
        // TODO: avoir la requ�te sql pour 1 enseignant (utilisation de l'id)
        // TODO: appeler la m�thode pour executer la requ�te
        // TODO: appeler la m�thode pour avoir le r�sultat sous forme de tableau
        // TODO: retour l'enseignant
    }
 }
?>