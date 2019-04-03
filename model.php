<?php

function getPosts() {
    try
    {
        $bd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }
    
$req = $bd->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%i\') AS creation_date_fr FROM posts ORDER BY creation_date LIMIT 0, 5');

}
