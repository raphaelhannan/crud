<?php
// On démarre une session
session_start();

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['id']);

    $sql = 'SELECT * FROM `liste` WHERE `id` = :id;';
    $query = $db->prepare($sql);
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

    $actif = ($prénom['actif'] == 0) ? 1 : 0;

    $sql = 'UPDATE `liste` SET `actif`=:actif WHERE `id` = :id;';
    $query = $db->prepare($sql);

    // On "accroche" les paramètres
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->bindValue(':actif', $actif, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();
    
    header('Location: index.php');

}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
}

