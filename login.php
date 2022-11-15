<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>

    <h1>Connexion</h1>
    <form method="POST">
        <label for="email">Adresse Mail</label>
        <input type="text" name="email" placeholder="Entrer votre adresse mail">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" placeholder="Entrer votre mot de passe">
        <button type="submit" name="login">Submit</button>
    </form>
    <p>Pas encore membre ? Inscrivez vous <a href="signin.php"> ici</a>.</p>

<?php 
require_once 'connection.php';
require_once 'user.php'; 

if($_POST){
    if(isset($_POST['login'])){
        $connection = new Connection();
        $email = $_POST['email'];
        $user = $connection->log($email);

        if(md5($_POST['password'] . 'SALT' ) === $user['password']){
            $_SESSION['email'] = $user['email'];
            $_SESSION['password'] = $user['password'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['id'] = $user['id'];
            echo $_SESSION['username'];
            if($_SESSION['role'] == 0){
                header('Location: index.php');
            }
        }   
    else {
        echo 'Erreur connexion';
    }
}}

?>

</body>
</html>