<?php

require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/UserManager.php');

class PostController {

    public function listPosts()
    {
        $postManager = new PostManager();
        $postCount = $postManager->countPosts();
        $totalPost = $postCount["COUNT(*)"];
        if (($totalPost % 5) == 0) {
            $maxPage = $totalPost / 5;
        } else {
            $maxPage = ($totalPost / 5) + 1 - ($totalPost % 5) / 5;
        }
        if (isset($_GET['page'])) {
            if ($_GET['page'] <= 0 || $_GET['page'] > $maxPage) {
                $_GET['page'] = 1;
                $offset = 0;
            } else {
                $offset = ($_GET['page'] - 1) * 5;
            }
        } else {
            $offset = 0;
        }
        $posts = $postManager->getPosts($offset);
        require('view/frontend/homeViewWithPics.php');
    }



    public function dashboardListPosts()
    {
        $postManager = new PostManager();
        $postCount = $postManager->countPosts();
        $totalPost = $postCount["COUNT(*)"];
        if (($totalPost % 5) == 0) {
            $maxPage = $totalPost / 5;
        } else {
            $maxPage = ($totalPost / 5) + 1 - ($totalPost % 5) / 5;
        }
        if (isset($_GET['page'])) {
            if ($_GET['page'] <= 0 || $_GET['page'] > $maxPage) {
                $_GET['page'] = 1;
                $offset = 0;
            } else {
                $offset = ($_GET['page'] - 1) * 5;
            }
        } else {
            $offset = 0;
        }
        $posts = $postManager->getPosts($offset);
        require('view/backend/dashboardListPostsView.php');
    }

    public function showOnePost()
    {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $postManager = new PostManager();
            $commentManager = new CommentManager();
            $post = $postManager->getPost($_GET['id']);
            $comments = $commentManager->getComments($_GET['id']);
            require('view/frontend/postViewWithPics.php');
        } else {
            throw new Exception('aucun identifiant de billet envoyé');
        }
    }

    public function dashboardOnePost()
    {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $postManager = new PostManager();
            $commentManager = new CommentManager();
            $post = $postManager->getPost($_GET['id']);
            $comments = $commentManager->getComments($_GET['id']);
            require('view/backend/dashboardPostView.php');
        } else {
            throw new Exception('aucun identifiant de billet envoyé');
        }
    }

    public function addPostForm()
    {
        require('view/backend/dashboardAddNewPost.php');
    }

    public function addPostFormAnswer()
    {
        $postManager = new PostManager();
        $postAdded = $postManager->addPost($_POST['title'], $_POST['content'], $_SESSION['user']['userId']);
        $_POST = null;
        $this->dashboardListPosts();
    }

    public function modifyPostForm()
    {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $postManager = new PostManager();
            $commentManager = new CommentManager();

            $post = $postManager->getPost($_GET['id']);
            $comments = $commentManager->getComments($_GET['id']);

            require('view/backend/dashboardModifyPost.php');
        } else {
            throw new Exception('aucun identifiant de billet envoyé');
        }
    }

    public function modifyPostFormAnswer()
    {
        $postManager = new PostManager();
        $postManager->modifyPost($_POST['title'], $_POST['content'], $_GET['id']);
        $_POST = null;
        $this->dashboardListPosts();
    }

    public function deletePost()
    {
        $postManager = new PostManager(); // Create object
        $commentManager = new CommentManager(); // Create object
        $commentManager->deleteComments($_GET['id']);
        $postManager->deletePost($_GET['id']);
        header('Location: index.php');
    }
}
