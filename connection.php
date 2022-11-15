<?php

class Connection
{
    public PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:dbname=backend-project;host=127.0.0.1', 'root', 'root');
    }

    public function insert(User $user): bool
    {
        $query = 'INSERT INTO user (email, password, username)
                VALUES (:email, :password, :username)';

        $statement = $this->pdo->prepare($query);

        return $statement->execute([
            'email' => $user->email,
            'password'=>md5($user->password . 'SALT'),
            'username' => $user->username,
        ]);
    }

    public function log($email)
    {

        $jeRecup = $this->pdo->prepare("SELECT * FROM user WHERE email = '$email' ");
        $jeRecup->execute();
        $datas=$jeRecup->fetch();
        return $datas;
    }
}