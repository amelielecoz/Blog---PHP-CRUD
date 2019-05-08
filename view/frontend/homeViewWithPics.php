<?php
$title = 'Blog de Jean';
?>

<?php ob_start(); ?>


<main class="main pt-4" role="main">

    <div class="container">
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

        <div class="row">
            <div class="col-md-6 col-sm-10 col-xs-10 mx-auto">

                <?php
                while ($data = $posts->fetch()) {
                    ?>

                    <article class="card mb-4">
                        <header class="card-header">
                            <div class="card-meta">
                                <a href="#"><time class="timeago"><?= $data['creation_date_fr'] ?></time></a>
                            </div>
                            <a href="index.php?action=post&id=<?= $data['id'] ?>">
                                <h4 class="card-title"><?= htmlspecialchars_decode($data['title']) ?></h4>
                            </a>
                        </header>
                        <a href="index.php?action=post&id=<?= $data['id'] ?>">
                            <img class="card-img" src="./public/images/articles/<?= $data['id'] % 22 ?>.jpg" alt="" />
                        </a>
                        <div class="card-body">
                            <p class="card-text"><?= nl2br(htmlspecialchars_decode($data['content'])) ?> </p>
                        </div>
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

</main>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
