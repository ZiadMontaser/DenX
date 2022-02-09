<?php

//load.php

require ('connect-mysql.php');

$data = array();
if(isset($_POST["vid"])){
    $x = $_POST["vid"];
    $y = $_POST["pid"];
    $query = "SELECT vis.start, exa.Dental, exa.Intra_oral, exa.extra_oral, exa.dental_findings, exa.dental_procedures, exa.OMFS, exa.Orthodontic FROM visits AS vis, examinations AS exa WHERE vis.id = exa.Visit_ID AND exa.Patient_ID = $y order by vis.ID;";

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
            7   => $row[7],
        );
    }

    echo json_encode($data);
}
?>