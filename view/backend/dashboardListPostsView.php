<?php
$title = 'Tableau de bord';
?>

<?php ob_start(); ?>

<div class="container">

    <h1>Bienvenue, <?= ucwords($_SESSION['user']['userFirstName']) ?>!</h1>
    <?php if ($_SESSION['user']['admin'] === '1') : ?>
        <div class="d-flex justify-content-around m-5">
            <a href="index.php?action=addPostForm"><button type="button" class="btn btn-outline-dark">Ecrire un nouveau billet</button></a>
            <a href="index.php?action=commentAdmin"><button type="button" class="btn btn-outline-dark">Administration des commentaires</button></a>
        </div>
    <?php endif; ?>


    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">

            <li class="page-item <?= ($_GET['page'] == 1 || !isset($_GET['page'])) ? 'disabled' : '' ?>">
                <a class="page-link" href="?action=dashboardListPosts&page=<?= $_GET['page'] - 1 ?>" tabindex="-1" aria-disabled="<?= ($_GET['page'] == 1 || !isset($_GET['page'])) ? 'true' : 'false' ?>">Précédent</a>
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
                <a class="page-link" href="?action=dashboardListPosts&page=<?= (isset($_GET['page'])) ? $_GET['page'] + 1 : 2 ?>">Suivant</a>
            </li>
        </ul>
    </nav>


    <div class="row">
        <div class="col-md-6 col-sm-10 col-xs-10 mx-auto">

            <?php
            while ($data = $posts->fetch()) {
                ?> <article class="card mb-4">
                    <header class="card-header">
                        <div class="card-meta">
                            <p><?= $data['creation_date_fr'] ?></p>
                        </div>
                        <a href="index.php?action=post&id=<?= $data['id'] ?>">
                            <h4 class="card-title"><?= htmlspecialchars_decode($data['title']) ?></h4>
                        </a>
                        <?php if ($_SESSION['user']['admin'] === '1') : ?>
                            <form action="index.php?action=modifyPostForm&id=<?= $data['id'] ?>" method="post">
                                <button class="btn btn-secondary btn-sm float-right" type="submit"> <span class="fas fa-pencil-alt"></span> Modifier </button>
                            </form>
                            <form onsubmit="return confirmationDelete();" action="index.php?action=delete&id=<?= $data['id'] ?>" method="post">
                                <button class="btn btn-secondary btn-sm float-right mr-2" type="submit"> <span class="fas fa-trash-alt"></span> Supprimer </button>
                            </form>
                        <?php endif; ?>
                    </header>
                    <a href="index.php?action=post&id=<?= $data['id'] ?>">
                        <img class="card-img" src="./public/images/articles/<?= $data['id'] % 22 ?>.jpg" alt="" />

                        <div class="card-body">
                            <p class="card-text"><?= nl2br(htmlspecialchars_decode($data['content'])) ?> </p>
                        </div>
                    </a>
                </article><!-- /.card -->
            <?php
        }
        $posts->closeCursor();
        ?>

        </div>

    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">

            <li class="page-item <?= ($_GET['page'] == 1 || !isset($_GET['page'])) ? 'disabled' : '' ?>">
                <a class="page-link" href="?action=dashboardListPosts&page=<?= $_GET['page'] - 1 ?>" tabindex="-1" aria-disabled="<?= ($_GET['page'] == 1 || !isset($_GET['page'])) ? 'true' : 'false' ?>">Précédent</a>
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
                <a class="page-link" href="?action=dashboardListPosts&page=<?= (isset($_GET['page'])) ? $_GET['page'] + 1 : 2 ?>">Suivant</a>
            </li>
        </ul>
    </nav>

</div>


<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>
