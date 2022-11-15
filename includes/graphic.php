<?php
require_once "includes/connect.php";
$id = $_SESSION["user"]["id"];
$sql = "SELECT * FROM `calories` WHERE id_membre = '$id' AND date >= DATE_ADD(CURDATE(), INTERVAL -10 DAY) AND date <= CURDATE() ORDER BY `date`";
$query = $db->prepare($sql);
$query->execute();
$data = $query->fetchAll();
?>
<div id="chart-calorie">

    <!-- show-primary-axis -->
    <table class="charts-css column multiple show-labels show-heading show-data-on-hover" id="chart-calorie">
        <caption> Calories par Jour </caption>
        <tbody>

            <?php foreach ($data as $key) { ?>
                <tr>
                    <th scope="row"> <?= date('d/m/Y', strtotime($key["date"])) ?> </th>
                    <td style="--size: <?= $key["calorie"] / 10000 ?>"><span class="data"><?= $key["calorie"] ?></span></td>
                </tr><?php
                    } ?>

        </tbody>
    </table>
</div>