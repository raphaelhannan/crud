<?php
// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['prénon']) && !empty($_POST['prénom'])
    && isset($_POST['age']) && !empty($_POST['age'])
    && isset($_POST['nombre']) && !empty($_POST['nombre'])){
        // On inclut la connexion à la base
        require_once('connect.php');

        // On nettoie les données envoyées
        $prénom = strip_tags($_POST['produit']);
        $age = strip_tags($_POST['prix']);
        $nombre = strip_tags($_POST['nombre']);

        $sql = 'INSERT INTO `liste` (`prénom`, `age`, `nombre`) VALUES (:prénom, :age, :nombre);';

        $query = $db->prepare($sql);

        $query->bindValue(':prénom', $produit, PDO::PARAM_STR);
        $query->bindValue(':age', $prix, PDO::PARAM_STR);
        $query->bindValue(':nombre', $nombre, PDO::PARAM_INT);

        $query->execute();

        $_SESSION['message'] = "Prénom validé";
        require_once('close.php');

        header('Location: index.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment tu t'appel</title>


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
                <h1>Comment tu t'appel ?</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="prénom">Prénom</label>
                        <input type="text" id="prénom" name="prénom" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="age">age</label>
                        <input type="number" id="nombre" name="age" class="form-control">

                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="number" id="nombre" name="nombre" class="form-control">
                    </div>
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>