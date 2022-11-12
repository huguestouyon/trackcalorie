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



<div>
    <?php
    require_once "includes/graph.php";
    ?>
    <div id="chartContainer" style="height: 370px; width: 50%;"></div>
</div>


<div class="modal fade bg-dark" id="exampleModalToggle" aria-labelledby="exampleModalToggleLabel" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel"><?= "Hey " . $_SESSION["user"]["name"] ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="add-tab" data-bs-toggle="tab" data-bs-target="#add" type="button" role="tab" aria-controls="add" aria-selected="true"><i class="fa-solid fa-plus"></i></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="suppr-tab" data-bs-toggle="tab" data-bs-target="#suppr" type="button" role="tab" aria-controls="suppr" aria-selected="false"><i class="fa-solid fa-minus"></i></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="user-tab" data-bs-toggle="tab" data-bs-target="#user" type="button" role="tab" aria-controls="user" aria-selected="false"><i class="fa-solid fa-user"></i></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="setting-tab" data-bs-toggle="tab" data-bs-target="#setting" type="button" role="tab" aria-controls="setting" aria-selected="false"><i class="fa-solid fa-gear"></i></button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="add" role="tabpanel" aria-labelledby="add-tab">
                        <h3 class="pt-3">Ajoute des calories</h3>
                        <form action="" method="post">
                            <div class="form-group pt-2">
                                <input type="number" class="form-control" name="kalnb" id="kalnb" placeholder="Nombre de calories" min="0" max="8000" required>
                            </div>
                            <div class="form-group pt-2">
                                <input type="date" class="form-control" name="kaldate" id="kaldate" placeholder="Choisir une date" required>
                            </div>
                            <div class="pt-2 text-center">
                                <button class="btn btn-outline-dark" type="submit"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="suppr" role="tabpanel" aria-labelledby="suppr-tab">
                        <h3 class="pt-3">Supprime des calories</h3>
                        <form action="" method="post">
                            <div class="form-group pt-2">
                                <input type="date" class="form-control" name="supprdate" id="supprdate" placeholder="Choisir une date" required>
                            </div>
                            <div class="pt-2 text-center">
                                <button class="btn btn-outline-dark" type="submit"><i class="fa-solid fa-minus"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
                        <h3 class="pt-3">Modifie tes données</h3>
                        <form>
                            <div class="row mb-2">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Prénom">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Nom">
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-br-none"><i class="fa-regular fa-envelope"></i></span>
                                </div>
                                <input type="email" class="form-control" placeholder="Adresse Email">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-br-none"><i class="fa-sharp fa-solid fa-phone"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Numéro de téléphone">
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <input type="number" class="form-control" placeholder="Taille">
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" placeholder="Poids">
                                </div>
                            </div>
                            <div class="pt-2 text-center">
                                <button class="btn btn-outline-dark" type="submit">Modifier les informations</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="setting" role="tabpanel" aria-labelledby="setting-tab">
                        <h3 class="pt-3">Paramètres</h3>
                        <form action="" method="post">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-br-none"><i class="fa-solid fa-key"></i></span>
                                </div>
                                <input type="password" class="form-control" placeholder="Ancien mot de passe">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-br-none"><i class="fa-solid fa-key"></i></span>
                                </div>
                                <input type="password" class="form-control" placeholder="Nouveau mot de passe">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-br-none"><i class="fa-solid fa-key"></i></span>
                                </div>
                                <input type="password" class="form-control" placeholder="Retaper nouveau mot de passe">
                            </div>
                            <div class="pt-2 text-center">
                                <button class="btn btn-outline-dark" type="submit"><i class="fa-solid fa-pen"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>


















<script src="script/main.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<?php
require_once "includes/footer.php";
?>