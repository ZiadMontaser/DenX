<?php

//load.php

require ('connect-mysql.php');

$data = array();

$query = "SELECT tooth FROM `surgeries` WHERE 1";

$statement = $dbcon->prepare($query);

$statement->execute();

$results = $statement->get_result();

$result = $results->fetch_all();

foreach($result as $row)
{
    $data[] = array(
        0   => $row[0]
    );
}
$query = "SELECT tooth FROM `diagnosis` WHERE tooth not in(SELECT tooth FROM `surgeries` WHERE 1)";

$statement = $dbcon->prepare($query);

$statement->execute();

$results = $statement->get_result();

$result = $results->fetch_all();

foreach($result as $row)
{
    $data[] = array(
        0   => $row[0]
    );
}

echo json_encode($data);

?>