<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

if (!empty($_POST)) {
    if (isset($_POST["email"], $_POST["pass"]) && !empty($_POST["email"]) && !empty($_POST["pass"])) {
        $_SESSION["error"] = [];
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["error"][] = "Adresse email invalide";
        }

        if ($_SESSION["error"] === []) {
            require "includes/connect.php";
            $sql = "SELECT * FROM `membres` WHERE `email` = :email";
            $query = $db->prepare($sql);
            $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
            $query->execute();

            $user = $query->fetch();

            if (!$user) {
                $_SESSION["error"][] = "Utilisateur ou mot de passe incorrect";
            }

            if (!password_verify($_POST["pass"], $user["pass"])) {
                $_SESSION["error"][] = "Utilisateur ou mot de passe incorrect";
            }

            if ($_SESSION["error"] === []) {
                $_SESSION["user"] = [
                    "id" => $user["id"],
                    "name" => $user["prenom"],
                    "lastname" => $user["nom"],
                    "email" => $_POST["email"],
                    "height" => $user["taille"],
                    "weight" => $user["poids"],
                    "sex" => $user["sexe"]
                ];
                header("Location: index.php");
            }
        }
    }
}

$title = "Connexion";
require_once "includes/header.php";
?>
<div class="container">
<div class="container-index">
    <div class="container-logo">
        <img src="img/Logo calorie.svg" alt="Logo">
        <h1 class="title">Track Calorie</h1>
    </div>
    
        <div class="container-form">
            <div class="form">
                <form action="" method="POST">
                    <div class="input-container">
                        <i class="fa fa-user icon"></i>
                        <input type="email" name="email" id="email" class="input-field" placeholder="Adresse de messagerie" required>
                    </div>
                    <div class="input-container">
                        <i class="fa-sharp fa-solid fa-lock icon"></i>
                        <input type="password" name="pass" id="pass" class="input-field" placeholder="Mot de passe" required>
                    </div>
                    <button type="submit" class="btn-confirm">Me connecter</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container-link">
        <div></div>
        <div>
            <a href="#">Mot de passe oublié</a>
            <a href="inscription.php">Créer un compte</a>
        </div>
    </div>
</div>


<?php
require_once "includes/footer.php";
?>