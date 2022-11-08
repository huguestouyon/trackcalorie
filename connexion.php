<?php
session_start();
if(isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

if(!empty($_POST)) {
    if(isset($_POST["email"], $_POST["pass"]) && !empty($_POST["email"]) && !empty($_POST["pass"])) {
        $_SESSION["error"] = [];
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["error"][] = "Adresse email invalide";
        }

        if($_SESSION["error"] === []) {
            require_once "includes/connect.php";
            $sql = "SELECT * FROM `membres` WHERE `email` = :email";
            $query = $db->prepare($sql);
            $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
            $query->execute();

            $user = $query->fetch();

            if(!$user) {
                $_SESSION["error"][] = "Utilisateur ou mot de passe incorrect";
            }

            if(!password_verify($_POST["pass"], $user["pass"])) {
                $_SESSION["error"][] = "Utilisateur ou mot de passe incorrect";
            }

            if($_SESSION["error"]=== []) {
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
<form action="" method="POST">
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div>
        <label for="pass">Mot de passe</label>
        <input type="password" name="pass" id="pass" required>
    </div>
    <button type="submit">Me connecter</button>
</form>
<?php
require_once "includes/footer.php";
?>