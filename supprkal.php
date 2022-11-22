<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: connexion.php");
    exit;
}
if(!empty($_POST)) {
    if (isset($_POST["supprdate"]) && !empty($_POST["supprdate"])) {
        include "includes/function.php";
        $_SESSION["error"] = [];
        if (!validateDate($_POST["supprdate"], 'Y-m-d')) {
            $_SESSION["error"][] = "Une erreur est survenue dans le format de la date 📆";
        }
        if ($_SESSION["error"] === []){
            $date = $_POST["supprdate"];
            $today = new DateTime();
            $newDate = new DateTime($date);
            if ($today < $newDate) {
                $_SESSION["error"] = ["La date ne correspond pas (la date doit être aujourd'hui ou dans les 10 derniers jours) 📆"];
            }
            $today->modify('-10 day');
            if ($newDate < $today) {
                $_SESSION["error"] = ["La date ne correspond pas (la date doit être aujourd'hui ou dans les 10 derniers jours) 📆"];
            }
            if ($_SESSION["error"] === []){
                require "includes/connect.php";
                $sql = "SELECT * FROM `calories` WHERE `date` = :datechoisie AND `id_membre` = :id";
                $query = $db->prepare($sql);
                $query->bindValue(":datechoisie", $date, PDO::PARAM_STR);
                $query->bindValue(":id", $_SESSION["user"]["id"], PDO::PARAM_STR);
                $query->execute();
                $data = $query->fetchAll();
                
                // Si la date existe la supprimer, sinon ne rien faire
                if(!empty($data)) {
                    echo $date;
                    echo $_SESSION["user"]["id"];
                    $sql = "DELETE FROM `calories` WHERE `date` = :datechoisie AND `id_membre` = :id";
                    $query = $db->prepare($sql);
                    $query->bindValue(":datechoisie", $date, PDO::PARAM_STR);
                    $query->bindValue(":id", $_SESSION["user"]["id"], PDO::PARAM_STR);
                    $query->execute();
                    $_SESSION["validinsertcalorie"] = ["Vos données ont bien été supprimé ! ✔️"];
                    header("Location: index.php");
                } else {
                    $_SESSION["validinsertcalorie"] = ["Vos données ont bien été supprimé ! ✔️"];
                    header("Location: index.php");
                }
            } else {
                header("Location: index.php");
            }
        } else {
            header("Location: index.php");
        }
    } else {
        $_SESSION["erreur"] = ["Une erreur est survenue ‼️"];
        header("Location: index.php");
    }
} else {
    $_SESSION["erreur"] = ["Une erreur est survenue ‼️"];
    header("Location: index.php");
}
?>