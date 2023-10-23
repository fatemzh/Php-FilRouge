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
        $teachers = $result->fetchAll(PDO::FETCH_ASSOC);
        return $teachers;
    }

    // Méthode pour récupérer tous les enseignants
    public function getAllTeachers(){
        try {
            // Requête SQL pour récupérer les données des enseignants
            $query = "SELECT idTeacher, teaName, teaNickname FROM t_teacher";

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
    
    // Récupère la liste des informations pour 1 enseignant
    public function getOneTeacher($id){

        // Requête SQL pour récupérer les données des enseignants
        $query = "SELECT * FROM t_teacher WHERE idTeacher = $id";

        // Exécuter la requête SQL
        $result = $this->querySimpleExecute($query);

        // Formater les données
        $teachers = $this->formatData($result);
        
        // Renvoie le tableau associatif 
        return $teachers[0];
    }

    // Requête qui permet de préparer, de binder et d’exécuter une requête (select avec where ou insert, update et delete)
    private function queryPrepareExecute($query, $binds){
        
        try{
            // Requête SQL
            $result= $this->connector->prepare($query);

            // Lie les paramètres aux valeurs du tableau $binds
            foreach ($binds as $param => $value)
            {
                $result->bindValue($param, $value);
            }
            $result->execute();
            return $result;
            
        }catch (PDOException $e) {
            // Gérer les erreurs de la requête SQL
            echo "Erreur de requête SQL : " . $e->getMessage();
            // Gérer l'erreur de manière appropriée (par exemple, jeter une exception)
            throw $e;
        }
    }

    // Vide le jeu d’enregistrement
    private function unsetData($req){
        $req->closeCursor();
    }

    public function getTeacherSection($id) {
        try {
            // Requête SQL pour récupérer la section d’un enseignant
            $query = "SELECT secName 
                      FROM t_section
                      INNER JOIN t_teacher ON idSection = fkSection
                      WHERE idTeacher = '$id'";
    
            // Exécute la requête SQL
            $result = $this->querySimpleExecute($query);
    
            // Formater les données
            $teacherSection = $this->formatData($result);
    
            // Renvoie le tableau associatif
            return $teacherSection[0];
        } catch (PDOException $e) {
            // Gérer les erreurs de la requête SQL
            echo "Erreur de requête SQL : " . $e->getMessage();
            // Gérer l'erreur de manière appropriée
            return [];
        }
    }

    public function getAllSections(){

        //Appeler la méthode privée pour executer la requête
        $query = 'SELECT * FROM t_section';

        //Appeler la méthode privéer pour avoir le résultat sous forme de tableau
        $req = $this->querySimpleExecute($query);

        //Retorune un tableau associatif
        return $this->formatData($req);
    }

    public function addSection($secName){
        // Échapper les chaînes de caractères
        $secName = $this->connector->quote($secName);
        //Requête SQL
        $query = "INSERT INTO t_section (secName) VALUES ($secName)";
        //Exécute la requête 
        $this->querySimpleExecute($query);
    }

    // Ajout enseignant
    public function insertTeacher($firstName, $name, $gender, $nickname, $origin, $section){
        // Échapper les chaînes de caractères
        $firstName = $this->connector->quote($firstName);
        $name = $this->connector->quote($name);
        $gender = $this->connector->quote($gender);
        $nickname = $this->connector->quote($nickname);
        $origin = $this->connector->quote($origin);
        $section = $this->connector->quote($section);
    
        //Requête SQL
        $query = "INSERT INTO t_teacher (teaFirstName, teaName, teaGender, teaNickname, teaOrigine, fkSection)  
        VALUES ( $firstName, $name, $gender, $nickname, $origin, $section);";
    
        //Appeler la méthode pour executer la requête
        $this->querySimpleExecute($query);
    }
    
    // Modifier les informations d'un enseignant
    public function modifyTeacher ($idTeacher, $firstName, $name, $gender, $nickname, $origin, $section){

        // Échapper les chaînes de caractères
        
        $firstName = $this->connector->quote($firstName);
        $name = $this->connector->quote($name);
        $gender = $this->connector->quote($gender);
        $nickname = $this->connector->quote($nickname);
        $origin = $this->connector->quote($origin);
        $section = $this->connector->quote($section);

        //Requête SQL
        $query = "UPDATE t_teacher SET 
        teaFirstName = $firstName, 
        teaName = $name, 
        teaGender = $gender, 
        teaNickname = $nickname, 
        teaOrigine = $origin, 
        fkSection = $section
        WHERE idTeacher = $idTeacher";
    
        //Appeler la méthode pour executer la requête
        $this->querySimpleExecute($query);
    }

    public function deleteTeacher ($idTeacher){

        $query = "DELETE FROM t_teacher WHERE idTeacher = $idTeacher";
        $this->querySimpleExecute($query);
    }
 }
?>