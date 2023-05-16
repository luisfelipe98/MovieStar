<?php

require_once("models/Movie.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");
require_once("dao/MovieDAO.php");
require_once("globals.php");
require_once("db.php");

$message = new Message($BASE_URL);

$userDAO = new UserDAO($conn, $BASE_URL);

$movieDAO = new MovieDAO($conn, $BASE_URL);

// Resgata o tipo de formulário
$type = filter_input(INPUT_POST, "type");

// Resgatar dados do usuário
$userData = $userDAO->verifyToken();

// Criando Movie
if ($type === "create") { 

    // Receber os dados do input
    $title = filter_input(INPUT_POST, "title");
    $length = filter_input(INPUT_POST, "length");
    $category = filter_input(INPUT_POST, "category");
    $trailer = filter_input(INPUT_POST, "trailer");
    $description = filter_input(INPUT_POST, "description");

    // Validação mínima de dados
    if (!empty($title) && !empty($length) && !empty($category) && !empty($trailer) && !empty($description)) {

        $movie = new Movie();

        $movie->setTitle($title);
        $movie->setLength($length);
        $movie->setCategory($category);
        $movie->setTrailer($trailer);
        $movie->setDescription($description);
        $movie->setUsersId($userData->getId());

        // Upload de imagem
        if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

            $image = $_FILES["image"];

            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/jpg"];

            // Checagem do tipo de imagem
            if (in_array($image["type"], $imageTypes)) {

                // Checar se é jpg
                if (in_array($image["type"], $jpgArray)) {
                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                } else {
                    $imageFile = imagecreatefrompng($image["tmp_name"]);
                }

            } else {
                $message->setMessage("Tipo de imagem não permitido", "error", "back");
            }

            $imageName = $movie->generateImageName();

            imagejpeg($imageFile, "./img/movies/" . $imageName, 100);

            $movie->setImage($imageName);

        }

        $movieDAO->create($movie);

    } else {
        $message->setMessage("Preencha os campos!", "error", "back");
    }

} else {
    $message->setMessage("Informações inválidas!", "error", "index.php");
}

?>