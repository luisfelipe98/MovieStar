<?php

require_once("models/User.php");
require_once("interfaces/UserDAOInterface.php");

class UserDAO implements UserDAOInterface {

    private $conn;
    private $url;

    public function __construct (PDO $conn, $url) {
        $this->conn = $conn;
        $this->url = $url;
    }

    public function buildUser($data) {

        $user = new User();

        $user->setId($data["id"]);
        $user->setName($data["name"]);
        $user->setLastName($data["lastname"]);
        $user->setEmail($data["email"]);
        $user->setPassword($data["pasword"]);
        $user->setImage($data["image"]);
        $user->setBio($data["bio"]);
        $user->setToken($data["token"]);

        return $user;

    }

    public function create(User $user, $authUser = false) {

    }

    public function update(User $user) {

    }

    public function verifyToken($protected = false) {

    }

    public function setTokenToSession($token, $redirect = true) {
        
    }

    public function authenticateUser($email, $password) {

    }

    public function findByEmail(User $user) {

        if ($user->getEmail() != "") {

            $query = "SELECT * FROM users WHERE email = :email";

            $stmt = $this->conn->prepare($query);

            $stmt->bindValue(":email", $user->getEmail());

            $stmt->execute();

            if ($stmt->rowCount() > 0) { 

                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $newData = $this->buildUser($data);

                return $newData;

            } else { 
                return false;
            }
        } else {
            return false;
        }

    }

    public function findById(User $user) {

    }

    public function findByToken(User $user) {

    }

    public function changePassword(User $user) {

    }

}
?>