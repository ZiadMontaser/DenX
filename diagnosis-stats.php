<?php
$startTime = hrTime(true);

ob_start();
require 'diagnosis.php';
$diagnosis = json_decode(ob_get_clean());

$start = $_GET["start"];
$end = $_GET["end"];

$stats = array();
foreach($diagnosis as $diagnos){
    $query = "SELECT surgeries.id FROM `diagnosis` , `visits` WHERE surgeries.visitId = visits.id AND surgeries.surgery=\"$diagnos\" AND visits.start >='$start 00:00:00' AND visits.end <= '$end 23:59:59'";

    $statement = $dbcon->prepare($query);

    $statement->execute();

    $results = $statement->get_result();

    $result = $results->fetch_all();

    $count = count($result);

    if($count > 0){
        $entery = array(
            "Diagnos"=> $diagnos,
            "Number" => "$count"
        );
        array_push($stats, $entery);
    }
}

$duration = (hrtime(true) - $startTime) / 1000000000;
error_log("Diagnoes Stats was generated in {$duration}s from $start to $end");

echo json_encode($stats);
?>