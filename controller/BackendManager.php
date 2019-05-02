<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../../vendor/autoload.php';

require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/UserManager.php');

class BackendManager
{
    public function dashboardListPosts()
    {
        $postManager = new PostManager(); // Create object

        $postCount = $postManager->countPosts();
        $totalPost = $postCount["COUNT(*)"]; //
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
            $offset = 0; //Si offset = 0, on montre 5 à articles en partant du 1er
        }
        $posts = $postManager->getPosts($offset);

        require('view/backend/dashboardListPostsView.php');
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

    public function connexionFormAnswer()
    {
        $erreur = null;
        $userManager = new UserManager();
        $backendManager = new BackendManager();
        if (!empty($_POST['email']) && !empty($_POST['password'])) {  // If the fields are filled
            $userId = $userManager->getUserInfo('id', 'email', $_POST['email']); // Check if email is saved in the DB, get the corresponding ID
            if ($userId) {  // If there is an email saved, $userId is an array, we get the corresponding password
                $userPassword = $userManager->getUserInfo('password', 'id', $userId['id']);
                $userFirstName = $userManager->getUserInfo('firstname', 'id', $userId['id']);
                $userLastName = $userManager->getUserInfo('lastname', 'id', $userId['id']);
                $userEmail = $userManager->getUserInfo('email', 'id', $userId['id']);
                $userAdminStatus = $userManager->getUserInfo('admin', 'id', $userId['id']);
                if (password_verify($_POST['password'], $userPassword['password'])) {
                    $_SESSION['user'] = [
                        'userId' => $userId['id'],
                        'userFirstName' => $userFirstName['firstname'],
                        'userLastName' => $userLastName['lastname'],
                        'userEmail' => $userEmail['email'],
                        'admin' => $userAdminStatus['admin']
                    ];
                    $_SESSION['connected'] = 1;
                    $backendManager->dashboardListPosts();
                } else { //If there is no email saved $userId is a bool(false)
                    $erreur = "Identifiants incorrects";
                    echo 'Identifiants incorrects';
                }
            } else {
                $erreur = "Email non enregistré";
                echo 'Email non enregistré ///';
                echo !$userId;
            }
        } else {
            echo 'Un des champs n\'est pas rempli';
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
        $backendManager = new BackendManager();
        $backendManager->dashboardListPosts();
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
        $backendManager = new BackendManager();
        $backendManager->dashboardListPosts();
    }

    public function addComment($postId, $author, $comment)
    {
        $commentManager = new CommentManager(); // Create object
        $affectedLines = $commentManager->postComment($postId, $author, $comment); // Call object public function

        if ($affectedLines === false) {
            die('Impossible d\'ajouter le commentaire !');
        } else {
            header('Location: index.php?action=post&id=' . $postId);
        }
    }

    //ADDING COMMENTS
    public function comment()
    {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                $backendManager = new BackendManager();
                $backendManager->addComment($_GET['id'], $_POST['author'], $_POST['comment']);
            } else {
                throw new Exception('tous les champs ne sont pas remplis !');
            }
        } else {
            throw new Exception('aucun identifiant de billet envoyé');
        }
    }


    public function reportComment()
    {
        $postInMemory = $_GET['id'];
        $commentManager = new CommentManager(); // Create object
        $reportedComment = $commentManager->reportComment($_POST['comment_id']);


        // Send an email to the admin
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";

        try {
            //Server settings
            //$mail->SMTPDebug = 2;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = 'smtp.ionos.fr';  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'blog@amelielecoz.com';                     // SMTP username
            $mail->Password   = '?s8MkxL%75';                               // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );                                // TCP port to connect to

            //Recipients
            $mail->setFrom('blog@amelielecoz.com');
            $mail->addAddress('lecozamelie@hotmail.com');     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Blog de Jean : Un comentaire a été signalé par un membre';
            $mail->Body = htmlspecialchars($_SESSION['user']['userFirstName']) . ' ' . htmlspecialchars($_SESSION['user']['userLastName'])
                . ' vous a signalé le commentaire suivant : </br>'
                . 'Id du commentaire : ' . htmlspecialchars($_POST['comment_id'])
                . ' </br> Contenu du commentaire : ' . nl2br(htmlspecialchars($_POST['comment_content']))
                . ' </br> Posté le ' . htmlspecialchars($_POST['comment_date']) . ' par : ' . htmlspecialchars($_POST['comment_author']);


            $mail->send();
            $reportConfirmation = "Le commentaire a bien été signalé aux administrateurs";
            $_POST = null;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        $_POST = null;

        if (isset($postInMemory) && $postInMemory > 0) {
            $postManager = new PostManager();
            $commentManager = new CommentManager();

            $post = $postManager->getPost($postInMemory);
            $comments = $commentManager->getComments($postInMemory);

            require('view/backend/dashboardPostView.php');
        } else {
            throw new Exception('aucun identifiant de billet envoyé');
        };
    }

    public function deletePost()
    {
        $postManager = new PostManager(); // Create object
        $commentManager = new CommentManager(); // Create object
        $postManager->deletePost($_GET['id']);
        $commentManager->deleteComments($_GET['id']);
        header('Location: index.php');
    }

    public function logout()
    {
        session_start();
        session_destroy();
        unset($_SESSION);
        header('Location: index.php');
    }
}
