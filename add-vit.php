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

$query = "INSERT INTO `vital_signs`(`Patient_ID`, `Visit_ID`, `Temp`, `GCS`, `Pulse`, `Resp`, `BP_sys`, `BP_dia`) VALUES ($x5,$x1,\"$x3\",\"$x4\",\"$x6\",\"$x322\",\"$x422\",\"$x622\") ON DUPLICATE KEY UPDATE Temp=\"$x3\", GCS=\"$x4\", Pulse=\"$x6\", Resp=\"$x322\", BP_sys=\"$x422\", BP_dia=\"$x622\";";

$statement = $dbcon->prepare($query);
echo $query;
$statement->execute();


?>