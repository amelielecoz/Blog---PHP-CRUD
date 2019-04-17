<?php
require_once("model/Manager.php");

class PostManager extends Manager
{

    public function getPosts($offset)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT p.id, p.title, p.content, DATE_FORMAT(p.creation_date, \'%d/%m/%Y à %Hh%i\')
                                AS creation_date_fr, u.firstname
                                FROM posts AS p
                                INNER JOIN users AS u
                                ON u.id = p.id_user
                                ORDER BY creation_date
                                DESC
                                LIMIT ?, 5'); //Offset has to be 5, to show articles from 6 to 10, inclusive


        $req->bindValue(1, $offset, PDO::PARAM_INT);
        $req->execute();
        return $req;
    }

    public function countPosts()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT COUNT(*) FROM posts');
        $data = $req->fetch();
        return $data;
    }

    public function getPostsByAuthor($idUser)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%i\') AS creation_date_fr FROM posts WHERE id_user = ? ORDER BY creation_date');
        $req->execute(array($idUser));

        return $req;
    }

    public function getPost($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%i\') AS creation_date_fr FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $post = $req->fetch();

        return $post;
    }

    public function addPost($title, $content, $id_user)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO posts(title, content, creation_date, id_user) VALUES (?, ?, NOW(), ?)');
        $req->execute(array($title, $content, $id_user));

        return $req;
    }
}
