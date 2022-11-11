<?php
require "includes/connect.php";
$derniersjours = [];
$caloriesparjour = [];
$couleurcalories = [];
$id = $_SESSION["user"]["id"];
for ($i = 0; $i < 10; $i++) {
    $derniersjours[] = date('Y-m-d', strtotime("- $i day"));
    $sql = "SELECT `date`, `calorie` FROM `calories` WHERE `id_membre` = '$id' AND `date` = '$derniersjours[$i]'";
    $query = $db->prepare($sql);
    $query->execute();
    $data = $query->fetchAll();
    if(!empty($data)) {
        $caloriesparjour[] = $data[0]["calorie"];
    } else {
        $caloriesparjour[] = 0;
    }
}

foreach ($caloriesparjour as $key) {
    if($key <= 1500 ) {
        $couleurcalories[] = "Blue";
    } elseif($key > 1500 && $key<=6000) {
        $couleurcalories[] = "Green";
    } elseif($key > 6000 && $key<=8000) {
        $couleurcalories[] = "Orange";
    } elseif($key > 8000) {
        $couleurcalories[] = "Red";
    }
}

$dataPoints1 = array(
    array("label" => "$derniersjours[9]", "y" => $caloriesparjour[9], "color" => $couleurcalories[9]),
    array("label" => "$derniersjours[8]", "y" => $caloriesparjour[8], "color" => $couleurcalories[8]), 
    array("label" => "$derniersjours[7]", "y" => $caloriesparjour[7], "color" => $couleurcalories[7]),
    array("label" => "$derniersjours[6]", "y" => $caloriesparjour[6], "color" => $couleurcalories[6]),
    array("label" => "$derniersjours[5]", "y" => $caloriesparjour[5], "color" => $couleurcalories[5]),
    array("label" => "$derniersjours[4]", "y" => $caloriesparjour[4], "color" => $couleurcalories[4]),
    array("label" => "$derniersjours[3]", "y" => $caloriesparjour[3], "color" => $couleurcalories[3]),
    array("label" => "$derniersjours[2]", "y" => $caloriesparjour[2], "color" => $couleurcalories[2]),
    array("label" => "$derniersjours[1]", "y" => $caloriesparjour[1], "color" => $couleurcalories[1]),
    array("label" => "$derniersjours[0]", "y" => $caloriesparjour[0], "color" => $couleurcalories[0])
);
//  $dataPoints2 = array(
//      array("label"=> "", "y"=> 64.61),
//      array("label"=> "2011", "y"=> 70.55),
//      array("label"=> "2012", "y"=> 72.50),
//      array("label"=> "2013", "y"=> 81.30),
//      array("label"=> "2014", "y"=> 63.60),
//      array("label"=> "2015", "y"=> 69.38),
//      array("label"=> "2016", "y"=> 98.70)
//  );
?>
<script>
    window.onload = function() {

var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    theme: "light2",
    title: {
        text: "Calories par jour (10 derniers jours)"
    },
    axisY: {
        includeZero: true
    },
    legend: {
        cursor: "pointer",
        verticalAlign: "center",
        horizontalAlign: "right",
        itemclick: toggleDataSeries
    },
    data: [{
        type: "column",
        name: "Real Trees",
        indexLabel: "{y}",
        yValueFormatString: "#0.# Kal#",
        showInLegend: true,
        dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
    }]
});
chart.render();

function toggleDataSeries(e) {
    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    } else {
        e.dataSeries.visible = true;
    }
    chart.render();
}

}
</script>