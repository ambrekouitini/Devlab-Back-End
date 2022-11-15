<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
        <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    
<title>Mon Compte</title>
</head>
<body>

<nav class="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
        <img src="image/logo-spa.png" alt="Logo" width="55" height="55" class="d-inline-block align-text-bottom">
        Société Protectrice des Animaux
        </a>
        <a class='btn btn-outline-success btn-lg' href="logout.php">Déconnexion</a>
    </div>
</nav>
<div class="container-form-addpet">
        <h1>Ajouter Animaux</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="exampleInputName" class="form-label">Nom de l'animal</label>
                <input type="text" name="name" placeholder="Nom" class="form-control" id="exampleInputName" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputType" class="form-label">Race de l'animal</label>
                <input type="text" name="type" placeholder="Race" class="form-control" id="exampleInputType" aria-describedby="emailHelp">
            </div>
            <button type="submit" name="addpet"class="btn btn-primary">Enregistrer</button>
        </form>
</div>


    <?php
    require_once 'connection.php';
    require_once 'pet.php';
    require_once 'user.php';
    $connection = new Connection();
    $touslesusers = $connection->getUsers();
    $touslespet = $connection->getAnimals();
    $allpets = $connection->getAnimalsFromID($_SESSION['id']);

    if (isset($_POST["addpet"])) {
        $pet = new Pet(
            $_POST['name'],
            $_POST['type'],
            $_SESSION['id'],
        );

        $connection = new Connection();
        $ajout = $connection->insertPet($pet);
            if ($ajout) {
                echo 'Animal ajouté';
                header('Location: my-account.php');
            } else {
                echo 'Internal error 🥲';
            }
        }
    ?>
    <div class="printpet">
        <h2>Mes Animaux</h2>
        <?php foreach ($allpets as $animal) { ?>
            <?php if ($_SESSION['id']==$animal['user_id']){ ?>
                <div class="pet_user">
                    <p> <?= $animal['name'] .' - '. $animal['type']?><p>
                    <form method="POST" action="my-account.php">
                        <input type="hidden" name="delete_pet" value="<?= $animal["id"]; ?>">
                        <input type="submit" name="deletePet" value="supprimer">
                    </form>
                </div>
                <br>
            <?php } ?>
        <?php } ?>
    </div>

    <?php
        if(isset($_POST["deletePet"])){
            $connection->deletePet($_POST["delete_pet"]);
            header('Location: my-account.php');
        }
    ?>
    
</body>
</html>