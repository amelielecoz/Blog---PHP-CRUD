<?php
class Manager
{
    protected function dbConnect()
    {
        $db_options = array(
            // gestion des caractères accentués
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            // choix de récupération des données (assoc / numérique)
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // pour afficher toutes les erreurs, à commenter en production
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
        );

        $db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '', $db_options);

        return $db;
    }
}
