
<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: connexion.php");
    exit;
}
require_once "includes/header.php";
$name = $_SESSION['user']['name'];
$lastname = $_SESSION['user']['lastname'];


// Calcul IMC :
$height = $_SESSION["user"]["height"]; 
$height = $height*0.01; // Passer la taille de cm à m
$weight = $_SESSION["user"]["weight"];
$imc = round($weight / ($height*$height), 1); // Calcul de l'IMC adulte arrondit à 1 chiffre après la virgule

// Formulaire d'ajout de calories
if(!empty($_POST)) {
    
    if(isset($_POST["kalnb"], $_POST["kaldate"]) && !empty($_POST["kalnb"]) && !empty($_POST["kaldate"])) {
        // Les valeurs sont existantes et pas vides
        $kalnb = (is_numeric($_POST["kalnb"])) ? (int)$_POST["kalnb"] : 0;
        $_SESSION["error"] = [];
        include "includes/function.php";
        // Vérifier le format de la date
        if(!validateDate($_POST["kaldate"], 'Y-m-d')) {
            $_SESSION["error"][] = "Une erreur est survenue dans le format de la date";
        }
        // Vérifier le format du nombre de callorie
        if($kalnb < 1 || $kalnb > 8000) {
            $_SESSION["error"][] = "Le nombre de calories est incorrect (doit être compris entre 1 et 8000)";
        }
        

        if ($_SESSION["error"] === []) {
            $date = $_POST["kaldate"];
            require "includes/connect.php";
            $sql = "SELECT * FROM `calories` WHERE `date` = :datechoisie";
            $query = $db->prepare($sql);
            $query->bindValue(":datechoisie", $date, PDO::PARAM_STR);
            $query->execute();
            $data = $query->fetchAll();
            // Si la date existe déjà : update la donnée
            if(!empty($data)) {
                $sql = "UPDATE `calories` SET `calorie` = :kalnb WHERE `date`= :datechoisie";
                $query = $db->prepare($sql);
                $query->bindValue(":kalnb", $data[0]["calorie"] + $_POST["kalnb"], PDO::PARAM_STR);
                $query->bindValue(":datechoisie", $date, PDO::PARAM_STR);
                $query->execute();
                $_SESSION["validinsertcalorie"] = ["Vos données ont bien été sauvegardé !"];
            } else {
                // Sinon insérer une nouvelle entrée
                echo "fzefef";
                $sql = "INSERT INTO `calories`(`date`, `calorie`, `id_membre`) VALUES (:kaldate, :kalnb, :idmember)";
                $query = $db->prepare($sql);
                $query->bindValue(":kaldate", $_POST["kaldate"], PDO::PARAM_STR);
                $query->bindValue(":kalnb", $_POST["kalnb"], PDO::PARAM_STR);
                $query->bindValue(":idmember", $_SESSION["user"]["id"], PDO::PARAM_STR);
                $query->execute();
                $_SESSION["validinsertcalorie"] = ["Vos données ont bien été sauvegardé !"];
            }


        }

        
    } else {
        $_SESSION["error"] = ["Formulaire invalide"];
    }
} 

?>
<h1>TrackCalorie</h1>
<h2>Profil de <?= "$name $lastname" ?></h2>
<h3>IMC de <?= "$imc" ?></h3>

<form action="" method="post">
    <div>
        <input type="number" name="kalnb" id="kalnb" placeholder="Nombre de calories" min="0" max="8000"  required>
    </div>
    <div>
        <input type="date" name="kaldate" id="kaldate" placeholder="Choisir une date" required>
    </div>
        <button type="submit">Confirmer</button>
</form>

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

<?php
    if(isset($_SESSION["validinsertcalorie"])) {
        foreach($_SESSION["validinsertcalorie"] as $message) {
?>
            <p><?= $message ?></p>
<?php
        }
        unset($_SESSION["validinsertcalorie"]);
    }
?>
<a href="deconnexion.php">Déconnexion</a>
<div>
    <?php
    require_once "includes/graph.php";
    ?>
    <div id="chartContainer" style="height: 370px; width: 50%;"></div>
</div>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<?php
require_once "includes/footer.php";
?>
