<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: connexion.php");
    exit;
}
if (isset($_SESSION["LAST_ACTIVITY"]) && time() - $_SESSION["LAST_ACTIVITY"] > 3600) {
    header("Location: deconnexion.php");
}
require "../../trackcalorie/includes/connect.php";
// $sql = "SELECT AVG(DATEDIFF(CURRENT_DATE, `anniv`)) AS age FROM `membres` WHERE `anniv` IS NOT NULL";
$sql = "SELECT AVG(YEAR(CURDATE()) - YEAR(`anniv`) - (RIGHT(CURDATE(), 5) < RIGHT(`anniv`, 5))) AS age FROM `membres` WHERE `anniv` IS NOT NULL";
$query = $db->prepare($sql);
$query->execute();
$ageMoyen = $query->fetch();
$age = (is_numeric($ageMoyen["age"])) ? (float)$ageMoyen["age"] : 0;

$sql = "SELECT count(*) AS coun FROM `membres` WHERE `sexe`= 'man'";
$query = $db->prepare($sql);
$query->execute();
$data = $query->fetch();
$sql = "SELECT count(*) AS coun FROM `membres`";
$query = $db->prepare($sql);
$query->execute();
$dataA = $query->fetch();
$proportionM = round($data["coun"] / $dataA["coun"] * 100);
$proportionF = 100 - $proportionM;
$sql = "SELECT year(`dateinscription`) AS z,month(`dateinscription`) AS x,count(`id`) AS y FROM `membres` group by year(`dateinscription`),month(`dateinscription`) ORDER BY year(`dateinscription`),month(`dateinscription`)";
// $sql = "SELECT month(`dateinscription`) AS x,count(`id`) AS 'y' FROM `membres` group by year(`dateinscription`),month(`dateinscription`) ORDER BY year(`dateinscription`), month(`dateinscription`) LIMIT 10";
$query = $db->prepare($sql);
$query->execute();

$data = $query->fetchAll();
foreach ($data as $key => $value) {
    if ($value["x"] === '1') {
        $data[$key]["x"] = "Janvier";
    }
    if ($value["x"] === '2') {
        $data[$key]["x"] = "Février";
    }
    if ($value["x"] === '3') {
        $data[$key]["x"] = "Mars";
    }
    if ($value["x"] === '4') {
        $data[$key]["x"] = "Avril";
    }
    if ($value["x"] === '5') {
        $data[$key]["x"] = "Mai";
    }
    if ($value["x"] === '6') {
        $data[$key]["x"] = "Juin";
    }
    if ($value["x"] === '7') {
        $data[$key]["x"] = "Juillet";
    }
    if ($value["x"] === '8') {
        $data[$key]["x"] = "Août";
    }
    if ($value["x"] === '9') {
        $data[$key]["x"] = "Septembre";
    }
    if ($value["x"] === '10') {
        $data[$key]["x"] = "Octobre";
    }
    if ($value["x"] === '11') {
        $data[$key]["x"] = "Novembre";
    }
    if ($value["x"] === '12') {
        $data[$key]["x"] = "Décembre";
    }
}
$creationCompteParMois = $data;
//print json_encode($data);
//file_put_contents("chartline.json", json_encode($data));

?>


<?php
require_once "includes/headeradmin.php";
require_once "includes/menu.php";
require_once "includes/navbaradmin.php";
?>




<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <?php
                            $currentMonthLet = date("M");
                            $currentMonth = date("m");
                            $currentYear = date("Y");
                            ?>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Nombre de comptes créés en <?= $currentMonthLet ?></div>
                            <?php
                            $sql = "SELECT count(*) AS compte FROM `membres` WHERE YEAR(`dateinscription`) = :currentyear AND MONTH(`dateinscription`) = :currentmonth";
                            $query = $db->prepare($sql);
                            $query->bindValue("currentyear", $currentYear, PDO::PARAM_STR);
                            $query->bindValue("currentmonth", $currentMonth, PDO::PARAM_STR);
                            $query->execute();
                            $data = $query->fetchAll();
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data[0]["compte"] ?></div>

                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Calories ajoutées ces 10 derniers jours</div>
                            <?php
                            $sql = "SELECT `calorie` FROM `calories`";
                            $query = $db->prepare($sql);
                            $query->execute();
                            $data = $query->fetchAll();
                            $calorieTot = 0;
                            //var_dump((int)$data[0]["calorie"]);
                            foreach ($data as $key => $value) {
                                //var_dump($key);
                                $calorieTot += $value["calorie"];
                            }
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $calorieTot ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Âge moyen des utilisateurs</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= round($age, 1). " ans" ?></div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: <?= round($ageMoyen['age'])."%" ?>" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Dernier compte crée :</div>
                            <?php
                            $query = $db->prepare("SELECT `email` FROM membres WHERE id = (SELECT MAX(id) FROM membres)");
                            $query->execute();
                            $data = $query->fetch();
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data["email"] ?></div>
                        </div><?php $db = null; ?>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Linea Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Création</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="">
                        <div id="memberByMonth" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Membres</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="text-center">
                        <div id="hommefemme" style="height: 370px; width: 100%;"></div>
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> Femme
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Homme
                        </span>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- /.container-fluid -->
<script>
    window.onload = function() {
        var chart = new CanvasJS.Chart("hommefemme", {
            animationEnabled: true,
            title: {
                text: "Utilisateurs par genre"
            },
            data: [{
                type: "pie",
                startAngle: 240,
                yValueFormatString: "##0.00\"%\"",
                indexLabel: "{label} {y}",
                dataPoints: [{
                        y: <?= $proportionM ?>,
                        label: "Homme",
                        color: "#36B9CC"
                    },
                    {
                        y: <?= $proportionF ?>,
                        label: "Femme",
                        color: "#F6C23F"
                    }
                ]
            }],
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                }
            }
        });
        chart.render();
        var chart = new CanvasJS.Chart("memberByMonth", {
            animationEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            title: {
                text: "Création de compte depuis <?= $creationCompteParMois[0]['x'] . " " . $creationCompteParMois[0]['z'] ?>"
            },
            axisY: {
                title: "Membre(s) créé(s)",
            },
            axisX: {
                title: "Mois"
            },
            data: [{
                type: "column",
                yValueFormatString: "#,##0#\" Compte(s) créé(s)\"",
                dataPoints: [
                    <?php foreach ($creationCompteParMois as $key => $value) {
                    ?> {
                            label: "<?= $value["x"] ?>",
                            y: <?= $value["y"] ?>
                        },
                    <?php
                    } ?>
                ]
            }]
        });
        chart.render();







        <?php echo json_encode($creationCompteParMois, JSON_NUMERIC_CHECK); ?>
    }
</script>
<?php require_once "includes/footeradmin.php"; ?>