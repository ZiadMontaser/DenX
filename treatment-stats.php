<?php
$startTime = microtime(true);

require ('connect-mysql.php');

$start = $_GET["start"];
$end = $_GET["end"];

$query = "SELECT surgery, COUNT(*) FROM `surgeries`,visits WHERE surgeries.visitId = visits.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' GROUP BY surgery  
    ORDER BY `COUNT(*)`  DESC";
$statement = $dbcon->prepare($query);

$statement->execute();

$results = $statement->get_result();

$result = $results->fetch_all();

$duration = (microtime(true) - $startTime);
error_log("Treatment Stats was generated in {$duration}s from $start to $end");

echo json_encode($result);
