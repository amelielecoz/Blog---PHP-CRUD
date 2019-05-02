<?php

require_once("model/Manager.php");

class CommentManager extends Manager
{

    public function getComments($postId)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\')
        AS comment_date_fr
        FROM comments
        WHERE post_id = ? AND status = 0
        ORDER BY comment_date
        DESC');
        $comments->bindValue(1, $postId, PDO::PARAM_INT);
        $comments->execute();

        return $comments;
    }

    public function postComment($postId, $author, $comment)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?, ?, ?, NOW())');
        $comments->bindValue(1, $postId, PDO::PARAM_INT);
        $comments->bindValue(2, $author, PDO::PARAM_STR);
        $comments->bindValue(3, $comment, PDO::PARAM_STR);
        $comments->execute();

        return $comments;
    }

    public function reportComment($postId)
    {
        $db = $this->dbConnect();
        $reportedComment = $db->prepare('UPDATE comments SET status = 1 WHERE id = ?');
        $reportedComment->bindValue(1, $postId, PDO::PARAM_INT);
        $reportedComment->execute();

        return $reportedComment;
    }

    public function deleteComments($postId)
    {
        $db = $this->dbConnect();
        $deletedComment = $db->prepare('DELETE FROM comments WHERE post_id=?');
        $deletedComment->bindValue(1, $postId, PDO::PARAM_INT);
        $deletedComment->execute();

        return $deletedComment;
    }
}
