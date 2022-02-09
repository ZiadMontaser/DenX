<?php

//load.php

require ('connect-mysql.php');

$data = array();
if(isset($_POST["vid"])){
    $x = $_POST["vid"];
    $y = $_POST["pid"];
    $query = "SELECT vis.start, med.medication, med.allergies FROM visits AS vis, med_hist AS med WHERE vis.id = med.Visit_ID AND med.Patient_ID = $y order by vis.ID;";

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