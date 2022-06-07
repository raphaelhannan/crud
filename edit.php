<?php
// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['id']) && !empty($_POST['id'])
    && isset($_POST['prénom']) && !empty($_POST['prénom'])
    && isset($_POST['age']) && !empty($_POST['age'])
    && isset($_POST['nombre']) && !empty($_POST['nombre'])){
        require_once('connect.php');

        // On nettoie les données envoyées
        $id = strip_tags($_POST['id']);
        $prénom = strip_tags($_POST['prénom']);
        $age = strip_tags($_POST['age']);
        $nombre = strip_tags($_POST['nombre']);

        $sql = 'UPDATE `liste` SET `prénom`=:prénom, `age`=:age, `nombre`=:nombre WHERE `id`=:id;';

        $query = $db->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':prénom', $prénom, PDO::PARAM_STR);
        $query->bindValue(':age', $age, PDO::PARAM_STR);
        $query->bindValue(':nombre', $nombre, PDO::PARAM_INT);

        $query->execute();

        $_SESSION['message'] = "prénom modifié";
        require_once('close.php');

        header('Location: index.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['id']);

    $sql = 'SELECT * FROM `liste` WHERE `id` = :id;';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();

    // On récupère le prénom
    $prénom = $query->fetch();

    // On vérifie si le prénom existe
    if(!$prénom){
        $_SESSION['erreur'] = "Cet id n'existe pas";
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
    <title>Modifier un prénom</title>

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
                <h1>Modifier un prénom</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="prénom">prénom</label>
                        <input type="text" id="prénom" name="prénom" class="form-control" value="<?= $prénom['prénom']?>">
                    </div>
                    <div class="form-group">
                        <label for="age">age</label>
                        <input type="text" id="age" name="age" class="form-control" value="<?= $prénom['age']?>">

                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="number" id="nombre" name="nombre" class="form-control" value="<?= $prénom['nombre']?>">
                    </div>
                    <input type="hidden" value="<?= $prénom['id']?>" name="id">
                    <button class="btn btn-primary">Confirmer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>