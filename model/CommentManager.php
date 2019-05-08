<?php

require_once("model/Manager.php");

class CommentManager extends Manager
{

    public function getComments($postId)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('SELECT id, author, comment, id_user, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\')
        AS comment_date_fr
        FROM comments
        WHERE post_id = ? AND status = 0
        ORDER BY comment_date
        DESC');
        $comments->bindValue(1, htmlspecialchars($postId), PDO::PARAM_INT);
        $comments->execute();

        return $comments;
    }

    public function postComment($postId, $author, $comment, $id_user)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('INSERT INTO comments(post_id, author, comment, id_user, comment_date) VALUES(?, ?, ?, ?, NOW())');
        $comments->bindValue(1, $postId, PDO::PARAM_INT);
        $comments->bindValue(2, $author, PDO::PARAM_STR);
        $comments->bindValue(3, htmlspecialchars($comment), PDO::PARAM_STR);
        $comments->bindValue(4, $id_user, PDO::PARAM_INT);
        $comments->execute();

        return $comments;
    }

    public function reportComment($postId)
    {
        $db = $this->dbConnect();
        $reportedComment = $db->prepare('UPDATE comments SET status = 1 WHERE id = ?');
        $reportedComment->bindValue(1, htmlspecialchars($postId), PDO::PARAM_INT);
        $reportedComment->execute();

        return $reportedComment;
    }

    public function deleteComments($postId)
    {
        $db = $this->dbConnect();
        $deletedComment = $db->prepare('DELETE FROM comments WHERE post_id=?');
        $deletedComment->bindValue(1, htmlspecialchars($postId), PDO::PARAM_INT);
        $deletedComment->execute();

        return $deletedComment;
    }

    public function getReportedComments()
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\')
        AS comment_date_fr
        FROM comments
        WHERE status=1
        ORDER BY comment_date
        DESC');
        $comments->execute();

        return $comments;
    }

    public function authorizeComment($postId)
    {
        $db = $this->dbConnect();
        $reportedComment = $db->prepare('UPDATE comments SET status = 0 WHERE id = ?');
        $reportedComment->bindValue(1, htmlspecialchars($postId), PDO::PARAM_INT);
        $reportedComment->execute();

        return $reportedComment;
    }

    public function deleteComment($postId)
    {
        $db = $this->dbConnect();
        $reportedComment = $db->prepare('UPDATE comments SET status = 2 WHERE id = ?');
        $reportedComment->bindValue(1, htmlspecialchars($postId), PDO::PARAM_INT);
        $reportedComment->execute();

        return $reportedComment;
    }
}
