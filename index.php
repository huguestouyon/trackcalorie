<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: connexion.php");
    exit;
}
//timeoutlogout();
if (isset($_SESSION["LAST_ACTIVITY"]) && time() - $_SESSION["LAST_ACTIVITY"] > 3600) {
    header("Location: deconnexion.php");
}
$_SESSION["LAST_ACTIVITY"] = time();
$name = $_SESSION['user']['name'];
$lastname = $_SESSION['user']['lastname'];
$email = $_SESSION['user']['email'];
$weight = $_SESSION['user']['weight'];
$size = $_SESSION['user']['height'];
$sexe = $_SESSION['user']['sex'];
// $member = $_SESSION['user']['role'];
if ($sexe === "man"){
    $sexe = "Homme";
}
if ($sexe === "women"){
    $sexe = "Femme";
}
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
?>
<div class="start-container">
<div class="container-logo-start container-logo-start-index">
        <img src="img/Logo calorie.svg" alt="Logo">
        <h1 class="title">Track Calorie</h1>
    </div>
</div>    
<?php require_once "includes/nav.php"; ?>
<div class="container-index">
    <?php
    require_once "includes/errorResp.php";
    require_once "includes/validResp.php";
    ?>
    <div class="container-profil">
<h3 class="titre-profil">Profil de <?= "$name $lastname" ?><br> <p><i class="fa-solid fa-arrow-down icono"></i></p></h3>
<div class="container-zidane">
<button class="profil-button"><img class="identity-card" src="../../trackcalorie/img/identity.svg" alt="identity" srcset=""></button>
<div class="menu-profil">
    <ul class="p-profil">
<li> Nom : <?="$lastname" ?> </li>
<li>Prénom : <?= "$name" ?> </li>
<li>Email : <?="$email"?></li>
<li>Poid : <?="$weight"?> </li> 
<li>Taille : <?="$size"?></li>
<li>Sexe : <?="$sexe"?> </li>
</ul>
<p class="badge rounded-pill bg-warning mt-1 text-dark">Utilisateur</p>
</div>
</div>
</div>
    <div class="container-index-title">
        <h2 class="title-imc"><?= "$imc" ?></h2>
        <p class="absolute-IMC">IMC</p>
        <h3 class="title-imc-text"><?= "$imcdata" ?></h3>
    </div>
</div>

<div class="container-graphic">
    <?php include_once "includes/graphic.php" ?>
</div>

<?php require_once "includes/graphic.php"; ?>
<?php include_once "includes/modal.php"; ?>
<div class="space-after-graph"></div>
<script src="../../trackcalorie/script/chartcalorie.js"></script>
<script src="script/main.js"></script>
<?php
require_once "includes/footer.php";
?>