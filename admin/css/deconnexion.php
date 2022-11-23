<?php
session_start();
if(!isset($_SESSION["user"]) && !empty($_SESSION["admin"])) {
    header("Location: connexion.php");
    exit;
}
unset($_SESSION["user"]);
unset($_SESSION["admin"]);
header("Location: connexion.php");
?>