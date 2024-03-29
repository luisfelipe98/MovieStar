<?php

require_once("models/User.php");
require_once("models/Message.php");
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
        $user->setPassword($data["password"]);
        $user->setImage($data["image"]);
        $user->setBio($data["bio"]);
        $user->setToken($data["token"]);

        return $user;

    }

    public function create(User $user, $authUser = false) {

        $query = "INSERT INTO users (
                  name, lastname, email, password, token) 
                  VALUES (
                  :name, :lastname, :email, :password, :token  
                  )";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(":name", $user->getName());
        $stmt->bindValue(":lastname", $user->getLastName());
        $stmt->bindValue(":email", $user->getEmail());
        $stmt->bindValue(":password", $user->getPassword());
        $stmt->bindValue(":token", $user->getToken());

        $stmt->execute();

        // Autenticar usuário caso auth seja true
        if ($authUser) {
            $this->setTokenToSession($user->getToken());
        }

    }

    public function update(User $user, $redirect = true) {

        $query = "UPDATE users SET
                  name = :name,
                  lastname = :lastname,
                  email = :email,
                  image = :image,
                  bio = :bio,
                  token = :token
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(":name", $user->getName());
        $stmt->bindValue(":lastname", $user->getLastName());
        $stmt->bindValue(":email", $user->getEmail());
        $stmt->bindValue(":image", $user->getImage());
        $stmt->bindValue(":bio", $user->getBio());
        $stmt->bindValue(":token", $user->getToken());
        $stmt->bindValue(":id", $user->getId());

        $stmt->execute();

        if ($redirect) {
            // Redireciona para o perfil do usuário
            $message = new Message($this->url);
            $message->setMessage("Dados atualizados com sucesso!", "success", "editprofile.php");
        }

    }

    // Verificar se tem alguém logado ou não
    public function verifyToken($protected = false) {

        if (!empty($_SESSION["token"])) {

            // Pega o token da session
            $token = $_SESSION["token"];

            $user = $this->findByToken($token);

            if ($user) {
                return $user;
            } else if ($protected) {
                // Redireciona usuário não autenticado
                $message = new Message($this->url);
                $message->setMessage("Faça a autenticação para acessar esta página!", "error", "index.php");
            }

        } else if ($protected) {
            // Redireciona usuário não autenticado
            $message = new Message($this->url);
            $message->setMessage("Faça a autenticação para acessar esta página!", "error", "index.php");
        }

    }

    public function setTokenToSession($token, $redirect = true) {

        // Salvar Token na sessão
        $_SESSION["token"] = $token;

        if ($redirect) {
            // Redireciona para o perfil do usuário
            $message = new Message($this->url);
            $message->setMessage("Seja bem-vindo!", "success", "editprofile.php");
        }
        
    }

    public function authenticateUser($email, $password) {

        $user = $this->findByEmail($email);

        if ($user) {

            // Verificar se as senhas batem
            if (password_verify($password, $user->getPassword())) {

                // Gerar um token e inserir na sessão
                $token = $user->generateToken();
                $this->setTokenToSession($token, false);

                // Atualizar o token do usuário
                $user->setToken($token);

                $this->update($user, false);

                return true;

            } else {
                return false;
            }

        } else {
            return false;
        }

    }

    public function findByEmail($user) {

        if ($user != "") {

            $query = "SELECT * FROM users WHERE email = :email";

            $stmt = $this->conn->prepare($query);

            $stmt->bindValue(":email", $user);

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

    public function findById($userId) {

        if ($userId != "") {

            $query = "SELECT * FROM users WHERE id = :userId";

            $stmt = $this->conn->prepare($query);

            $stmt->bindValue(":userId", $userId);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $user = $this->buildUser($data);

                return $user;

            } else {
                return false;
            }

        } else {
            return false;
        }

    }

    // Verificar se o token já existe no banco
    public function findByToken($token) {

        if ($token != "") {

            $query = "SELECT * FROM users WHERE token = :token";

            $stmt = $this->conn->prepare($query);

            $stmt->bindValue(":token", $token);

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

    public function destroyToken() {
        // Remove o token da sessão
        $_SESSION["token"] = "";

        // Redirecionar e apresentar a mensagem de sucesso
        $message = new Message($this->url);
        $message->setMessage("Logout feito com sucesso!", "success", "index.php");
         
    }

    public function changePassword(User $user) {

        $query = "UPDATE users SET
                  password = :password
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(":password", $user->getPassword());
        $stmt->bindValue(":id", $user->getId());

        $stmt->execute();

        // Redirecionar e apresentar a mensagem de sucesso
        $message = new Message($this->url);
        $message->setMessage("Senha alterada com sucesso!", "success", "editprofile.php");

    }

}

?>