<?php

//load.php

require ('connect-mysql.php');

$obj = json_decode($_POST["myData"]);
$x1 = $obj->v;
$x3 = $obj->t;
$x4 = $obj->d;
$x322 = $obj->t22;
$x422 = $obj->d22;
$x5 = $obj->p;
$x6 = $obj->c;
$x622 = $obj->c22;
$x62233 = $obj->c2233;

$query = "INSERT INTO `examinations`(`Patient_ID`, `Visit_ID`, `Dental`, `Intra_oral`, `extra_oral`, `dental_findings`, `dental_procedures`, `OMFS`, `Orthodontic`) VALUES ($x5,$x1,\"$x3\",\"$x4\",\"$x6\",\"$x322\",\"$x422\",\"$x622\",\"$x62233\") ON DUPLICATE KEY UPDATE Dental=\"$x3\", Intra_oral=\"$x4\", extra_oral=\"$x6\", dental_findings=\"$x322\", dental_procedures=\"$x422\", OMFS=\"$x622\", Orthodontic=\"$x62233\";";

$statement = $dbcon->prepare($query);
echo $query;
$statement->execute();


?>