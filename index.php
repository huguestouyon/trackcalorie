<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: connexion.php");
    exit;
}

$name = $_SESSION['user']['name'];
$lastname = $_SESSION['user']['lastname'];


// Calcul IMC :
$height = $_SESSION["user"]["height"];
$height = $height * 0.01; // Passer la taille de cm à m
$weight = $_SESSION["user"]["weight"];

//IMC
$imc = round($weight / ($height * $height), 1); // Calcul de l'IMC adulte arrondit à 1 chiffre après la virgule
if ($imc <= 18.5) {
    $imcdata = "Maigreur";
} elseif ($imc > 18.5 && $imc <= 25) {
    $imcdata = "Corpulence normale";
} elseif ($imc > 25 && $imc <= 30) {
    $imcdata = "Surpoids";
} elseif ($imc > 30 && $imc <= 35) {
    $imcdata = "Obésité modérée (Classe 1)";
} elseif ($imc > 35 && $imc <= 40) {
    $imcdata = "Obésité élevé (Classe 2)";
} elseif ($imc > 40) {
    $imcdata = "Obésite morbide ou massive";
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
                } else {
                    // Sinon insérer une nouvelle entrée
                    $sql = "INSERT INTO `calories`(`date`, `calorie`, `id_membre`) VALUES (:kaldate, :kalnb, :idmember)";
                    $query = $db->prepare($sql);
                    $query->bindValue(":kaldate", $_POST["kaldate"], PDO::PARAM_STR);
                    $query->bindValue(":kalnb", $_POST["kalnb"], PDO::PARAM_STR);
                    $query->bindValue(":idmember", $_SESSION["user"]["id"], PDO::PARAM_STR);
                    $query->execute();
                    $_SESSION["validinsertcalorie"] = ["Vos données ont bien été sauvegardé !"];
                }
            }
        }
    } else {
        $_SESSION["error"] = ["Formulaire invalide"];
    }
}

// HTML
require_once "includes/header.php";
require_once "includes/nav.php"; ?>
<div class="container-index">
    <div class="container-index-title">
        <h2><?= "$imc" ?></h2>
        <h3><?= "$imcdata" ?></h3>
    </div>
    <?php
    if (isset($_SESSION["error"])) {
        foreach ($_SESSION["error"] as $mes) {
    ?>
            <div class="error"><?= $mes ?></div>
    <?php
        }
        unset($_SESSION["error"]);
    }
    ?>
    <?php
    if (isset($_SESSION["validinsertcalorie"])) {
        foreach ($_SESSION["validinsertcalorie"] as $message) {
    ?>
            <div class="valid"><?= $message ?></div>
    <?php
        }
        unset($_SESSION["validinsertcalorie"]);
    }
    ?>
</div>

<h2>Profil de <?= "$name $lastname" ?></h2>






<a href="deconnexion.php">Déconnexion</a>
<div>
    <?php
    require_once "includes/graph.php";
    ?>
    <div id="chartContainer" style="height: 370px; width: 50%;"></div>
</div>

<div id="modalkal" class="modal1">

    <!-- Modal content -->
    <div class="modal-content1">
        <div class="modal-header1">
            <span class="close">&times;</span>
            <h2>Ajouter des calories à une date précise</h2>
        </div>
        <div class="modal-body1">
            <form action="" method="post">
                <div>
                    <label for="kalnb">Entrer votre nombre de calories</label>
                    <input type="number" name="kalnb" id="kalnb" placeholder="Nombre de calories" min="0" max="8000" required>
                </div>
                <div>
                    <label for="kaldate">Entrer une date</label>
                    <input type="date" name="kaldate" id="kaldate" placeholder="Choisir une date" required>
                </div>
                <button type="submit">Ajouter</button>
            </form>
        </div>
        <div class="modal-footer1">
            <h3>Modal Footer</h3>
        </div>
    </div>
</div>


<script src="script/main.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<?php
require_once "includes/footer.php";
?>