<?php

//load.php

require ('connect-mysql.php');

$data = array();

$query = "SELECT visits.id, patients.name, visits.dentistId, visits.start, visits.end, visits.done, visits.payment, visits.Comment, staff.name,visits.patientId FROM visits, patients, staff where visits.patientId=patients.id and visits.dentistId=staff.id ORDER BY id";

$statement = $dbcon->prepare($query);

$statement->execute();

$results = $statement->get_result();

$result = $results->fetch_all();

foreach($result as $row)
{
 $data[] = array(
    'id'   => $row[0],
    'title'   => $row[1] . "-" . $row[8],
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

?>