<?php
$title = 'Tableau de bord';
$totalPost = $postCount["COUNT(*)"];
if (($totalPost % 5) == 0) {
    $maxPage = $totalPost / 5;
} else {
    $maxPage = ($totalPost / 5) + 1 - ($totalPost % 5) / 5;
}
$page;
?>

<?php ob_start(); ?>

<div class="container">

    <h1>Bienvenue, <?= ucwords($_SESSION['user']['userFirstName']) ?>!</h1>
    <?php if (ucwords($_SESSION['user']['userFirstName']) === 'Jean' && $_SESSION['user']['admin'] === '1') : ?>
        <div class="d-flex justify-content-around m-5">
            <a href="index.php?action=dashboardListPosts"><button type="button" class="btn btn-outline-info">Voir les billets</button></a>
            <a href="index.php?action=dashboardAddPost"><button type="button" class="btn btn-outline-info">Ecrire un nouveau billet</button></a>
            <a href="index.php?action=dashboardPost"><button type="button" class="btn btn-outline-info">Modifier/Supprimer un billet</button></a>
        </div>
    <?php endif; ?>

    <h2>Derniers billets du blog :</h2>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">

            <li class="page-item <?= ($_GET['page'] == 1 || !isset($_GET['page'])) ? 'disabled' : '' ?>">
                <a class="page-link" href="?action=dashboardListPosts&page=<?= $_GET['page'] - 1 ?>" tabindex="-1" aria-disabled="<?= ($_GET['page'] == 1 || !isset($_GET['page'])) ? 'true' : 'false' ?>">Previous</a>
            </li>
            <?php
            for ($page = 1; $page <= $maxPage; $page++) {
                if (isset($_GET['page'])) {
                    if ($_GET['page'] == $page) {
                        echo "<li class=\"page-item active\"><a class=\"page-link\" href=?action=dashboardListPosts&page=" . $page .  ">" . $page .  "</a></li>";
                    } else {
                        echo "<li class=\"page-item\"><a class=\"page-link\" href=?action=dashboardListPosts&page=" . $page .  ">" . $page . "</a></li>";
                    }
                } else {
                    if ($page == 1) {
                        echo "<li class=\"page-item active\"><a class=\"page-link\" href=?action=dashboardListPosts&page=" . $page .  ">" . $page .  "</a></li>";
                    } else {
                        echo "<li class=\"page-item\"><a class=\"page-link\" href=?action=dashboardListPosts&page=" . $page .  ">" . $page . "</a></li>";
                    }
                }
            }
            ?>
            <li class="page-item <?= ($_GET['page'] >= $maxPage) ? 'disabled' : '' ?>">
                <a class="page-link" href="?action=dashboardListPosts&page=<?= (isset($_GET['page'])) ? $_GET['page'] + 1 : 2 ?>">Next</a>
            </li>
        </ul>
    </nav>

    <?php
    while ($data = $posts->fetch()) {
        ?>

        <div class="row ">
            <div class="col-sm-12 m-3 card ">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($data['title']) ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Publié le <?= $data['creation_date_fr'] ?>, rédigé par <?= ucwords($data['firstname']) ?> </h6>
                    <p class="card-text"><?= htmlspecialchars_decode($data['content']) ?></p>
                    <a href="index.php?action=dashboardPost&id=<?= $data['id'] ?>"><button type="button" class="btn btn-outline-info">Commentaires</button></a>
                    <?php if (ucwords($_SESSION['user']['userFirstName']) === 'Jean' && $_SESSION['user']['admin'] === '1') : ?>
                        <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#modifyPost">Modifier</button>
                        <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deletePost">Supprimer</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modifyPost" tabindex="-1" role="dialog" aria-labelledby="modifyPostTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modifyPostTitle">Modifier un article</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deletePost" tabindex="-1" role="dialog" aria-labelledby="deletePostTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deletePostTitle">Suppression d'article</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Vous êtes sur le point de supprimer l'article "<strong><?= htmlspecialchars($data['title']) ?></strong>"</p>
                        <p>Etes-vous sûr(e) de vouloir continuer ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Supprimer</button>
                        <button type="button" class="btn btn-outline-info">Annuler</button>
                    </div>
                </div>
            </div>
        </div>

    <?php
}
$posts->closeCursor();
?>




    <?php
    while ($data = $posts->fetch()) {
        ?>
        <div class="row ">
            <div class="col-sm-12 m-3 card ">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($data['title']) ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Publié le <?= $data['creation_date_fr'] ?></h6>
                    <p class="card-text"><?= nl2br(htmlspecialchars($data['content'])) ?></p>
                    <a href=""><button type="button" class="btn btn-outline-primary">Valider la modification</button></a>
                </div>
            </div>

        </div>

    <?php
}
$posts->closeCursor();
?>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">

            <li class="page-item <?= ($_GET['page'] == 1 || !isset($_GET['page'])) ? 'disabled' : '' ?>">
                <a class="page-link" href="?action=dashboardListPosts&page=<?= $_GET['page'] - 1 ?>" tabindex="-1" aria-disabled="<?= ($_GET['page'] == 1 || !isset($_GET['page'])) ? 'true' : 'false' ?>">Previous</a>
            </li>
            <?php
            for ($page = 1; $page <= $maxPage; $page++) {
                if (isset($_GET['page'])) {
                    if ($_GET['page'] == $page) {
                        echo "<li class=\"page-item active\"><a class=\"page-link\" href=?action=dashboardListPosts&page=" . $page .  ">" . $page .  "</a></li>";
                    } else {
                        echo "<li class=\"page-item\"><a class=\"page-link\" href=?action=dashboardListPosts&page=" . $page .  ">" . $page . "</a></li>";
                    }
                } else {
                    if ($page == 1) {
                        echo "<li class=\"page-item active\"><a class=\"page-link\" href=?action=dashboardListPosts&page=" . $page .  ">" . $page .  "</a></li>";
                    } else {
                        echo "<li class=\"page-item\"><a class=\"page-link\" href=?action=dashboardListPosts&page=" . $page .  ">" . $page . "</a></li>";
                    }
                }
            }
            ?>
            <li class="page-item <?= ($_GET['page'] >= $maxPage) ? 'disabled' : '' ?>">
                <a class="page-link" href="?action=dashboardListPosts&page=<?= (isset($_GET['page'])) ? $_GET['page'] + 1 : 2 ?>">Next</a>
            </li>
        </ul>
    </nav>


</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>
