<?php
session_start();
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
        if (strlen($_POST["pass"]) < 6) {
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
            $email= strtolower($_POST["email"]);
            $sql = "SELECT * FROM `membres` WHERE email = ?";
            $query = $db->prepare($sql);
            $query->bindValue(1, $email, PDO::PARAM_STR);
            $query->execute();
            $verifmail = $query->fetch();
            if ($verifmail) {
                $_SESSION["error"] = ["L'email est déjà utilisé"];
            }

            if ($_SESSION["error"] === []) {
                $sql = "INSERT INTO `membres` (`nom`, `prenom`, `email`, `pass`, `taille`, `poids`, `sexe`, `role`, `sport`) VALUES (:nom, :prenom, :email, '$pass', :taille, :poids, :sexe, '[\"ROLE_USER\"]', 0)";
                $query = $db->prepare($sql);
                $query->bindValue(":nom", $lastname, PDO::PARAM_STR);
                $query->bindValue(":prenom", $name, PDO::PARAM_STR);
                $query->bindValue(":email", $email, PDO::PARAM_STR);
                $query->bindValue(":taille", $_POST["height"], PDO::PARAM_STR);
                $query->bindValue(":poids", $_POST["weight"], PDO::PARAM_STR);
                $query->bindValue(":sexe", $_POST["sex"], PDO::PARAM_STR);

                $query->execute();
                $id = $db->lastInsertId();
                $_SESSION["user"] = [
                    "id" => $id,
                    "name" => $name,
                    "lastname" => $lastname,
                    "email" => $email,
                    "height" => $height,
                    "weight" => $weight,
                    "sex" => $_POST["sex"],
                    "tel" => null,
                    "sport" => 0,
                    "anniv" => null
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

<div class="container-inscription container">
    <div class="container-index-inscription">
        <div class="container-logo-inscription">
            <img src="img/Logo calorie.svg" alt="Logo" class="img-logo">
            <h1 class="title">Track Calorie</h1>
        </div>



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
<div class="form-inscription form-inscription2">
    <div class="form form-inscription">
        <form action="" method="POST">
            <div class="input-container">
                <i class="fa fa-user icon-inscription"></i>
                <input type="text" name="lastname" id="lastname" placeholder="Nom" class="input-field-inscription" required>
            </div>
            <div class="input-container">
                <i class="fa fa-user icon-inscription"></i>
                <input type="text" name="name" id="name" placeholder="Prénom" class="input-field-inscription" required>
            </div>
            <div class="input-container">
                <i class="fa-solid fa-envelope icon-inscription"></i>
                <input type="email" name="email" id="email" placeholder="Email" class="input-field-inscription" required>
            </div>
            <div class="input-container">
                <i class="fa-sharp fa-solid fa-lock icon-inscription"></i>  
                <input type="password" name="pass" id="pass" placeholder="Mot de passe" class="input-field-inscription" required>
            </div>
            <div class="input-container">
                <i class="fa-sharp fa-solid fa-lock icon-inscription"></i>    
                <input type="password" name="confirmpass" id="confirmpass" placeholder="Confirmation" class="input-field-inscription" required>
            </div>
            <div class="input-container">
                <i class="fa-solid fa-ruler icon-inscription"></i>
                <input type="number" name="height" id="height" placeholder="Taille (cm)" min="100" max="220" class="input-field-inscription" required>
            </div>
            <div class="input-container">
                <i class="fa-solid fa-weight-hanging icon-inscription"></i>
                <input type="number" name="weight" id="weight" placeholder="Poids (kg)" min="30" max="200" class="input-field-inscription" required>
            </div>
        <div class="radio-container">
            <input type="radio" class="btn-check" name="sex" id="option1" autocomplete="off" value="man" checked>
                <label class="btn btn-light labelradio labelradio-inscription labelr1" for="option1"><i class="fa-solid fa-mars icony"></i><br>Homme</label>
                    <div class="line"></div>
            <input type="radio" class="btn-check" name="sex" id="option2" autocomplete="off" value="women">
                <label class="btn btn-light labelradio labelradio-inscription labelr2" for="option2"><i class="fa-solid fa-venus icony"></i><br>Femme</label>
        </div>
        <br>
        <button type="submit" class="btn btn-light mt-2 confirmer confirmer-inscription">Confirmer<i class="fa-solid fa-arrow-right iconx"></i></button>
    </form>
</div>    
</div>
</div>
<div class="link2 container-link ">
    <div class="lineinscription"></div>
    <div class="linkinscription">
        <a href="connexion.php">Se connecter</a>
    </div>
</div>
</div>
<footer class="footer-instant">
    <a href="index.php">
        <svg width="258" height="265" viewBox="0 0 258 265" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g filter="url(#filter0_i_79_228)">
        <path d="M161.25 8.28125C161.25 23.7223 164.021 37.9557 169.564 50.9814C175.107 64.0072 183.086 75.9977 193.5 86.9531C203.914 97.9085 211.893 109.899 217.436 122.925C222.979 135.951 225.75 150.184 225.75 165.625C225.75 174.769 224.616 183.568 222.349 192.021C220.081 200.475 216.806 208.368 212.522 215.701C208.239 223.033 203.2 229.762 197.405 235.886C191.61 242.011 185.102 247.187 177.879 251.414C170.656 255.64 162.93 258.962 154.699 261.377C146.469 263.792 137.902 265 129 265C120.098 265 111.531 263.835 103.301 261.506C95.0703 259.177 87.3857 255.813 80.2471 251.414C73.1084 247.014 66.5576 241.838 60.5947 235.886C54.6318 229.934 49.5928 223.249 45.4775 215.83C41.3623 208.411 38.1289 200.475 35.7773 192.021C33.4258 183.568 32.25 174.769 32.25 165.625C32.25 158.379 33.0059 151.262 34.5176 144.275C36.0293 137.288 38.2129 130.602 41.0684 124.219C43.9238 117.835 47.4512 111.754 51.6504 105.974C55.8496 100.194 60.5947 94.9756 65.8857 90.3174C66.4736 93.5954 67.2715 96.9596 68.2793 100.41C69.2871 103.861 70.4629 107.311 71.8066 110.762C73.1504 114.212 74.7461 117.49 76.5938 120.596C78.4414 123.701 80.373 126.591 82.3887 129.265C84.0684 131.422 86.252 132.5 88.9395 132.5C91.207 132.5 93.0967 131.68 94.6084 130.042C96.1201 128.403 96.918 126.418 97.002 124.089C97.002 123.14 96.876 122.278 96.624 121.501C96.3721 120.725 95.9521 119.949 95.3643 119.172C93.0127 115.636 90.9551 112.142 89.1914 108.691C87.4277 105.241 85.874 101.704 84.5303 98.0811C83.1865 94.458 82.2207 90.7056 81.6328 86.8237C81.0449 82.9419 80.709 78.8444 80.625 74.5312C80.625 64.266 82.5146 54.6045 86.2939 45.5469C90.0732 36.4893 95.2803 28.5962 101.915 21.8677C108.55 15.1392 116.234 9.83398 124.969 5.95215C133.703 2.07031 143.109 0.086263 153.188 0H161.25V8.28125ZM129 248.438C140.17 248.438 150.626 246.281 160.368 241.968C170.11 237.655 178.677 231.746 186.067 224.241C193.458 216.736 199.211 207.98 203.326 197.974C207.441 187.967 209.541 177.184 209.625 165.625C209.625 152.599 207.273 140.479 202.57 129.265C197.867 118.051 191.064 107.872 182.162 98.728C171.244 87.4276 162.678 74.9626 156.463 61.333C150.248 47.7034 146.553 32.9525 145.377 17.0801C138.406 18.029 131.981 20.1855 126.103 23.5498C120.224 26.9141 115.059 31.1841 110.607 36.3599C106.156 41.5356 102.755 47.3584 100.403 53.8281C98.0518 60.2979 96.834 67.1989 96.75 74.5312C96.75 81.2598 97.7158 87.3413 99.6475 92.7759C101.579 98.2104 104.435 103.645 108.214 109.08C109.81 111.322 111.027 113.652 111.867 116.067C112.707 118.482 113.169 121.156 113.253 124.089C113.253 127.54 112.623 130.775 111.363 133.794C110.104 136.813 108.34 139.444 106.072 141.687C103.805 143.93 101.243 145.741 98.3877 147.122C95.5322 148.502 92.3828 149.149 88.9395 149.062C85.0762 149.062 81.6748 148.329 78.7354 146.863C75.7959 145.396 73.1924 143.412 70.9248 140.911C68.6572 138.409 66.6416 135.605 64.8779 132.5C63.1143 129.395 61.4346 126.289 59.8389 123.184C55.9756 129.481 53.1201 136.252 51.2725 143.499C49.4248 150.745 48.459 158.12 48.375 165.625C48.375 177.098 50.4746 187.838 54.6738 197.844C58.873 207.851 64.626 216.65 71.9326 224.241C79.2393 231.832 87.7637 237.741 97.5059 241.968C107.248 246.195 117.746 248.351 129 248.438Z" fill="#FFC700"/>
        </g>
        <defs>
        <filter id="filter0_i_79_228" x="0" y="0" width="258" height="269" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
        <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
        <feOffset dy="4"/>
        <feGaussianBlur stdDeviation="2"/>
        <feComposite in2="hardAlpha" operator="arithmetic" k2="-1" k3="1"/>
        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
        <feBlend mode="normal" in2="shape" result="effect1_innerShadow_79_228"/>
        </filter>
        </defs>
        </svg>
    </a>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>