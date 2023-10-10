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

    // Récupère la liste des informations pour 1 enseignant
    public function getOneTeacher($id){
        try{
            // Requête SQL pour récupérer les données des enseignants
            $query = "SELECT * FROM t_teacher WHERE idTeacher = $id";

            // Requête SQL pour récupérer les données des enseignants
            $binds = [
                'id' => $id
            ];

            // Exécuter la requête SQL
            // $result = $this->queryPrepareExecute($query, $binds);
            $result = $this->querySimpleExecute($query);

            // Formater les données
            $teachers = $this->formatData($result);
            
            // Renvoie le tableau associatif 
            return $teachers[0];
        }catch (PDOException $e) {
            // Gérer les erreurs de la requête SQL
            echo "Erreur de requête SQL : ". $e->getMessage();
            // Gérer l'erreur de manière appropriée
            return [];
        }
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
    
    // Ajouter un enseignant
    public function insertTeacher ($teaFirstname, $teaName, $teaGender, $teaNickname, $teaOrigine, $fkSection){
        try{
            // Récupère les données du formulaire
            $teaFirstname = $_POST['firstName'];
            $teaName = $_POST['name'];
            $teaGender = $_POST['genre'];
            $teaNickname = $_POST['nickName'];
            $teaOrigine = $_POST['origin'];
            $fkSection = $_POST['section'];

            // Valide les données du formulaire
            if(empty($teaFirstname) || empty($teaName) || empty($teaGender) || empty($teaNickname || empty($teaOrigine) || empty($fkSection))){
                echo "Veuillez remplir tous les champs obligatoires";
            }elseif(isset($teaFirstname) && isset($teaName) && isset($teaGender) && isset($teaNickname) && isset($teaOrigine) && isset($fkSection)){
                $query = 
                "INSERT INTO t_teacher (teaFirstname, teaName, teaGender, teaNickname, teaOrigin, fkSection) 
                VALUES ($teaFirstname, '$teaName', '$teaGender', '$teaNickname', '$teaOrigine', $fkSection)";
                $result = $this->querySimpleExecute($query);
                $newTeacher = $this->formatData($result);

                $result = $this->querySimpleExecute($query);

                 // Réussite de l'insertion
                echo "Enseignant inséré avec succès";
            }
        } catch (PDOException $e) {
            // Gérer les erreurs de la requête SQL
            echo "Erreur de requête SQL : " . $e->getMessage();
            // Gérer l'erreur de manière appropriée
            return [];
        }
    }

    // Modifier les informations d'un enseignant
    public function modifyTeacher ($id){

    }
 }
?>