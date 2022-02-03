<?php

//load.php

require ('connect-mysql.php');

$data = array();

$query = "SELECT * FROM fd;";

$statement = $dbcon->prepare($query);

$statement->execute();

$results = $statement->get_result();

$result = $results->fetch_all();

foreach($result as $row)
{
    $data[] = array(
        0   => $row[0],
        1   => $row[1],
        2   => $row[2],
        3   => $row[3]
    );
}

echo json_encode($data);

?>