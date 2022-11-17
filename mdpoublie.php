<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

if (!empty($_POST)) {
    if(isset($_POST["email"]) && !empty($_POST["email"])) {

    }
    else {
        
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
                        <input type="email" name="mail" id="email" class="input-field-inscription" placeholder="Adresse de messagerie" required>
                    </div>
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