<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

session_start();
if (isset($_SESSION["user"])) {
header("Location: index.php");
exit;
}

if (!empty($_POST)) {
// Vérif si tout est bien rempli
if (isset($_POST["email"]) && !empty($_POST["email"])) {
$_SESSION["error"] = [];
// Vérif l'email
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
$_SESSION["error"] = ["L'adresse email est incorrecte"];
}
if ($_SESSION["error"] === []) {
require_once "includes/connect.php";
$sql = "SELECT email FROM `membres` WHERE `email` = ?";
$query = $db->prepare($sql);
$query->bindValue(1, $_POST["email"], PDO::PARAM_STR);
$query->execute();
$user = $query->fetch();
if (!empty($user)) {
// création du mot de passe :
$comb = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
$pass = array();
$combLen = strlen($comb) - 1;
for ($i = 0; $i < 10; $i++) {
$n = rand(0, $combLen);
$pass[] = $comb[$n];
}
$pswd = implode($pass);
$to = $_POST["email"];
$subject = "Sujet du message";
$message = "Mon message";
$message = wordwrap($message, 70, "\r\n");
$headers = [
"From" => $to,
"Reply-To" => "contact@huguestouyon.com"
];
mail($to, $subject, $message, $headers);
// require_once "includes/phpmailler/Exception.php";
// require_once "includes/phpmailler/PHPMailer.php";
// require_once "includes/phpmailler/SMTP.php";

// $mail = new PHPMailer(true);

// try{
// // Configuration
// $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Informations de debug
// // On configure le SMTP
// $mail->isSMTP("smtp.ionos.fr");
// $mail->Host = "imap.ionos.fr";
// $mail->Port = 1025;

// // Charset
// $mail->CharSet = "UTF-8";

// // Destinataires
// $mail->addAddress($to);
// // Expéditeurs
// $mail->setFrom("imap.ionos.fr");

// // Contenu
// $mail->Subject = "Votre nouveau mot de passe est le suivant (changer le) : $pswd";

// }catch(Exception){
// echo "Message non envoyé. Erreur: {$mail->ErrorInfo}";
// }

} else {
$_SESSION["error"] = ["Données invalides ! 🔐"];
}
}
} else {
$_SESSION["error"] = ["Données invalides ! 🔐"];
}
}

$title = "Mdpoublie";
require_once "includes/header.php";
?>

<div class="container container-connexion container-mdpoublie">
<div class="container-login">
<div class="container-logo">
<img src="img/Logo calorie.svg" alt="Logo">
<h1 class="title">Track Calorie</h1>
</div>

<div class="container-form">
<div class="form">
<p class="pmdpoublie">Entrez votre email pour pouvoir <br> modifer votre mot de passe.</p>
<br>
<form action="" method="POST">
<div class="input-container">
<i class="fa-solid fa-envelope icon-inscription"></i>
<input type="email" name="email" id="email" class="input-field-inscription" placeholder="Adresse de messagerie" required>
</div>
<?php
require_once "includes/errorResp.php";
require_once "includes/validResp.php";
?>
<button type="submit" class="btn btn-light mt-2 confirmer confirmer-mdpoublie">Confirmer<i class="fa-solid fa-arrow-right iconx iconmdpoublie"></i></button>
</form>
</div>
</div>
</div>
<div class="container-link container-link-mdpoublie">
<div class="lineconnexion"></div>
<div class="lastlineconnexion lastlinemdpoublie">
<a href="connexion.php">Se connecter</a>
</div>
</div>
</div>
<?php
require_once "includes/footer.php";
?>