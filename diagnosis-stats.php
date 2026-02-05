<?php
$startTime = microtime(true);

require ('connect-mysql.php');

$start = $_GET["start"];
$end = $_GET["end"];

// Single optimized query using conditional aggregation
$query = "
SELECT 
    d.diagnosis,
    SUM(CASE WHEN p.nationality = 'omani' AND DATEDIFF(NOW(), p.birthdate) < 5 * 365 THEN 1 ELSE 0 END) as omani_0_4,
    SUM(CASE WHEN p.nationality = 'omani' AND DATEDIFF(NOW(), p.birthdate) >= 5 * 365 AND DATEDIFF(NOW(), p.birthdate) < 15 * 365 THEN 1 ELSE 0 END) as omani_5_14,
    SUM(CASE WHEN p.nationality = 'omani' AND ((DATEDIFF(NOW(), p.birthdate) >= 15 * 365 AND DATEDIFF(NOW(), p.birthdate) < 60 * 365) OR p.birthdate = '0000-00-00') THEN 1 ELSE 0 END) as omani_15_59,
    SUM(CASE WHEN p.nationality = 'omani' AND DATEDIFF(NOW(), p.birthdate) >= 60 * 365 THEN 1 ELSE 0 END) as omani_60,
    SUM(CASE WHEN p.nationality != 'omani' AND DATEDIFF(NOW(), p.birthdate) < 5 * 365 THEN 1 ELSE 0 END) as other_0_4,
    SUM(CASE WHEN p.nationality != 'omani' AND DATEDIFF(NOW(), p.birthdate) >= 5 * 365 AND DATEDIFF(NOW(), p.birthdate) < 15 * 365 THEN 1 ELSE 0 END) as other_5_14,
    SUM(CASE WHEN p.nationality != 'omani' AND ((DATEDIFF(NOW(), p.birthdate) >= 15 * 365 AND DATEDIFF(NOW(), p.birthdate) < 60 * 365) OR p.birthdate = '0000-00-00') THEN 1 ELSE 0 END) as other_15_59,
    SUM(CASE WHEN p.nationality != 'omani' AND DATEDIFF(NOW(), p.birthdate) >= 60 * 365 THEN 1 ELSE 0 END) as other_60,
    COUNT(*) as total
FROM diagnosis d
JOIN visits v ON d.visitId = v.id
JOIN patients p ON v.patientId = p.id
WHERE v.start >= '$start 00:00:00' AND v.end <= '$end 23:59:59'
GROUP BY d.diagnosis
ORDER BY total DESC
";

$statement = $dbcon->prepare($query);
$statement->execute();
$results = $statement->get_result();

$result = [];
while ($row = $results->fetch_row()) {
    $result[] = [
        $row[0],
        (int)$row[1],
        (int)$row[2],
        (int)$row[3],
        (int)$row[4],
        (int)$row[5],
        (int)$row[6],
        (int)$row[7],
        (int)$row[8]
    ];
}

$duration = (microtime(true) - $startTime);
error_log("Diagnosis Stats was generated in {$duration}s from $start to $end");

echo json_encode($result);
?>