<?php

require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/UserManager.php');

function dashboardOnePost()
{
    if (isset($_GET['id']) && $_GET['id'] > 0) {
        $postManager = new PostManager();
        $commentManager = new CommentManager();

        $post = $postManager->getPost($_GET['id']);
        $comments = $commentManager->getComments($_GET['id']);

        require('view/frontend/dashboardPostView.php');
    } else {
        throw new Exception('aucun identifiant de billet envoyé');
    }
}
