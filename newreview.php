<?php 
    
    require_once("templates/header.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");
    require_once("dao/ReviewDAO.php");
    require_once("models/User.php");
    require_once("models/Message.php");

    $userDAO = new UserDAO($conn, $BASE_URL);
    $userData = $userDAO->verifyToken(true);

    $message = new Message($BASE_URL);

    $movieDAO = new MovieDAO($conn, $BASE_URL);

    $reviewDAO = new ReviewDAO($conn, $BASE_URL);

    $movieId = filter_input(INPUT_GET, "id");

    $allMovies = $movieDAO->findAll();

    if ($movieId === NULL) {

        // Verifica se ele é dono de algum filme
        $userMovies = $movieDAO->getMoviesByUserId($userData);

        $vetor = [];

        for ($i = 0; $i < count($allMovies); $i++) {
            for ($j = 0; $j < count($userMovies); $j++) {
                if ($allMovies[$i]->getId() === $userMovies[$j]->getId()) {
                    $vetor[] = $i;
                }
            }
        }

        // Verifica se ele comentou algum filme
        $userReviews = $reviewDAO->getUserReviews($userData->getId());

        for ($i = 0; $i < count($allMovies); $i++) {
            for ($j = 0; $j < count($userReviews); $j++) {
                if ($allMovies[$i]->getId() === $userReviews[$j]->getMovieId()) {
                    $vetor[] = $i;
                }
            }
        }

        // Tirando os filmes que o usuário é dono e já comentou
        for ($i = 0; $i < count($vetor); $i++) {
            unset($allMovies[$vetor[$i]]);
        }

    } else if ($movieId === 0) {

        $message->setMessage("Filme não encontrado!", "error", "index.php");

    } else {

        $movie = $movieDAO->findById($movieId);

        if ($movie === false) {
            $message->setMessage("Filme não encontrado!", "error", "index.php");
        } else {
            $allMovies[] = $movie;
        }

    }
  
?>
    <div id="main-container" class="container-fluid">
        <div class="offset-md-4 col-md-4 review-container">
            <h1 class="page-title">Adicionar Crítica</h1>
            <p class="page-description">Adicione sua crítica e compartilhe com o mundo</p>
            <form action="<?= $BASE_URL ?>review_process.php" id="review-form" method="POST">
                <input type="hidden" name="type" value="create">
                <div class="form-group">
                    <label for="movie">Filme</label>
                    <select class="form-control" name="movie_id">
                        <?php foreach($allMovies as $eachMovie): ?>
                            <option value="<?= $eachMovie->getId() ?>"><?= $eachMovie->getTitle() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="rating">Nota</label>
                    <div class="stars">
                        <input type="radio" id="vazio" name="rating" value="" checked />
                        <label for="star_one"><i class="fa-solid fa-star"></i></label>
                        <input type="radio" id="star_one" name="rating" value="1" />
                        <label for="star_two"><i class="fa-solid fa-star"></i></label>
                        <input type="radio" id="star_two" name="rating" value="2" />
                        <label for="star_three"><i class="fa-solid fa-star"></i></label>
                        <input type="radio" id="star_three" name="rating" value="3" />
                        <label for="star_four"><i class="fa-solid fa-star"></i></label>
                        <input type="radio" id="star_four" name="rating" value="4" />
                        <label for="star_five"><i class="fa-solid fa-star"></i></label>
                        <input type="radio" id="star_five" name="rating" value="5" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="review">Comentário</label>
                    <textarea name="review" id="review" rows="3" class="form-control" placeholder="O que você achou do filme?"></textarea>
                </div>
                <input type="submit" class="form-control card-btn comment-btn" value="Enviar">
            </form>   
        </div>
    </div>
<?php
    require_once("templates/footer.php");
?>