<?php
// session_start();
// echo "<pre>";
// var_dump($_SESSION);
// echo "</pre>";
// echo "<pre>";
// var_dump($_POST);
// echo "</pre>";
if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

if (!empty($_POST)) {
    // Si les valeurs existent et ne sont pas vides
    if (isset($_POST["lastname"], $_POST["name"], $_POST["email"], $_POST["pass"], $_POST["confirmpass"], $_POST["height"], $_POST["weight"], $_POST["sex"]) && !empty($_POST["lastname"]) && !empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["pass"]) && !empty($_POST["confirmpass"]) && !empty($_POST["height"]) && !empty($_POST["weight"]) && !empty($_POST["sex"])) {

        $_SESSION["error"] = [];
        $name = strip_tags($_POST["name"]);
        $lastname = strip_tags($_POST["lastname"]);
        $height = strip_tags($_POST["height"]);
        $height = (is_numeric($height)) ? (int)$height : 0; // Fais passer en integer 
        $weight = strip_tags($_POST["weight"]);
        $weight = (is_numeric($weight)) ? (int)$weight : 0;

        // Prénom strictement inférieur à 2 caractères
        if (strlen($name) < 2) {
            $_SESSION["error"][] = "Le prénom est trop court";
        }

        // Nom strictement inférieur à 2 caractère
        if (strlen($lastname) < 2) {
            $_SESSION["error"][] = "Le nom est trop court";
        }

        // PassWord strictement inférieur à 6 caractères
        if (strlen($_POST["pass"] < 6)) {
            $_SESSION["error"][] = "Le mot de passe est trop court";
        }

        // Mot de passe différents
        if ($_POST["pass"] !== $_POST["confirmpass"]) {
            $_SESSION["error"][] = "Les mots de passes saisis ne sont pas identiques";
        }

        // Filtrage de l'email
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["error"][] = "L'adresse email est incorrecte";
        }

        // Vérifier si le genre est bon
        if ($_POST["sex"] !== "women" && $_POST["sex"] !== "man") {
            $_SESSION["error"][] = "Sélectionner un genre";
        }

        if ($height < 100 || $height > 220) {
            $_SESSION["error"][] = "Erreur lors de la saisie de la taille, la taille doit être comprise entre 100cm et 220cm";
        }

        if ($weight < 30 || $weight > 200) {
            $_SESSION["error"][] = "Erreur lors de la saisie du poids, le poids doit être compris entre 30 et 200kg";
        }

        // Si pas d'erreur -> on avance
        if ($_SESSION["error"] === []) {

            // Hasher le pass
            $pass = password_hash($_POST["pass"], PASSWORD_ARGON2ID);
            // Se connecter à la base de données
            require_once "includes/connect.php";
            // email unique
            $sql = "SELECT * FROM `membres` WHERE email = ?";
            $query = $db->prepare($sql);
            $query->bindValue(1, $_POST["email"], PDO::PARAM_STR);
            $query->execute();
            $verifmail = $query->fetch();
            if ($verifmail) {
                $_SESSION["error"] = ["L'email est déjà utilisé"];
            }

            if ($_SESSION["error"] === []) {


                $sql = "INSERT INTO `membres` (`nom`, `prenom`, `email`, `pass`, `taille`, `poids`, `sexe`, `role`) VALUES (:nom, :prenom, :email, '$pass', :taille, :poids, :sexe, '[\"ROLE_USER\"]')";

                $query = $db->prepare($sql);
                $query->bindValue(":nom", $lastname, PDO::PARAM_STR);
                $query->bindValue(":prenom", $name, PDO::PARAM_STR);
                $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
                $query->bindValue(":taille", $_POST["height"], PDO::PARAM_STR);
                $query->bindValue(":poids", $_POST["weight"], PDO::PARAM_STR);
                $query->bindValue(":sexe", $_POST["sex"], PDO::PARAM_STR);

                $query->execute();
                $id = $db->lastInsertId();

                $_SESSION["user"] = [
                    "id" => $id,
                    "name" => $name,
                    "lastname" => $lastname,
                    "email" => $_POST["email"],
                    "height" => $_POST["height"],
                    "weight" => $_POST["weight"],
                    "sex" => $_POST["sex"]
                ];
                header("Location: index.php");
            }
        }
    } else {
        $_SESSION["error"] = ["Des valeurs sont manquantes"];
    }
}
?>
<?php
$title = "Inscription";
require_once "includes/header.php";
?>
<h1 class="text-center"> Track Calorie </h1>
<?php
    if(isset($_SESSION["error"])) {
        foreach($_SESSION["error"] as $message) {
?>
            <p><?= $message ?></p>
<?php
    }
        unset($_SESSION["error"]);
    }
?>
<form action="" method="POST">
    <div>
        <input type="text" name="lastname" id="lastname" placeholder="Nom" required>
    </div>
    <div>
        <input type="text" name="name" id="name" placeholder="Prénom" required>
    </div>
    <div>
        <input type="email" name="email" id="email" placeholder="Email" required>
    </div>
    <div>
        <input type="password" name="pass" id="pass" placeholder="Mot de passe" required>
    </div>
    <div>
        <input type="password" name="confirmpass" id="confirmpass" placeholder="Confirmation" required>
    </div>
    <div>
        <input type="number" name="height" id="height" placeholder="Taille (cm)" min="100" max="220" required>
    </div>
    <div>
        <input type="number" name="weight" id="weight" placeholder="Poids (kg)" min="30" max="200" required>
    </div>
    <div>
        <input type="radio" class="btn-check" name="sex" id="option1" autocomplete="off" value="man" checked>
        <label class="btn btn-light" for="option1">Homme</label>

        <input type="radio" class="btn-check" name="sex" id="option2" autocomplete="off" value="women">
        <label class="btn btn-light" for="option2">Femme</label>
    </div>
    <button type="submit" class="btn btn-light mt-2">Créer un compte</button>
</form>

<?php
require_once "includes/footer.php";
?>