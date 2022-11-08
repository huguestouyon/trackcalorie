
<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: connexion.php");
    exit;
}
require_once "includes/header.php";
$name = $_SESSION['user']['name'];
$lastname = $_SESSION['user']['lastname']
?>

<h1 class="text-center">TrackCalorie</h1>
<h2>Profil de <?= "$name $lastname" ?></h2>

<a href="deconnexion.php" class="btn btn-light">Déconnexion</a>
<?php
require_once "includes/footer.php";
?>