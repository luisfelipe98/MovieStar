<?php 

require_once("templates/header.php");
require_once("dao/UserDAO.php");
require_once("dao/MovieDAO.php");
require_once("models/User.php");

$userDAO = new UserDAO($conn, $BASE_URL);
$userData = $userDAO->verifyToken(true);

$movieDAO = new MovieDAO($conn, $BASE_URL);
$userMovies = $movieDAO->getMoviesByUsersId($userData);

?>
<div id="main-container" class="container-fluid">
    <h2 class="section-title">Dashboard</h2>
    <p class="section-description">Adicione ou atualize as informações dos filmes que você enviou</p>
    <div class="col-md-12" id="add-movie-container">
        <a href="<?= $BASE_URL ?>newmovie.php" class="form-control card-btn">
            <i class="fas fa-plus"></i> Adicionar Filme
        </a>
    </div>
    <div class="col-md-12" id="movies-dashboard">
        <table class="table">
            <thead>
                <th scope="col">#</th>
                <th scope="col">Título</th>
                <th scope="col">Nota</th>
                <th scope="col" class="actions-column">Ações</th>
            </thead>
            <tbody>
                <?php foreach($userMovies as $movie): ?>
                    <tr>
                        <td scope="row"><?= $movie->getId() ?></td>
                        <td><a href="<?= $BASE_URL ?>movie.php?id=<?= $movie->getId() ?>" class="table-movie-title bold"><?= $movie->getTitle() ?></a></td>
                        <td><i class="fas fa-star"></i>9</td>
                        <td class="actions-column">
                            <a href="<?= $BASE_URL ?>editmovie.php?id=<?= $movie->getId() ?>" class="edit-btn">
                                <i class="far fa-edit"></i> Editar
                            </a>
                            <form action="<?= $BASE_URL ?>movie_process.php" method="POST">
                                <input type="hidden" name="type" value="delete">
                                <input type="hidden" name="id" value="<?= $movie->getId() ?>">
                                <button type="submit" class="delete-btn">
                                    <i class="fas fa-times"></i> Deletar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>       
       
</div>
<?php 
    require_once("templates/footer.php");
?>