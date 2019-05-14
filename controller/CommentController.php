<?php

require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/UserManager.php');

class CommentController
{
    public function addComment($postId, $author, $comment, $id_user)
    {
        $commentManager = new CommentManager(); // Create object
        $affectedLines = $commentManager->postComment($postId, $author, $comment, $id_user); // Call object public function

        if ($affectedLines === false) {
            die('Impossible d\'ajouter le commentaire !');
        } else {
            header('Location: index.php?action=post&id=' . $postId);
        }
    }

    public function comment()
    {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                $this->addComment($_GET['id'], $_POST['author'], $_POST['comment'], $_POST['id_user']);
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
        $to      = 'lecozamelie@hotmail.com';
        $subject = 'Blog de Jean : Un comentaire a été signalé par un membre';
        $message = htmlspecialchars($_SESSION['user']['userFirstName']) . " " . htmlspecialchars($_SESSION["user"]["userLastName"])
            . " vous a signalé le commentaire suivant :"
            . "\r\n" . "Id du commentaire : " . htmlspecialchars($_POST["comment_id"])
            . "\r\n" . "Contenu du commentaire : " . nl2br(htmlspecialchars($_POST["comment_content"]))
            . "\r\n" . "Posté le " . htmlspecialchars($_POST["comment_date"]) . " par : " . htmlspecialchars($_POST["comment_author"]);
        $headers = 'From: blog@amelielecoz.com' . "\r\n" .
            'Reply-To: blog@amelielecoz.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        try {
            mail($to, $subject, $message, $headers);
            $reportConfirmation = "Le commentaire a bien été signalé aux administrateurs";
            $_POST = null;
        } catch (Exception $e) {
            echo "Message could not be sent.";
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
        }
    }

    public function commentAdmin()
    {
        $commentManager = new CommentManager(); // Create object
        $comments = $commentManager->getReportedComments();
        require('view/backend/dashboardCommentAdminView.php');
    }

    public function authorizeComment()
    {
        $commentManager = new CommentManager(); // Create object
        $commentManager->authorizeComment($_GET['id']);
        $confirmationComment = "Le commentaire apparaît à nouveau sur votre site";
        $comments = $commentManager->getReportedComments();
        require('view/backend/dashboardCommentAdminView.php');
    }

    public function deleteComment()
    {
        $commentManager = new CommentManager(); // Create object
        $commentManager->deleteComment($_GET['id']);
        $confirmationComment = "Le commentaire n'apparaît plus sur votre site";
        $comments = $commentManager->getReportedComments();
        require('view/backend/dashboardCommentAdminView.php');
    }
}
