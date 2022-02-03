<?php

//load.php

require ('connect-mysql.php');

$data = array();
if(isset($_POST["vid"])){
    $x = $_POST["vid"];
    $query = "SELECT t1.payment1 + t2.payment2 from (SELECT IFNULL(SUM(diagnosis.price), 0) AS payment1 FROM diagnosis WHERE diagnosis.visitId = $x) AS t1 , (SELECT IFNULL(SUM(surgeries.price), 0) AS payment2 FROM surgeries WHERE surgeries.visitId = $x) AS t2;";

    $statement = $dbcon->prepare($query);

    $statement->execute();

    $results = $statement->get_result();

    $result = $results->fetch_all();

    echo json_encode($result[0][0]);
}
?>