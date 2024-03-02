<?php 
    
    require_once("templates/header.php");
    
    // Verifica se o usuário está autenticado
    require_once("models/Movie.php");
    require_once("dao/MovieDAO.php");
    require_once("dao/ReviewDAO.php");
    require_once("dao/CategoryDAO.php");

    // Pegar o id do filme
    $id = filter_input(INPUT_GET, "id");
    
    $movie;

    $movieDAO = new MovieDAO($conn, $BASE_URL);

    $reviewDAO = new ReviewDAO($conn, $BASE_URL);

    if (empty($id)) {
        $message->setMessage("O filme não foi encontrado!", "error", "index.php");
    } else {

        $movie = $movieDAO->findById($id);

        // Verifica se o filme existe

        if (!$movie) {
            $message->setMessage("O filme não foi encontrado!", "error", "index.php");
        }

    }

    // Checar se o filme tem Imagem
    if ($movie->getImage() == "") {
        $movie->setImage("movie_cover.jpg");
    }

    // Checar se o filme é do usuário
    $userOwnMovie = false;

    if (!empty($userData)) {

        if ($userData->getId() === $movie->getUsersId()) {
            $userOwnMovie = true;
        }
    }
   
    // Resgatar as reviews do filme
    $movieReviews = $reviewDAO->getMovieReviews($id);

    // Resgatar as reviews do filme
    $alreadyReviewed = false;

?>
<div id="main-container" class="container-fluid">
    <div class="row">
        <div class="offset-md-1 col-md-6 movie-container">
            <h1 class="page-title"><?= $movie->getTitle()?></h1>
            <p class="movie-details">
                <span><?= $movie->getLength()?></span>
                <span class="pipe"></span>
                <span>
                    <?php 
                        $categoryDAO = new CategoryDAO($conn, $BASE_URL);
                        $result = $categoryDAO->getCategoryNameById($movie->getCategoriesId());
                        echo $result;
                    ?>
                </span>
                <span class="pipe"></span>
                <span><i class="fas fa-star"></i> 9 </span>
            </p>
            <iframe src="<?= $movie->getTrailer() ?>" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard write; encryted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <p><?= $movie->getDescription() ?></p>
        </div>
        <div class="col-md-4">
            <div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>/img/movies/<?= $movie->getImage() ?> ')"> </div>
        </div>
        <div class="offset-md-1 col-md-10" id="reviews-container">
            <h3 id="reviews-title">Avaliações</h3>
            <!-- Verifica se habilita a review para o usuário ou não -->
            <?php if(!empty($userData) && !$userOwnMovie && !$alreadyReviewed): ?>
                <div class="col-md-12" id="review-form-container">
                    <h4>Envie sua avaliação</h4>
                    <p class="page-description">Preencha o formulário com a nota e comentário sobre o filme</p>
                    <form action="<?= $BASE_URL ?>review_process.php" id="review-form" method="POST">
                        <input type="hidden" name="type" value="create">
                        <input type="hidden" name="movie_id" value="<?= $movie->getId() ?>">
                        <div class="form-group">
                            <label for="rating">Nota do Filme</label>
                            <select name="rating" id="rating" class="form-control">
                                <option value="">Selecione</option>
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>   
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="review">Comentário:</label>
                            <textarea name="review" id="review" rows="3" class="form-control" placeholder="O que você achou do filme?"></textarea>
                        </div>
                        <input type="submit" class="form-control card-btn comment-btn" value="Enviar">
                    </form>
                </div>
            <?php endif; ?>
            <?php if (count($movieReviews) == 0): ?>
                <p class="empty-list">Não há comentários para este filme ainda...</p>
            <?php else: ?>
                <?php foreach($movieReviews as $review): ?>
                    <?php require("templates/user_review.php"); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
require_once("templates/footer.php");
?>