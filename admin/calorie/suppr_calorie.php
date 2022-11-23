<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: connexion.php");
    exit;
}
var_dump($_GET);
if(isset($_GET["id_calorie"], $_GET["id_membre"], $_GET["date"]) && !empty($_GET["id_calorie"]) && !empty($_GET["id_membre"]) && !empty($_GET["date"])){
    $id_calorie = (is_numeric($_GET["id_calorie"])) ? (int)$_GET["id_calorie"] : 0;
    $id_membre = (is_numeric($_GET["id_membre"])) ? (int)$_GET["id_membre"] : 0;
    $_SESSION["error"] = [];
    if($id_calorie === 0 || $id_membre === 0) {
        $_SESSION["error"][] = "Une erreur est survenue avec l'id-calorie";
    }
    require_once "../includes/function.php";
    if(!validateDate($_GET["date"], 'Y-m-d')){
        $_SESSION["error"][] = "Une erreur est survenue avec la date.";
    }
    if($_SESSION["error"] === []) {
        $date = $_GET["date"];
        include_once "../../includes/connect.php";
        $sql = "SELECT * FROM `calories` WHERE `id_calorie` = :id_calorie AND `date` = :datec AND id_membre = :id_membre";
        $query = $db->prepare($sql);
        $query->bindValue(":id_calorie", $id_calorie , PDO::PARAM_STR);
        $query->bindValue(":datec", $date , PDO::PARAM_STR);
        $query->bindValue(":id_membre", $id_membre , PDO::PARAM_STR);
        $query->execute();
        $data = $query->fetch();
        if($data) {
            $sql = "DELETE FROM `calories` WHERE `id_calorie` = :id_calorie AND `date` = :datec AND id_membre = :id_membre";
            $query = $db->prepare($sql);
            $query->bindValue(":id_calorie", $id_calorie , PDO::PARAM_STR);
            $query->bindValue(":datec", $date , PDO::PARAM_STR);
            $query->bindValue(":id_membre", $id_membre , PDO::PARAM_STR);
            $query->execute();
            $_SESSION["valid"] = ["La valeur a bien été supprimé !"];
            header("Location: ../table_calorie.php");
        } else {
            $_SESSION["error"] = ["Une erreur est survenue"];
            header("Location: ../table_calorie.php");
        } 
    } else {
        $_SESSION["error"] = ["Une erreur est survenue"];
        header("Location: ../table_calorie.php");
    }
} else {
    $_SESSION["error"] = ["Une erreur est survenue"];
    header("Location: ../table_calorie.php");
}

?>