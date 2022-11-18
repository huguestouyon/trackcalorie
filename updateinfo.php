<?php
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: connexion.php");
        exit;
    }

    echo "<pre>";
    var_dump($_SESSION);
    echo "</pre>";
    if(isset($_POST["prenom"], $_POST["nom"], $_POST["height"], $_POST["weight"]) && !empty($_POST["prenom"]) && !empty($_POST["nom"]) && !empty($_POST["height"]) && !empty($_POST["weight"])) {
        $_SESSION["error"] = [];
        $lastname = strip_tags($_POST["nom"]);
        $name = strip_tags($_POST["prenom"]);
        $height = strip_tags($_POST["height"]);
        $height = (is_numeric($height)) ? (int)$height : 0; // Fais passer en integer 
        $weight = strip_tags($_POST["weight"]);
        $weight = (is_numeric($weight)) ? (int)$weight : 0;
        $sporthebdo = strip_tags($_POST["sporthebdo"]);
        $sporthebdo = (is_numeric($sporthebdo)) ? (int)$sporthebdo : 0;
        if(strlen($name) < 2) {
            $_SESSION["error"][] = "Le prénom doit conteir plus d'un caractère.";
        }
        if(strlen($lastname) < 2) {
            $_SESSION["error"][] = "Le nom doit contenir plus d'un caractère.";
        }
        if ($height < 100 || $height > 220) {
            $_SESSION["error"][] = "Erreur lors de la saisie de la taille, la taille doit être comprise entre 100cm et 220cm.";
        }
        if ($weight < 30 || $weight > 200) {
            $_SESSION["error"][] = "Erreur lors de la saisie du poids, le poids doit être compris entre 30 et 200kg.";
        }
        // Ici les données de bases sont bonnes
        require_once "includes/function.php";
        if(!validateDate($_POST["birthday"], 'Y-m-d')){
            $_SESSION["error"][] = "Erreur lors de la saisie de la date.";
        }
        if($sporthebdo < 0 && $sporthebdo > 40) {
            $_SESSION["error"][] = "Erreur lors de la saisie du nombre d'heure par semaine.";
        }
        if(!empty($_POST["phonetel"]) && !preg_match("#[0][6][- \.?]?([0-9][0-9][- \.?]?){4}$#", $_POST["phonetel"])){  
            $_SESSION["error"][] = "Erreur lors de la saisie du numéro de téléphone.";
        }
        // Ici toutes les données sont "utlisables"
        if($_SESSION["error"] === []) {
            if(!empty($_POST["birthday"]) && isset($_POST["birthday"]) && $_POST["birthday"]!=="1990-01-01") {
                $birthday = $_POST["birthday"];
            }
            if(!empty($_POST["phonetel"]) && preg_match("#[0][6][- \.?]?([0-9][0-9][- \.?]?){4}$#", $_POST["phonetel"])){  
                $tel = $_POST["phonetel"];
            }
            require "includes/connect.php";
            if(isset($birthday, $tel)){
                $sql = "UPDATE `membres` SET `nom` = :nom, `prenom` = :prenom, `taille` = :taille, `poids` = :poids, `tel` = :tel, `sport` = :sport, `anniv` = :anniv WHERE id = :id";
                $query = $db->prepare($sql);
                $query->bindValue(":nom", $lastname, PDO::PARAM_STR);
                $query->bindValue(":prenom", $name, PDO::PARAM_STR);
                $query->bindValue(":taille", $height, PDO::PARAM_STR);
                $query->bindValue(":poids", $weight, PDO::PARAM_STR);
                $query->bindValue(":tel", $tel, PDO::PARAM_STR);
                $query->bindValue(":sport", $sporthebdo, PDO::PARAM_STR);
                $query->bindValue(":anniv", $birthday, PDO::PARAM_STR);
                $query->bindValue(":id", $_SESSION["user"]["id"], PDO::PARAM_STR);
                $query->execute();
                $_SESSION["validinsertcalorie"] = ["Vos informations ont bien été validé ! 🥳"];
                // $_SESSION["user"] = [
                //     "id" => $_SESSION["user"]["id"],
                //     "name" => $name,
                //     "lastname" => $lastname,
                //     "email" => $_SESSION["user"]["email"],
                //     "height" => $height,
                //     "weight" => $weight,
                //     "sex" => $_SESSION["user"]["sex"],
                //     "tel" => $tel,
                //     "sport" => $sporthebdo,
                //     "anniv" => $birthday
                // ];
            }
            if(isset($birthday) && !isset($tel)) {
                $sql = "UPDATE `membres` SET `nom` = :nom, `prenom` = :prenom, `taille` = :taille, `poids` = :poids, `sport` = :sport, `anniv`= :anniv WHERE id = :id";
                $query = $db->prepare($sql);
                $query->bindValue(":nom", $lastname, PDO::PARAM_STR);
                $query->bindValue(":prenom", $name, PDO::PARAM_STR);
                $query->bindValue(":taille", $height, PDO::PARAM_STR);
                $query->bindValue(":poids", $weight, PDO::PARAM_STR);
                $query->bindValue(":sport", $sporthebdo, PDO::PARAM_STR);
                $query->bindValue(":anniv", $birthday, PDO::PARAM_STR);
                $query->bindValue(":id", $_SESSION["user"]["id"], PDO::PARAM_STR);
                $query->execute();
                $_SESSION["validinsertcalorie"] = ["Vos informations ont bien été validé ! 🥳"];
                // $_SESSION["user"] = [
                //     "id" => $_SESSION["user"]["id"],
                //     "name" => $name,
                //     "lastname" => $lastname,
                //     "email" => $_SESSION["user"]["email"],
                //     "height" => $height,
                //     "weight" => $weight,
                //     "sex" => $_SESSION["user"]["sex"],
                //     "tel" => $tel,
                //     "sport" => $sporthebdo,
                //     "anniv" => $birthday
                // ];
            }
            if(!isset($birthday) && isset($tel)) {
                $sql = "UPDATE `membres` SET `nom` = :nom, `prenom` = :prenom, `taille` = :taille, `poids` = :poids, `tel` = :tel,`sport` = :sport WHERE id = :id";
                $query = $db->prepare($sql);
                $query->bindValue(":nom", $lastname, PDO::PARAM_STR);
                $query->bindValue(":prenom", $name, PDO::PARAM_STR);
                $query->bindValue(":taille", $height, PDO::PARAM_STR);
                $query->bindValue(":poids", $weight, PDO::PARAM_STR);
                $query->bindValue(":tel", $tel, PDO::PARAM_STR);
                $query->bindValue(":sport", $sporthebdo, PDO::PARAM_STR);
                $query->bindValue(":id", $_SESSION["user"]["id"], PDO::PARAM_STR);
                $query->execute();
                $_SESSION["validinsertcalorie"] = ["Vos informations ont bien été validé ! 🥳"];
                
            }
            if(!isset($birthday) && !isset($tel)) {
                $sql = "UPDATE `membres` SET `nom` = :nom, `prenom` = :prenom, `taille` = :taille, `poids` = :poids, `sport` = :sport WHERE id = :id";
                $query = $db->prepare($sql);
                $query->bindValue(":nom", $lastname, PDO::PARAM_STR);
                $query->bindValue(":prenom", $name, PDO::PARAM_STR);
                $query->bindValue(":taille", $height, PDO::PARAM_STR);
                $query->bindValue(":poids", $weight, PDO::PARAM_STR);
                $query->bindValue(":sport", $sporthebdo, PDO::PARAM_STR);
                $query->bindValue(":id", $_SESSION["user"]["id"], PDO::PARAM_STR);
                $query->execute();
                $_SESSION["validinsertcalorie"] = ["Vos informations ont bien été validé ! 🥳"];
                
            }
            $_SESSION["user"] = [
                "id" => $_SESSION["user"]["id"],
                "name" => $name,
                "lastname" => $lastname,
                "email" => $_SESSION["user"]["email"],
                "height" => $height,
                "weight" => $weight,
                "sex" => $_SESSION["user"]["sex"],
                "tel" => $tel,
                "sport" => $sporthebdo,
                "anniv" => $birthday
            ];
            header("Location: index.php");

        } else {
            header("Location: index.php");
        }
        // echo $birthday;

    } else {
        $_SESSION["error"] = ["Une erreur est survenue."];
        header("Location: index.php");
    }
?>