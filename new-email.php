<?php
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: connexion.php");
        exit;
    }
    if(!empty($_POST)){
        if(isset($_POST["oldemail"], $_POST["newemail1"], $_POST["newemail2"], $_POST["pswd"]) && !empty($_POST["oldemail"]) && !empty($_POST["newemail1"]) && !empty($_POST["newemail2"]) && !empty($_POST["pswd"])) {
            $_SESSION["error"] = [];
            require_once "includes/connect.php";
            if (!filter_var($_POST["oldemail"], FILTER_VALIDATE_EMAIL)) {
                $_SESSION["error"][] = "Adresse email ou mot de passe incorrect";
            }
            if (!filter_var($_POST["newemail1"], FILTER_VALIDATE_EMAIL)) {
                $_SESSION["error"][] = "Adresse email ou mot de passe incorrect";
            }
            if (!filter_var($_POST["newemail2"], FILTER_VALIDATE_EMAIL)) {
                $_SESSION["error"][] = "Adresse email ou mot de passe incorrect";
            }
            if($_POST["newemail1"]!==$_POST["newemail2"]) {
                $_SESSION["error"][] = "Les emails ne sont pas identiques";
            }
            if($_SESSION["error"] === []) {
                $sql = "SELECT * FROM `membres` WHERE `id` = :id AND `email` = :oldemail";
                $query = $db->prepare($sql);
                $query->bindValue(":id", $_SESSION["user"]["id"], PDO::PARAM_STR);
                $query->bindValue(":oldemail", $_POST["oldemail"], PDO::PARAM_STR);
                $query->execute();
                $user = $query->fetch();
                if(!$user) {
                    $_SESSION["error"][] = "Un problème est survenue";
                }
                if(!password_verify($_POST["pswd"], $user["pass"])) {
                    $_SESSION["error"][] = "L'adresse email ou le passe est incorrect";
                }
                $sql = "SELECT * FROM `membres` WHERE `email` = :mail";
                $query = $db->prepare($sql);
                $query->bindValue(":mail", $_POST["newemail1"], PDO::PARAM_STR);
                $query->execute();
                $user = $query->fetch();
                if($user) {
                    $_SESSION["error"][] = "Nouvelle adresse email déjà utilisé";
                }
                if($_SESSION["error"] === []) {
                    $sql = "UPDATE `membres` SET `email`= :newemail WHERE `id`=:idmembre";
                    $query = $db->prepare($sql);
                    $query->bindValue(":newemail", $_POST["newemail1"], PDO::PARAM_STR);
                    $query->bindValue(":idmembre", $_SESSION["user"]["id"], PDO::PARAM_STR);
                    $query->execute();
                    $_SESSION["validinsertcalorie"] = ["Vos données ont bien été sauvegardé !"];
                    header("Location: index.php");
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
