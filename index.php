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

$title = "Accueil";
// HTML
require_once "includes/header.php";
require_once "includes/nav.php"; ?>
<div class="container-index">
    <div class="container-index-title">
        <h2><?= "$imc" ?></h2>
        <h3><?= "$imcdata" ?></h3>
    </div>
    <?php
    require_once "includes/errorResp.php";
    require_once "includes/validResp.php";
    ?>
</div>

<h2>Profil de <?= "$name $lastname" ?></h2>

<div>
    <?php
    require_once "includes/graph.php";
    ?>
    <div id="chartContainer" style="height: 370px; width: 50%;"></div>
</div>


<?php include_once "includes/modal.php"; ?>


<script src="script/main.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<?php
require_once "includes/footer.php";
?>