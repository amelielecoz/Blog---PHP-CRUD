<?php

//gère les utilisateurs, rangs, etc
//modele inscription > ajouter utilisateur à la base

require_once("model/Manager.php");

class UserManager extends Manager
{

    public function getUserInfo($infoNeeded, $infoProvided, $userEmail)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT ' . $infoNeeded . ' FROM users WHERE ' . $infoProvided . '=?');
        $req->bindValue(1, $userEmail, PDO::PARAM_STR);
        $req->execute();
        $userInfo = $req->fetch();
        return $userInfo;
    }

    public function addNewUser($userEmail, $userPassword, $userFirstName, $userLastName)
    {
        $db = $this->dbConnect();
        $user = $db->prepare('INSERT INTO users(email, password, firstname, lastname) VALUES(?, ?, ?, ?)');
        $addedUser = $user->execute(array($userEmail, $userPassword, $userFirstName, $userLastName));

        return $addedUser;
    }
}
