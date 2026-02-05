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


// Omani
$omaniMale0_4 = Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality = 'omani' AND patients.sex = 'Male' AND DATEDIFF( NOW(), patients.birthdate) < 5 * 365");
$omaniMale5_14 = Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality = 'omani' AND patients.sex = 'Male' AND DATEDIFF( NOW(), patients.birthdate) >= 5 * 365 AND DATEDIFF( NOW(), patients.birthdate) < 15 * 365");
$omaniMale15_59 = Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality = 'omani' AND patients.sex = 'Male' AND ( (DATEDIFF( NOW(), patients.birthdate) >= 15 * 365 AND DATEDIFF( NOW(), patients.birthdate) < 60 * 365) OR patients.birthdate = '0000-00-00')");
$omaniMale60_ = Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality = 'omani' AND patients.sex = 'Male' AND DATEDIFF( NOW(), patients.birthdate) >= 60 * 365");

$omaniFemale0_4 = Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality = 'omani' AND patients.sex = 'Female' AND DATEDIFF( NOW(), patients.birthdate) < 5 * 365");
$omaniFemale5_14 = Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality = 'omani' AND patients.sex = 'Female' AND DATEDIFF( NOW(), patients.birthdate) >= 5 * 365 AND DATEDIFF( NOW(), patients.birthdate) < 15 * 365");
$omaniFemale15_59 = Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality = 'omani' AND patients.sex = 'Female' AND ( (DATEDIFF( NOW(), patients.birthdate) >= 15 * 365 AND DATEDIFF( NOW(), patients.birthdate) < 60 * 365) OR patients.birthdate = '0000-00-00')");
$omaniFemale60_ = Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality = 'omani' AND patients.sex = 'Female' AND DATEDIFF( NOW(), patients.birthdate) >= 60 * 365");

// Non-Omani
$otherMale0_4 = Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality != 'omani' AND patients.sex = 'Male' AND DATEDIFF( NOW(), patients.birthdate) < 5 * 365");
$otherMale5_14 = Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality != 'omani' AND patients.sex = 'Male' AND DATEDIFF( NOW(), patients.birthdate) >= 5 * 365 AND DATEDIFF( NOW(), patients.birthdate) < 15 * 365");
$otherMale15_59 = Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality != 'omani' AND patients.sex = 'Male' AND ( (DATEDIFF( NOW(), patients.birthdate) >= 15 * 365 AND DATEDIFF( NOW(), patients.birthdate) < 60 * 365) OR patients.birthdate = '0000-00-00')");
$otherMale60_ = Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality != 'omani' AND patients.sex = 'Male' AND DATEDIFF( NOW(), patients.birthdate) >= 60 * 365");

$otherFemale0_4 = Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality != 'omani' AND patients.sex = 'Female' AND DATEDIFF( NOW(), patients.birthdate) < 5 * 365");
$otherFemale5_14 = Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality != 'omani' AND patients.sex = 'Female' AND DATEDIFF( NOW(), patients.birthdate) >= 5 * 365 AND DATEDIFF( NOW(), patients.birthdate) < 15 * 365");
$otherFemale15_59 = Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality != 'omani' AND patients.sex = 'Female' AND ( (DATEDIFF( NOW(), patients.birthdate) >= 15 * 365 AND DATEDIFF( NOW(), patients.birthdate) < 60 * 365) OR patients.birthdate = '0000-00-00')");
$otherFemale60_ = Request("SELECT COUNT(*) FROM `visits`, `patients` WHERE visits.patientId = patients.id AND visits.start >= '$start 00:00:00' AND visits.end <= '$end 23:59:59' AND patients.nationality != 'omani' AND patients.sex = 'Female' AND DATEDIFF( NOW(), patients.birthdate) >= 60 * 365");


$factor = 1;

echo json_encode([
    ["From $start to $end", ""],
    
    // Omani
    ["Omani Male 0-4",      ceil($factor * $omaniMale0_4[0][0])],
    ["Omani Male 5-14",     ceil($factor * $omaniMale5_14[0][0])],
    ["Omani Male 15-59",    ceil($factor * $omaniMale15_59[0][0])],
    ["Omani Male 60+",      ceil($factor * $omaniMale60_[0][0])],

    ["Omani Female 0-4",    ceil($factor * $omaniFemale0_4[0][0])],
    ["Omani Female 5-14",   ceil($factor * $omaniFemale5_14[0][0])],
    ["Omani Female 15-59",  ceil($factor * $omaniFemale15_59[0][0])],
    ["Omani Female 60+",    ceil($factor * $omaniFemale60_[0][0])],

    // Non-Omani
    ["Non-Omani Male 0-4",      ceil($factor * $otherMale0_4[0][0])],
    ["Non-Omani Male 5-14",     ceil($factor * $otherMale5_14[0][0])],
    ["Non-Omani Male 15-59",    ceil($factor * $otherMale15_59[0][0])],
    ["Non-Omani Male 60+",      ceil($factor * $otherMale60_[0][0])],

    ["Non-Omani Female 0-4",    ceil($factor * $otherFemale0_4[0][0])],
    ["Non-Omani Female 5-14",   ceil($factor * $otherFemale5_14[0][0])],
    ["Non-Omani Female 15-59",  ceil($factor * $otherFemale15_59[0][0])],
    ["Non-Omani Female 60+",    ceil($factor * $otherFemale60_[0][0])],

]);


