<?php

//load.php

require ('connect-mysql.php');

$data = array();
if(isset($_POST["pid"]) && isset($_POST["did"])){
    $x = $_POST["pid"];
    $x1 = $_POST["did"];
    $query = "SELECT visits.id, patients.name, visits.dentistId, visits.start, visits.end, visits.done, visits.payment, visits.Comment, visits.patientId FROM visits, patients where patientid=$x and dentistid=$x1 and visits.patientId=patients.id ORDER BY id";

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
            'end'   => $row[4],
            'patient' => $row[1],
            'dentist' => $row[2],
            'done' => $row[5],
            'payment' => $row[6],
            'comment' => $row[7],
            'pid' => $row[8]

        );
    }

    echo json_encode($data);
}
?>