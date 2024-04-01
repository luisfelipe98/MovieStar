<?php

require_once("models/Movie.php");
require_once("models/Message.php");
require_once("models/Review.php");
require_once("dao/ReviewDAO.php");
require_once("dao/UserDAO.php");
require_once("dao/MovieDAO.php");
require_once("globals.php");
require_once("db.php");

$message = new Message($BASE_URL);

$userDAO = new UserDAO($conn, $BASE_URL);

$movieDAO = new MovieDAO($conn, $BASE_URL);

$reviewDAO = new ReviewDAO($conn, $BASE_URL);

// Resgatar dados do usuário
$userData = $userDAO->verifyToken();

if (isset($_GET)) {

    $id = filter_input(INPUT_GET, "id");
    
    if (preg_match("/^\d+$/", $id)) {
        
        // Função de deletar comentário
        echo "I'm here";
        die();


    } else {
        $message->setMessage("Informações inválidas!", "error", "index.php");
    }

} else {

    // Recebendo o tipo do formulário
    $type = filter_input(INPUT_POST, "type");

    // Criando o Review
    if ($type === "create") {

        // Recebendo os dados
        $movie_id = filter_input(INPUT_POST, "movie_id");
        $rating = filter_input(INPUT_POST, "rating");
        $review = filter_input(INPUT_POST, "review");

        // Verificando se o filme existe
        $movieData = $movieDAO->findById($movie_id);

        if ($movieData) {

        // Validação mínima de dados
            if (!empty($review) && !empty($rating) && !empty($movie_id)) {

                // Criando o objeto do Review
                $reviewObject = new Review();

                $reviewObject->setRating($rating);
                $reviewObject->setReview($review);
                $reviewObject->setMovieId($movie_id);
                $reviewObject->setUserId($userData->getId());

                $reviewDAO->create($reviewObject);

            } else {
                $message->setMessage("Preencha os campos!", "error", "back"); 
            }

        } else {
        $message->setMessage("Informações inválidas!", "error", "index.php"); 
        }    

    } else {
        $message->setMessage("Informações inválidas!", "error", "index.php");
    }

}
?>