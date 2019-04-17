<?php
$title = 'Mon blog';
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
    <h2>Derniers billets du blog :</h2>
    <?php ?>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">

            <li class="page-item <?= ($_GET['page'] == 1 || !isset($_GET['page'])) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $_GET['page'] - 1 ?>" tabindex="-1" aria-disabled="<?= ($_GET['page'] == 1 || !isset($_GET['page'])) ? 'true' : 'false' ?>">Previous</a>
            </li>
            <?php
            for ($page = 1; $page <= $maxPage; $page++) {
                if (isset($_GET['page'])) {
                    if ($_GET['page'] == $page) {
                        echo "<li class=\"page-item active\"><a class=\"page-link\" href=?page=" . $page .  ">" . $page .  "</a></li>";
                    } else {
                        echo "<li class=\"page-item\"><a class=\"page-link\" href=?page=" . $page .  ">" . $page . "</a></li>";
                    }
                } else {
                    if ($page == 1) {
                        echo "<li class=\"page-item active\"><a class=\"page-link\" href=?page=" . $page .  ">" . $page .  "</a></li>";
                    } else {
                        echo "<li class=\"page-item\"><a class=\"page-link\" href=?page=" . $page .  ">" . $page . "</a></li>";
                    }
                }
            }
            ?>
            <li class="page-item <?= ($_GET['page'] >= $maxPage) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $_GET['page'] + 1 ?>">Next</a>
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
                    <h6 class="card-subtitle mb-2 text-muted">Publié le <?= $data['creation_date_fr'] ?></h6>
                    <p class="card-text"><?= nl2br(htmlspecialchars($data['content'])) ?></p>
                    <a href="index.php?action=post&id=<?= $data['id'] ?>"><button type="button" class="btn btn-outline-primary">Commentaires</button></a>
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
                <a class="page-link" href="?page=<?= $_GET['page'] - 1 ?>" tabindex="-1" aria-disabled="<?= ($_GET['page'] == 1 || !isset($_GET['page'])) ? 'true' : 'false' ?>">Previous</a>
            </li>
            <?php
            for ($page = 1; $page <= $maxPage; $page++) {
                if (isset($_GET['page'])) {
                    if ($_GET['page'] == $page) {
                        echo "<li class=\"page-item active\"><a class=\"page-link\" href=?page=" . $page .  ">" . $page .  "</a></li>";
                    } else {
                        echo "<li class=\"page-item\"><a class=\"page-link\" href=?page=" . $page .  ">" . $page . "</a></li>";
                    }
                } else {
                    if ($page == 1) {
                        echo "<li class=\"page-item active\"><a class=\"page-link\" href=?page=" . $page .  ">" . $page .  "</a></li>";
                    } else {
                        echo "<li class=\"page-item\"><a class=\"page-link\" href=?page=" . $page .  ">" . $page . "</a></li>";
                    }
                }
            }
            ?>
            <li class="page-item <?= ($_GET['page'] >= $maxPage) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $_GET['page'] + 1 ?>">Next</a>
            </li>
        </ul>
    </nav>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
