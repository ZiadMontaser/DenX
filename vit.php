<?php

//load.php

require ('connect-mysql.php');

$data = array();
if(isset($_POST["vid"])){
    $x = $_POST["vid"];
    $y = $_POST["pid"];
    $query = "SELECT vis.start, vit.Temp, vit.GCS, vit.Pulse, vit.Resp, vit.BP_sys, vit.BP_dia FROM visits AS vis, vital_signs AS vit WHERE vis.id = vit.Visit_ID AND vit.Patient_ID = $y order by vis.ID;";

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
            3   => $row[3],
            4   => $row[4],
            5   => $row[5],
            6   => $row[6],
        );
    }

    echo json_encode($data);
}
?>