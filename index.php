<?php
// On démarre une session
session_start();

// On inclut la connexion à la base
require_once('connect.php');

$sql = 'SELECT * FROM `liste`';

// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau 
$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('close.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des prénoms</title>

</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
            <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur'].'
                            </div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>
                <?php
                    if(!empty($_SESSION['message'])){
                        echo '<div class="alert alert-success" role="alert">
                                '. $_SESSION['message'].'
                            </div>';
                        $_SESSION['message'] = "";
                    }
                ?>
                <h1>Liste</h1>
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>prénom</th>
                        <th>age</th>
                        <th>Nombre</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach($result as $prénom){
                        ?>
                            <tr>
                                <td><?= $prénom['id'] ?></td>
                                <td><?= $prénom['prénom'] ?></td>
                                <td><?= $prénom['age'] ?></td>
                                <td><?= $prénom['nombre'] ?></td>
                                <td><?= $prénom['actif'] ?></td>
                                <td><a href="disable.php?id=<?= $prénom['id'] ?>">A/D</a> <a href="details.php?id=<?= $prénom['id'] ?>">Voir</a> <a href="edit.php?id=<?= $prénom['id'] ?>">Modifier</a> <a href="delete.php?id=<?= $prénom['id'] ?>">Supprimer</a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <a href="add.php" class="btn btn-primary">Ajouter un prénom</a>
            </section>
        </div>
    </main>
</body>
</html>