<?php
$startTime = microtime(true);

require ('connect-mysql.php');

$start = $_GET["start"];
$end = $_GET["end"];
$result = 0;

function Request($query){
    global $dbcon;
    global $start;
    global $end;

    // $query = "SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality = 'omani'";
    error_log($query);
    $statement = $dbcon->prepare($query);

    $statement->execute();

    $results = $statement->get_result();

    $result = $results->fetch_all();
    return $result;
}

$duration = (microtime(true) - $startTime);
error_log("Visits Stats was generated in {$duration}s from $start to $end");

// $omainMale = Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND patients.sex = 'Male'  AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality = 'omani'");
// $omainFemale = Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND patients.sex = 'Female'  AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality = 'omani'");
// $otherMale = Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND patients.sex = 'Male'  AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality != 'omani'");
// $otherFemale = Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND patients.sex = 'Female'  AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality = 'omani'");

$youngOmani =      Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59'                             AND patients.nationality = 'omani' AND DATEDIFF( NOW(), patients.birthdate) < 5 * 365");
$teenOmani =       Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59'                             AND patients.nationality = 'omani' AND DATEDIFF( NOW(), patients.birthdate) >= 5 * 365 AND DATEDIFF( NOW(), patients.birthdate) < 14 * 365");
$adultOmaniMale =  Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.sex = 'Male'   AND patients.nationality = 'omani' AND (DATEDIFF( NOW(), patients.birthdate) >= 14 * 365 OR patients.birthdate = '0000-00-00')");
$adultOmaniFemale= Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.sex = 'Female' AND patients.nationality = 'omani' AND (DATEDIFF( NOW(), patients.birthdate) >= 14 * 365 OR patients.birthdate = '0000-00-00')");
$youngOther =      Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59'                             AND patients.nationality != 'omani' AND DATEDIFF( NOW(), patients.birthdate) < 5 * 365");
$teenOther =       Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59'                             AND patients.nationality != 'omani' AND DATEDIFF( NOW(), patients.birthdate) >= 5 * 365 AND DATEDIFF( NOW(), patients.birthdate) < 14 * 365");
$adultOtherMale =  Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.sex = 'Male'   AND patients.nationality != 'omani' AND (DATEDIFF( NOW(), patients.birthdate) >= 14 * 365 OR patients.birthdate = '0000-00-00')");
$adultOtherFemale= Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.sex = 'Female' AND patients.nationality != 'omani' AND (DATEDIFF( NOW(), patients.birthdate) >= 14 * 365 OR patients.birthdate = '0000-00-00')");

$factor = 1;

echo json_encode([
    ["From $start to $end", ""],
    ["Omani" , ""],
    ["Children < 5Yrs",     ceil($factor * $youngOmani[0][0])],
    ["Teen 5 to < 14 Yrs",  ceil($factor * $teenOmani[0][0])],
    ["Adult Male",          ceil($factor * $adultOmaniMale[0][0])],
    ["Adult Female",        ceil($factor * $adultOmaniFemale[0][0])],
    ["Non-Omani" , ""],
    ["Children < 5Yrs",     ceil($factor * $youngOther[0][0])],
    ["Teen 5 to < 14 Yrs",  ceil($factor * $teenOther[0][0])],
    ["Adult Male",          ceil($factor * $adultOtherMale[0][0])],
    ["Adult Female",        ceil($factor * $adultOtherFemale[0][0])],
]);


