<?php
session_start();
require_once "includes/connect.php";
$sql = "SELECT * FROM `calories` WHERE id_membre = 5 AND date >= DATE_ADD(CURDATE(), INTERVAL -10 DAY) AND date <= CURDATE() ORDER BY `date`";
$query = $db->prepare($sql);
$query->execute();
$data = $query->fetchAll();
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/charts.min.css">
    <link rel="stylesheet" href="style/graph.css">
    <title>Graphique</title>
</head>

<body>
    <div id="chart-calorie">

<!-- show-primary-axis -->
        <table class="charts-css column multiple show-labels show-heading show-data-on-hover" id="chart-calorie">
            <caption> Calories par Jour </caption>
            <tbody>

                    <?php foreach ($data as $key) { ?>
                        <tr><th scope="row"> <?= date('d/m/Y', strtotime($key["date"])) ?> </th>
                        <td style="--size: <?= $key["calorie"]/10000 ?>"><span class="data"><?= $key["calorie"] ?></span></td></tr><?php
                    } ?>

            </tbody>
        </table>
    </div>
    <script src="script/chartcalorie.js"></script>
</body>

</html>