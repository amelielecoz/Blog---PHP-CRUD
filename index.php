<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
require_once('controller/PostController.php');
require_once('controller/UserController.php');
require_once('controller/FrontController.php');
require_once('controller/CommentController.php');


try {
    $postController = new PostController();
    $userController = new UserController();
    $frontendController = new FrontController();
    $commentController = new CommentController();

    if (!isset($_SESSION['connected'])) { // if user is not connected

        if (isset($_GET['action'])) {

            switch($_GET['action']) {
                case 'contact' :
                    $frontendController->contactForm();
                    break;
                case 'contactAnswer' :
                    $frontendController->contactFormAnswer();
                    break;
                case 'about' :
                    $frontendController->about();
                    break;
                case 'privacy' :
                    $frontendController->privacy();
                    break;
                case 'credits' :
                    $frontendController->credits();
                    break;
                case 'connexion' :
                    $userController->connexionForm();
                    break;
                case 'connexionAnswer' :
                    $userController->connexionFormAnswer();
                    break;
                case 'subscription' :
                    $userController->subscriptionForm();
                    break;
                case 'subscribe' :
                    $userController->subscriptionFormAnswer();
                    break;
                case 'listPosts' :
                    $postController->listPosts();
                    break;
                case 'post' :
                    $postController->showOnePost();
                    break;
                default :
                    $postController->listPosts();
            }
        } else {
            $postController->listPosts();
        }
    } elseif (isset($_SESSION['connected'])) {

        if (isset($_GET['action'])) {

            switch($_GET['action']) {
                case 'logout' :
                    $userController->logout();
                    break;
                case 'dashboardListPosts' :
                    $postController->dashboardListPosts();
                    break;
                case 'post' :
                    $postController->dashboardOnePost();
                    break;
                case 'addPostForm' :
                    $postController->addPostForm();
                    break;
                case 'addPost' :
                    $postController->addPostFormAnswer();
                    break;
                case 'modifyPostForm' :
                    $postController->modifyPostForm();
                    break;
                case 'modifyPost' :
                    $postController->modifyPostFormAnswer();
                    break;
                case 'delete' :
                    $postController->deletePost();
                    break;
                case 'addComment' :
                    $commentController->comment();
                    break;
                case 'report' :
                    $commentController->reportComment();
                    break;
                case 'commentAdmin' :
                    $commentController->commentAdmin();
                    break;
                case 'authorizeComment' :
                    $commentController->authorizeComment();
                    break;
                case 'deleteComment' :
                    $commentController->deleteComment();
                    break;
                case 'contact' :
                    $frontendController->contactForm();
                    break;
                case 'contactAnswer' :
                    $frontendController->contactFormAnswer();
                    break;
                case 'about' :
                    $frontendController->about();
                    break;
                case 'privacy' :
                    $frontendController->privacy();
                    break;
                case 'credits' :
                    $frontendController->credits();
                    break;
                default :
                    $postController->dashboardListPosts();
            }
        } else {
            $postController->dashboardListPosts();
        }
    } else {
        $postController->listPosts();
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
