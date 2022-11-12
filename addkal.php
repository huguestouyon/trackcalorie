<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: connexion.php");
    exit;
}
// Formulaire d'ajout de calories
if (!empty($_POST)) {
    if (isset($_POST["kalnb"], $_POST["kaldate"]) && !empty($_POST["kalnb"]) && !empty($_POST["kaldate"])) {
        // Les valeurs sont existantes et pas vides
        $kalnb = (is_numeric($_POST["kalnb"])) ? (int)$_POST["kalnb"] : 0;
        $_SESSION["error"] = [];
        include "includes/function.php";
        // Vérifier le format de la date
        if (!validateDate($_POST["kaldate"], 'Y-m-d')) {
            $_SESSION["error"][] = "Une erreur est survenue dans le format de la date";
        }
        // Vérifier le format du nombre de callorie
        if ($kalnb < 1 || $kalnb > 8000) {
            $_SESSION["error"][] = "Le nombre de calories est incorrect (doit être compris entre 1 et 8000)";
        }
        if ($_SESSION["error"] === []) {
            $date = $_POST["kaldate"];
            $today = new DateTime();
            $dateTest = new DateTime($date);
            if ($today < $dateTest) {
                $_SESSION["error"] = ["La date ne correspond pas (la date doit être aujourd'hui ou dans les 10 derniers jours)"];
            }
            $today->modify('-10 day');
            if ($dateTest < $today) {
                $_SESSION["error"] = ["La date ne correspond pas (la date doit être aujourd'hui ou dans les 10 derniers jours)"];
            }
            if ($_SESSION["error"] === []) {
                require "includes/connect.php";
                $sql = "SELECT * FROM `calories` WHERE `date` = :datechoisie AND `id_membre` = :id";
                $query = $db->prepare($sql);
                $query->bindValue(":datechoisie", $date, PDO::PARAM_STR);
                $query->bindValue(":id", $_SESSION["user"]["id"], PDO::PARAM_STR);
                $query->execute();
                $data = $query->fetchAll();
                // Si la date existe déjà : update la donnée
                if (!empty($data)) {
                    $sql = "UPDATE `calories` SET `calorie` = :kalnb WHERE `date`= :datechoisie";
                    $query = $db->prepare($sql);
                    $query->bindValue(":kalnb", $data[0]["calorie"] + $_POST["kalnb"], PDO::PARAM_STR);
                    $query->bindValue(":datechoisie", $date, PDO::PARAM_STR);
                    $query->execute();
                    $_SESSION["validinsertcalorie"] = ["Vos données ont bien été sauvegardé !"];
                    header("Location: index.php");
                } else {
                    // Sinon insérer une nouvelle entrée
                    $sql = "INSERT INTO `calories`(`date`, `calorie`, `id_membre`) VALUES (:kaldate, :kalnb, :idmember)";
                    $query = $db->prepare($sql);
                    $query->bindValue(":kaldate", $_POST["kaldate"], PDO::PARAM_STR);
                    $query->bindValue(":kalnb", $_POST["kalnb"], PDO::PARAM_STR);
                    $query->bindValue(":idmember", $_SESSION["user"]["id"], PDO::PARAM_STR);
                    $query->execute();
                    $_SESSION["validinsertcalorie"] = ["Vos données ont bien été sauvegardé !"];
                    header("Location: index.php");
                }
            } else {
                header("Location: index.php");
            }
        } else {
            header("Location: index.php");
        }
    } else {
        $_SESSION["error"] = ["Formulaire invalide"];
        header("Location: index.php");
    }
}
?>