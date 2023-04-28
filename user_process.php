<?php

require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");
require_once("globals.php");
require_once("db.php");

$message = new Message($BASE_URL);

$userDAO = new UserDAO($conn, $BASE_URL);

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

    $userDAO->update($userData);

    // Atualizar senha do usuário
} else if ($type === "changepassword") {


} else {
    $message->setMessage("Informações inválidas!", "error", "index.php");
}

?>