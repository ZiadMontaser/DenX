<?php

//load.php

require ('connect-mysql.php');

$data = array();
if(isset($_POST["vid"])){
    $x = $_POST["vid"];
    $y = $_POST["pid"];
    $query = "SELECT vis.start, tp.Plan, tp.Advice FROM visits AS vis, treatment_plan AS tp WHERE vis.id = tp.Visit_ID AND tp.Patient_ID = $y order by vis.ID;";

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
        );
    }

    echo json_encode($data);
}
?>