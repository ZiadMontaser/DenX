<?php

//load.php

require ('connect-mysql.php');

$data = array();
if(isset($_POST["pid"])){
    $x = $_POST["pid"];
    $query = "SELECT * FROM visits where patientid=$x ORDER BY id";

    $statement = $dbcon->prepare($query);

    $statement->execute();

    $results = $statement->get_result();

    $result = $results->fetch_all();

    foreach($result as $row)
    {
        $data[] = array(
        'id'   => $row[0],
        'title'   => $row[1],
        'start'   => $row[3],
        'end'   => $row[4]
        );
    }

    echo json_encode($data);
}
?>