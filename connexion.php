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
            $_SESSION["error"][] = "Adresse email ou mot de passe incorrect";
        }
        if ($_SESSION["error"] === []) {
            if (!isset($_SESSION["force"])) {
                $_SESSION["force"] = 1;
            } else {
                $_SESSION["force"]++;
            }
            if($_SESSION["force"] > 10) {
                $_SESSION["error"] = ["Trop de tentatives de connexions échoués"];
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
                elseif(!password_verify($_POST["pass"], $user["pass"])) {
                    $_SESSION["error"][] = "Utilisateur ou mot de passe incorrect";
                }
                
                if ($_SESSION["error"] === []) {
                    unset($_SESSION["force"]);
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
}

$title = "Connexion";
require_once "includes/header.php";
?>
<div class="start-container">
<div class="container-logo-start">
        <img src="img/Logo calorie.svg" alt="Logo">
        <h1 class="title">Track Calorie</h1>
    </div>
</div>
<div class="container container-connexion">
<div class="container-login">
    <div class="container-logo">
        <img src="img/Logo calorie.svg" alt="Logo">
        <h1 class="title">Track Calorie</h1>
    </div>
    
        <div class="container-form">
            <div class="form">
                <form action="" method="POST">
                    <div class="input-container">
                        <i class="fa fa-user icon-inscription"></i>
                        <input type="email" name="email" id="email" class="input-field-inscription" placeholder="Adresse de messagerie" required>
                    </div>
                    <div class="input-container">
                        <i class="fa-sharp fa-solid fa-lock icon-inscription"></i>
                        <input type="password" name="pass" id="pass" class="input-field-inscription" placeholder="Mot de passe" required>
                    </div>
                    <?php
                    if(isset($_SESSION["error"])) {
                ?>
                            <p class="log-error"><?= $_SESSION["error"][0] ?></p>
                <?php
                    }
                        unset($_SESSION["error"]);
                ?>
                    <button type="submit" class="btn-confirm">Me connecter <i class="fa-solid fa-arrow-right"></i></button>
                </form>
            </div>
            
        </div>
    </div>
    <div class="container-link container-link-inscription">
        <div class="lineconnexion"></div>
        <div class="lastlineconnexion">
            <a href="mdpoublie.php">Mot de passe oublié</a>
            <a href="inscription.php">Créer un compte</a>
        </div>      
        </div>
    </div>
<script src="script/connect.js"></script>
<?php
require_once "includes/footer.php";
?>