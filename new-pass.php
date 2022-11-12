<?php
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: connexion.php");
        exit;
    }
    if(!empty($_POST)){
        if(isset($_POST["oldpswd"], $_POST["newpswd1"], $_POST["newpswd2"]) && !empty($_POST["oldpswd"]) && !empty($_POST["newpswd1"]) && !empty($_POST["newpswd2"])) {
            $_SESSION["error"] = [];
            require_once "includes/connect.php";
            $sql = "SELECT * FROM `membres` WHERE `id` = :id";
            $query = $db->prepare($sql);
            $query->bindValue(":id", $_SESSION["user"]["id"], PDO::PARAM_STR);
            $query->execute();
            $user = $query->fetch();
            if(!$user) {
                $_SESSION["error"][] = "Un problème est survenue";
            }
            if(!password_verify($_POST["oldpswd"], $user["pass"])) {
                $_SESSION["error"][] = "L'ancien mot de passe ne correspond pas";
            }
            if($_POST["newpswd1"]!==$_POST["newpswd2"]) {
                $_SESSION["error"][] = "Les mots de passes ne sont pas identiques";
            }
            if(strlen($_POST["newpswd1"]) < 6 ) {
                $_SESSION["error"][] = "Mot de passe de 6 caractères requis";
            }
            if($_SESSION["error"] === []) {
                // Les mots de passes font plus de 5 caractères et sont identiques
                $pass = password_hash($_POST["newpswd1"], PASSWORD_ARGON2ID);
                $sql = "UPDATE `membres` SET `pass`= '$pass' WHERE `id`= :idmembre";
                $query = $db->prepare($sql);
                $query->bindValue(":idmembre", $_SESSION["user"]["id"], PDO::PARAM_STR);
                $query->execute();
                $_SESSION["validinsertcalorie"] = ["Vos données ont bien été sauvegardé !"];
                header("Location: index.php");
            } else {
                header("Location: index.php");
            }
        } else {
            $_SESSION["error"] = ["Formulaire invalide"];
            header("Location: index.php");
        }
    }
