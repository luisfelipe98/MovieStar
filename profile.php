<?php 

    require_once("templates/header.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");
    require_once("dao/CategoryDAO.php");
    require_once("models/Message.php");
    require_once("models/User.php");
    require_once("models/Category.php");

    $user = new User();
    $userDAO = new UserDAO($conn, $BASE_URL);

    $movieDAO = new MovieDAO($conn, $BASE_URL);

    // Receber id do usuário
    $id = filter_input(INPUT_GET, "id");

    if (empty($id)) {

        if (!empty($userData)) {
            $id = $userData->getId();
        } else {
            $message->setMessage("Usuário não encontrado", "error", "index.php");
        }
    } else {

        $userData = $userDAO->findById($id);

        // Se não encontrar usuário
        if (!$userData) {
            $message->setMessage("Usuário não encontrado", "error", "index.php");
        }
        
    }

    $fullName = $user->getFullName($userData);

    if ($userData->getImage() == "") {
        $userData->setImage("user.png");
    }

    // Filmes que o usuário adicionou
    $userMovies = $movieDAO->getMoviesByUserId($userData);


?>
<div id="main-container" class="container-fluid">
    <div class="col-md-8 offset-md-2">
        <div class="row profile-container">
            <div class="col-md-12 about-container">
                <h1 class="page-title"><?= $fullName ?></h1>
                <div id="profile-image-container" class="profile-image" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->getImage() ?>')"></div>
                <h3 class="about-title">Sobre:</h3>
                <?php if(!empty($userData->getBio())): ?>
                    <p class="profile-description"><?= $userData->getBio() ?></p>
                <?php else: ?>
                    <p class="profile-description">O usuário não escreveu nada aqui...</p>
                <?php endif; ?>
            </div>
            <div class="col-md-12 added-movies-container">
                <div class="col-md-12">
                    <h3 class="movies-header">Filmes que enviou:</h3>
                    <div class="movies-container">
                        <?php if (count($userMovies) === 0): ?>
                            <p class="empty-list">O usuário não adicionou filmes ainda...</p>
                        <?php else: ?>
                            <?php foreach($userMovies as $movie): ?>
                                <?php require("templates/moviecard.php"); ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
    require_once("templates/footer.php");
?>