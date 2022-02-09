<?php

//load.php

require ('connect-mysql.php');

$obj = json_decode($_POST["myData"]);
$x1 = $obj->v;
$x3 = $obj->t;
$x4 = $obj->d;
$x5 = $obj->p;
$x6 = $obj->c;

$query = "INSERT INTO `med_hist`(`Patient_ID`, `Visit_ID`, `Medication`, `Allergies`) VALUES ($x5,$x1,\"$x3\",\"$x4\") ON DUPLICATE KEY UPDATE Medication=\"$x3\", Allergies=\"$x4\";";

$statement = $dbcon->prepare($query);
echo $query;
$statement->execute();


?>