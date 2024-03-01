<?php

require_once("models/Movie.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");
require_once("dao/MovieDAO.php");
require_once("dao/CategoryDAO.php");
require_once("globals.php");
require_once("db.php");

$message = new Message($BASE_URL);

$userDAO = new UserDAO($conn, $BASE_URL);

$movieDAO = new MovieDAO($conn, $BASE_URL);

// Resgatar dados do usuário
$userData = $userDAO->verifyToken();

// Recebendo o tipo do formulário
$type = filter_input(INPUT_POST, "type");

if ($type === "create") {}


?>