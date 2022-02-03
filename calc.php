<?php

//load.php

require ('connect-mysql.php');

$data = array();
if(isset($_POST["start"]) && isset($_POST["end"])){
    $start = $_POST["start"];
    $end = $_POST["end"];
    $query = "SELECT (SELECT ifnull(SUM(price),0) from visits, surgeries WHERE visits.id=surgeries.visitId and visits.start>='$start 00:00:00' AND visits.end<='$end 23:59:59') + (SELECT ifnull(SUM(payment), 0) from visits WHERE visits.start>='$start 00:00:00' AND visits.end<='$end 23:59:59');;";

    $statement = $dbcon->prepare($query);

    $statement->execute();

    $results = $statement->get_result();

    $result = $results->fetch_all();
    
    echo json_encode($result[0][0]);
}
?>