<?php 

    require_once("templates/header.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");
    require_once("dao/CategoryDAO.php");
    require_once("models/User.php");
    require_once("models/Category.php");

    $userDAO = new UserDAO($conn, $BASE_URL);
    $userData = $userDAO->verifyToken(true);

    $categoryDAO = new CategoryDAO($conn, $BASE_URL);
    $categoryData = $categoryDAO->showAll();

    $movieDAO = new MovieDAO($conn, $BASE_URL);

    $id = filter_input(INPUT_GET, "id");

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

?>
  <div id="main-container" class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 offset-md-1">
                <h1><?= $movie->getTitle() ?></h1>
                <p class="page-description">Altere os dados do filme no formulário abaixo:</p>
                <form id="edit-movie-form" action="<?= $BASE_URL?>movie_process.php" action="POST" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="update">
                    <input type="hidden" name="id" value="<?= $movie->getId() ?>">
                <div class="form-group">
                    <label for="title">Título:</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Digite o título do filme" value="<?= $movie->getTitle() ?>">
                </div>
                <div class="form-group">
                    <label for="image">Imagem</label>
                    <input type="file" class="form-control-file" name="image" id="image">
                </div>
                <div class="form-group">
                    <label for="length">Duração:</label>
                    <input type="text" class="form-control" id="length" name="length" placeholder="Digite a duração do filme" value="<?= $movie->getLength() ?>">
                </div>
                <div class="form-group">
                    <label for="category">Categoria:</label>
                    <select name="category" id="category" class="form-control">
                        <option value="">Selecione</option>
                        <?php foreach($categoryData as $category): ?>
                            <?php if($movie->getCategoriesId() === $category->getId()): ?>
                                <option value="<?= $category->getId() ?>" selected><?= $category->getCategory() ?></option>
                            <?php else: ?>
                                <option value="<?= $category->getId() ?>"><?= $category->getCategory() ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="trailer">Trailer:</label>
                    <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insira o link do trailer" value="<?= $movie->getTrailer() ?>">
                </div>
                <div class="form-group">
                    <label for="description">Descrição:</label>
                    <textarea class="form-control" name="description" id="description" rows="5" placeholder="Descreva o filme..."><?= $movie->getDescription() ?></textarea>
                </div>
                <input type="submit" class="form-control card-btn edit-movie-btn" value="Editar filme">
                </form>
            </div>
            <div class="col-md-3">
                <div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>img/movies/<?= $movie->getImage() ?>')"></div>
                <iframe src="<?= $movie->getTrailer() ?>" width="450" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard write; encryted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>
  </div>
<?php 
    require_once("templates/footer.php");
?>