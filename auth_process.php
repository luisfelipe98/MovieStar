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

// Verificação do tipo de formulário
if ($type === "register") {

   $name = filter_input(INPUT_POST, "name"); 
   $lastName = filter_input(INPUT_POST, "lastname");
   $email = filter_input(INPUT_POST, "email");
   $password = filter_input(INPUT_POST, "password");
   $confirmPassword = filter_input(INPUT_POST, "confirmpassword");
   
   // Verificação de dados mínimos
   if ($name && $lastName && $email && $password) {

    // Verificar se as senhas batem
    if ($password === $confirmPassword) {

        // Verificar se o email já está cadastrado no sistema
        if ($userDAO->findByEmail($email) === false) {

            $user = new User();
            
            // Criação de token e senha
            $userToken = $user->generateToken();
            $finalPassword = $user->generatePassword($password);

            $user->setName($name);
            $user->setlastName($lastName);
            $user->setEmail($email);
            $user->setPassword($finalPassword);
            $user->setToken($userToken);

            $auth = true;

            $userDAO->create($user, $auth);

        } else {
            // Enviar uma mensagem de erro que o usuário existente
            $message->setMessage("Usuário já cadastrado, tente outro e-mail", "error", "back");
        }

    } else {
        // Enviar uma mensagem de erro de senhas não batem
        $message->setMessage("As senhas não são iguais.", "error", "back");
    }

   } else {
    // Enviar uma mensagem de erro dos dados faltantes
    $message->setMessage("Por favor, preencha todos os campos.", "error", "back");
   }

} else if ($type === "login") {

   $email = filter_input(INPUT_POST, "email");
   $password = filter_input(INPUT_POST, "password");

   // Tenta autenticar o usuário
   if ($userDAO->authenticateUser($email, $password)) {

        $message->setMessage("Seja bem-vindo!", "success", "editprofile.php");

   } else {
        // Enviar uma mensagem de erro
        $message->setMessage("Usuário e/ou senha incorretos", "error", "back");  

   }

} else {
        $message->setMessage("Informações inválidas!", "error", "index.php");
}

?>