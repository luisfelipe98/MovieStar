<?php

require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");
require_once("globals.php");
require_once("db.php");

$message = new Message($BASE_URL);

$userDAO = new UserDAO($conn, $BASE_URL);

$user = new User();

// Resgata o tipo de formulário
$type = filter_input(INPUT_POST, "type");

// Atualizar usuário
if ($type === "update") {

    // Resgatar dados do usuário
    $userData = $userDAO->verifyToken();

    // Resgatar dados do POST
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $bio = filter_input(INPUT_POST, "bio");

    // Modificando as informações no objeto

    $userData->setName($name);
    $userData->setLastName($lastname);
    $userData->setEmail($email);
    $userData->setBio($bio);

    // Upload da imagem
    if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
        
        $image = $_FILES["image"];

        // Checagem de tipo de imagem
        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
        $jpgArray = ["image/jpeg", "image/jpg"];

        if (in_array($image["type"], $imageTypes)) {

            // Checar se é jpg
            if (in_array($image, $jpgArray)) {
                $imageFile = imagecreatefromjpeg($image["tmp_name"]);
            } else {
                $imageFile = imagecreatefrompng($image["tmp_name"]);
            }

        } else {
            $message->setMessage("Tipo de imagem não permitido", "error", "back");    
        }

        $imageName = $user->generateImageName();

        imagejpeg($imageFile, "./img/users/" . $imageName, 100);

        $userData->setImage($imageName);

    }
        
    $userDAO->update($userData);

    // Atualizar senha do usuário
} else if ($type === "changepassword") {

    $password = filter_input(INPUT_POST, "password");
    $confirmPassword = filter_input(INPUT_POST, "confirmpassword");
    
    // Resgatar dados do usuário
    $userData = $userDAO->verifyToken();

    $id = $userData->getId();

    if ($password === $confirmPassword) {

        // Fazendo o hash da nova senha
        $finalPassword = $user->generatePassword($password);

        // Setando as informações no objeto
        $user->setId($id);
        $user->setPassword($finalPassword);

        $userDAO->changePassword($user);

    } else {
        $message->setMessage("As senhas não são iguais!", "error", "back");
    }

} else {
    $message->setMessage("Informações inválidas!", "error", "index.php");
}

?>