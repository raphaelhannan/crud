<?php
// On démarre une session
session_start();

// id existe et non vides
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['id']);

    $sql = 'SELECT * FROM `liste` WHERE `id` = :id;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère le prénom
    $prénom = $query->fetch();

    // On vérifie si le prénom existe
    if(!$prénom){
        $_SESSION['erreur'] = "Ce prénom n'existe pas";
        header('Location: index.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du prénom</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Détails du prénom <?= $prénom['prénom'] ?></h1>
                <p>ID : <?= $prénom['id'] ?></p>
                <p>prénom : <?= $prénom['prénom'] ?></p>
                <p>age : <?= $prénom['age'] ?></p>
                <p>Nombre : <?= $prénom['nombre'] ?></p>
                <p><a href="index.php">Retour</a> <a href="edit.php?id=<?= $prénom['id'] ?>">Modifier</a></p>
            </section>
        </div>
    </main>
</body>
</html>