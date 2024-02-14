<?php 
    
    require_once("templates/header.php");
    
    // Verifica se o usuário está autenticado
    require_once("models/Movie.php");
    require_once("dao/MovieDAO.php");

    // Pegar o id do filme
    $id = filter_input(INPUT_GET, "id");
    
    $movie;

    $movieDAO = new MovieDAO($conn, $BASE_URL);

    if (empty($id)) {
        $message->setMessage("O filme não foi encontrado!", "error", "index.php");
    } else {

        $movie = $movieDAO->findById($id);

        // Verifica se o filme existe

        if (!$movie) {
            $message->setMessage("O filme não foi encontrado!", "error", "index.php");
        }

    }

    // Checar se o filme é do usuário
    $userOwnMovie = false;

    if (!empty($userData)) {

        if ($userData->id === $movie->getUsersId()) {
            $userOwnMovie = true;
        }
    }
   
    // Resgatar as reviews do filme

?>