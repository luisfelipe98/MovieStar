<?php

class User {

    private $id;
    private $name;
    private $lastName;
    private $email;
    private $password;
    private $image;
    private $bio;
    private $token;

    public function setId($id) {
        $this->id = $id; 
    }

    public function getId() {
        return $this->id;
    }
    
    public function setName($name) {
        $this->name = $name; 
    }

    public function getName() {
        return $this->name;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName; 
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setEmail($email) {
        $this->email = $email; 
    }

    public function getEmail() {
        return $this->email;
    }

    public function setPassword($password) {
        $this->password = $password; 
    }

    public function getPassword() {
        return $this->password;
    }

    public function setImage($image) {
        $this->image = $image; 
    }

    public function getImage() {
        return $this->image;
    }

    public function setBio($bio) {
        $this->bio = $bio; 
    }

    public function getBio() {
        return $this->bio;
    }

    public function setToken($token) {
        $this->token = $token; 
    }

    public function getToken() {
        return $this->token;
    }

    public function generateToken() {
        // Gera uma hash de 50 caracteres e modifica para ficar mais complexas
        return bind2hex(random_bytes(50));
    }

    public function generatePassword($password) {
        // Gera um hash para a senha do usuário
        return password_hash($password, PASSWORD_DEFAULT);
    }

}
?>