<?php

//load.php

require ('connect-mysql.php');

$data = array();
if(isset($_POST["vid"])){
    $x = $_POST["vid"];
    $y = $_POST["pid"];
    $query = "SELECT vis.start, soc.family, soc.soc, soc.travel FROM visits AS vis, soc_hist AS soc WHERE vis.id = soc.Visit_ID AND soc.Patient_ID = $y order by vis.ID;";

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
}
?>