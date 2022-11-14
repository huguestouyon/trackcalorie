<?php
session_start();
require_once "includes/connect.php";
$sql = "SELECT * FROM calories WHERE id_membre = 3 AND ";
$query = $db->prepare($sql);
$query->execute();
$data = $query->fetchAll();
echo "<pre>";
var_dump($data);
echo "</pre>";
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
    <div id="my-chart">


        <table class="charts-css column multiple show-labels show-heading show-primary-axis show-data-on-hover" id="chart1">
            <caption> 2016 Summer Olympics Medal Table </caption>

            <thead>
                <tr>
                    <th scope="col"> Country </th>
                    <th scope="col"> Gold </th>
                    <th scope="col"> Silver </th>
                    <th scope="col"> Bronze </th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <th scope="row"> USA </th>
                    <td style="--size: calc(40 /100)"><span class="data">46</span></td>
                    <td style="--size: calc(40 /100)"><span class="data">37</span></td>
                    <td style="--size: calc(40 /100)"><span class="data">38</span></td>
                </tr>
                <tr>
                    <th scope="row"> GBR </th>
                    <td style="--size: calc(20 /100)"><span class="data">27</span></td>
                    <td style="--size: calc(30 /100)"><span class="data">23</span></td>
                    <td style="--size: calc(40 /100)"><span class="data">17</span></td>
                </tr>
                <tr>
                    <th scope="row"> CHN </th>
                    <td style="--size: calc(50 /100)"><span class="data">26</span></td>
                    <td style="--size: calc(60 /100)"><span class="data">18</span></td>
                    <td style="--size: calc(70 /100)"><span class="data">26</span></td>
                </tr>
            </tbody>
        </table>
        <ul class="chart-css legend legend-inline legend-circle">
            <li>Année 1</li>
            <li>Année 2</li>
            <li>Année 3</li>
            <li>Année 4</li>
            <li>Année 5</li>
        </ul>
    </div>
</body>

</html>