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
$sql = "SELECT year(`dateinscription`) AS years,month(`dateinscription`) AS month,count(`id`) AS newaccount FROM `membres` group by year(`dateinscription`),month(`dateinscription`) ORDER BY year(`dateinscription`),month(`dateinscription`)";
$query = $db->prepare($sql);
$query->execute();
$data = $query->fetchAll();
//print json_encode($data);
file_put_contents("chartline.json", json_encode($data));

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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Proportion Homme / Femme
                            </div>
                            <?php
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
                            ?>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= "♂️ $proportionM%" ?></div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: <?= "$proportionM%" ?>" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= "♀️ $proportionF%" ?></div>
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

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
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
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
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
                    <div class="chart-pie pt-4 pb-2">
                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                    
                    </div>
                        <script>
                            window.onload = function() {
                                var chart = new CanvasJS.Chart("chartContainer", {
                                    animationEnabled: true,
                                    title: {
                                        text: "Pourcentage des utilisateurs par genre"
                                    },
                                    data: [{
                                        type: "pie",
                                        startAngle: 240,
                                        yValueFormatString: "##0.00\"%\"",
                                        indexLabel: "{label} {y}",
                                        dataPoints: [{
                                                y: <?= $proportionM ?>,
                                                label: "Homme"
                                            },
                                            {
                                                y: <?= $proportionF ?>,
                                                label: "Femme"
                                            }
                                        ]
                                    }]
                                });
                                chart.render();
                            }
                        </script>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<?php require_once "includes/footeradmin.php"; ?>