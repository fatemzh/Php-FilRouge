<!-- compte admin > login : Admin, password : admin
compte user > login : fatem, password: fatem -->

<?php
/**
 * ETML
 * Autrice:     Abid Fatima
 * Date: 2015   21.11.2023
 * Description: Class database regroupant les méthodes CRUD de l'application de gestion des surnoms des enseignants
 */

 class Database {

    // Propriété de classe pour stocker la connexion
    private $connector;

    /**
     * Se connecte via PDO et utilise la variable de classe $connector
     * Constructeur
     */
    public function __construct() {
        // Configuration de la base de donnée
        $configs = include("../config.php");
 
        // Se connecter via PDO
        try
        {
            $this->connector = new PDO('mysql:host=' . $configs["host"]. ':' . $configs["port"] . ';dbname=' . $configs["dbname"] . ';charset=utf8' , $configs["username"], $configs["password"]);
        }
        catch (PDOException $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Exécute une requête simple et renvoie le résultat.
     *
     * @param string $query La requête SQL à exécuter.
     * @return mixed Le résultat de la requête.
     */
    private function querySimpleExecute($query){
        $result = $this->connector->query($query);
        return $result;
    }

    /**
     * Méthode pour formater les résultats d'une requête en un tableau associatif.
     *
     * @param mixed $result Le résultat de la requête à formater.
     * @return array Le tableau associatif contenant les données formatées.
     */
    private function formatData($result){
        $teachers = $result->fetchAll(PDO::FETCH_ASSOC);
        return $teachers;
    }

    /**
     * Méthode pour récupérer tous les enseignants.
     *
     * @return array Le tableau associatif contenant les données de tous les enseignants.
     */
    // Méthode pour récupérer tous les enseignants
    public function getAllTeachers(){
        // Requête SQL pour récupérer les données des enseignants
        $query = "SELECT idTeacher, teaFirstname, teaNickname FROM t_teacher";

        // Exécuter la requête SQL
        $result = $this->querySimpleExecute($query);

        // Formater les données
        $teachers = $this->formatData($result);
        
        // Renvoie le tableau associatif 
        return $teachers;
    } 
    
    /**
     * Récupère la liste des informations pour 1 enseignant.
     *
     * @param int $id L'identifiant de l'enseignant.
     * @return array Le tableau associatif contenant les données de l'enseignant.
     */
    // Récupère la liste des informations pour 1 enseignant
    public function getOneTeacher($id){

        // Requête SQL pour récupérer les données des enseignants
        $query = "SELECT * FROM t_teacher WHERE idTeacher = :idTeacher";
        $binds = array(':idTeacher' => $id);

        // Exécuter la requête SQL
        $result = $this->queryPrepareExecute($query, $binds);

        // Formater les données
        $teachers = $this->formatData($result);
        
        // Renvoie le tableau associatif 
        return $teachers[0];
    }

    /**
     * Requête qui permet de préparer, de binder et d’exécuter une requête (select avec where ou insert, update et delete).
     *
     * @param string $query La requête SQL à préparer et exécuter.
     * @param array $binds Les valeurs à binder à la requête.
     * @return mixed Le résultat de la requête.
     */
    // Requête qui permet de préparer, de binder et d’exécuter une requête (select avec where ou insert, update et delete)
    private function queryPrepareExecute($query, $binds){

        // Requête SQL
        $result= $this->connector->prepare($query);

        // Lie les paramètres aux valeurs du tableau $binds
        foreach ($binds as $param => $value)
        {
            $result->bindValue($param, $value);
        }

        $result->execute();
        return $result;
    }

    /**
     * Récupère la section d'un enseignant.
     *
     * @param int $id L'identifiant de l'enseignant.
     * @return array Le tableau associatif contenant les données de la section de l'enseignant.
     */
    public function getTeacherSection($id) {
        // Requête SQL pour récupérer la section d’un enseignant
        $query = "SELECT secName 
                    FROM t_section
                    INNER JOIN t_teacher ON idSection = fkSection
                    WHERE idTeacher = :idTeacher";
        $binds = array(':idTeacher' => $id);
        // Exécute la requête SQL
        $result = $this->queryPrepareExecute($query, $binds);

        // Formater les données
        $teacherSection = $this->formatData($result);

        // Renvoie le tableau associatif
        return $teacherSection[0];
    }
    
    /**
     * Récupère toutes les sections.
     *
     * @return array Le tableau associatif contenant les données de toutes les sections.
     */
    public function getAllSections(){

        //Appeler la méthode privée pour executer la requête
        $query = 'SELECT * FROM t_section';

        //Appeler la méthode privéer pour avoir le résultat sous forme de tableau
        $req = $this->querySimpleExecute($query);

        //Retorune un tableau associatif
        return $this->formatData($req);
    }

    /**
     * Ajoute une section.
     *
     * @param string $secName Le nom de la section à ajouter.
     */
    public function addSection($secName){
        // Échapper les chaînes de caractères
        $secName = $this->connector->quote($secName);
        //Requête SQL
        $query = "INSERT INTO t_section (secName) VALUES (:secName)";
        $binds = array(':secName' => $secName);
        //Exécute la requête 
        $this->queryPrepareExecute($query, $binds);
    }

    /**
     * Insère un nouvel enseignant dans la base de données.
     *
     * @param string $firstName Le prénom de l'enseignant.
     * @param string $name Le nom de l'enseignant.
     * @param string $gender Le genre de l'enseignant.
     * @param string $nickname Le surnom de l'enseignant.
     * @param string $origin L'origine de l'enseignant.
     * @param int $section L'identifiant de la section de l'enseignant.
     */
    // Ajout enseignant
    public function insertTeacher($firstName, $name, $gender, $nickname, $origin, $section){
    
        //Requête SQL
        $query = "INSERT INTO t_teacher (teaFirstname, teaName, teaGender, teaNickname, teaOrigine, fkSection)  
        VALUES ( :firstName, :name, :gender, :nickname, :origin, :section);";
        $binds = array(':firstName' => $firstName, ':name' => $name, ':gender' => $gender, ':nickname'=> $nickname, ':origin'=>$origin, ':section'=>$section);

        //Appeler la méthode pour executer la requête
        $this->queryPrepareExecute($query, $binds);
    }
    
    /**
     * Modifie les informations d'un enseignant dans la base de données.
     *
     * @param int $idTeacher L'identifiant de l'enseignant à modifier.
     * @param string $firstName Le prénom de l'enseignant.
     * @param string $name Le nom de l'enseignant.
     * @param string $gender Le genre de l'enseignant.
     * @param string $nickname Le surnom de l'enseignant.
     * @param string $origin L'origine de l'enseignant.
     * @param int $section L'identifiant de la section de l'enseignant.
     */
    // Modifier les informations d'un enseignant
    public function modifyTeacher ($idTeacher, $firstName, $name, $gender, $nickname, $origin, $section){

        //Requête SQL
        $query = "UPDATE t_teacher SET 
        teaFirstname = :firstName, 
        teaName = :name, 
        teaGender = :gender, 
        teaNickname = :nickname, 
        teaOrigine = :origin, 
        fkSection = :section
        WHERE idTeacher = :idTeacher";

        $binds = array(
            ':firstName' => $firstName,
            ':name' => $name,
            ':gender' => $gender,
            ':nickname' => $nickname,
            ':origin' => $origin,
            ':section' => $section,
            ':idTeacher' => $idTeacher
        );

        //Appeler la méthode pour executer la requête
        $this->queryPrepareExecute($query, $binds);
    }

    /**
     * Supprime un enseignant de la base de données.
     *
     * @param int $idTeacher L'identifiant de l'enseignant à supprimer.
     */
    public function deleteTeacher ($idTeacher){

        $query = "DELETE FROM t_teacher WHERE idTeacher = :idTeacher";
        $binds = array(':idTeacher' => $idTeacher); 
        $this->queryPrepareExecute($query, $binds);
    }

    /**
     * Connecte un utilisateur en vérifiant son nom d'utilisateur et son mot de passe.
     *
     * @param string $useLogin Le nom d'utilisateur de l'utilisateur.
     * @param string $userPassword Le mot de passe de l'utilisateur.
     * @return array Les informations de l'utilisateur connecté.
     */
    public function login($useLogin, $userPassword) {

        $query = "SELECT * FROM t_user where useLogin = :useLogin and usePassword = :usePassword";

        // Exécution de la requête. A noter l'utilisation de la méthode ->query()
        $req = $this->connector->prepare($query);
        $req -> bindValue('useLogin', $useLogin, PDO::PARAM_STR);
        $req -> bindValue('usePassword', $userPassword, PDO::PARAM_STR);
        $req -> execute();

        // On convertit le résultat de la requête en tableau
        $user = $req->fetchALL(PDO::FETCH_ASSOC);

        return $user[0];
    }
}
?>