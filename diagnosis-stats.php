<?php
ob_start();
require 'diagnosis.php';
$diagnosis = json_decode(ob_get_clean());

$start = $_GET["start"];
$end = $_GET["end"];
error_log("$start 00:00:00");
error_log("$end 23:59:59");
$stats = array();
foreach($diagnosis as $diagnos){
    $query = "SELECT * FROM `diagnosis` WHERE diagnosis=\"{$diagnos}\"";

    $statement = $dbcon->prepare($query);

    $statement->execute();

    $results = $statement->get_result();

    $result = $results->fetch_all();
    
    $count = 0;


    foreach($result as $row){
        $query1 = "SELECT * FROM `visits` WHERE id={$row[1]}";
        $statement1 = $dbcon->prepare($query1);
        $statement1->execute();
        $visit = $statement1->get_result()->fetch_all();
        if($visit[0][3]>="$start 00:00:00" and $visit[0][4]<="$end 23:59:59"){
            $count += 1;
        }
        
    }

    if($count > 0){
        $entery = array(
            "Diagnos"=> $diagnos,
            "Number" => "$count"
        );
        array_push($stats, $entery);
    }
}
echo json_encode($stats);
?>