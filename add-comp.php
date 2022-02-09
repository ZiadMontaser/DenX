<?php

//load.php

require ('connect-mysql.php');

$obj = json_decode($_POST["myData"]);
$x1 = $obj->v;
$x3 = $obj->t;
$x4 = $obj->d;
$x5 = $obj->p;
$x6 = $obj->c;

$query = "INSERT INTO `complaints`(`Patient_ID`, `Visit_ID`, `Complaint`, `Frequency`, `Duration`) VALUES ($x5,$x1,\"$x3\",\"$x4\",\"$x6\") ON DUPLICATE KEY UPDATE Complaint=\"$x3\", Frequency=\"$x4\", Duration=\"$x6\";";

$statement = $dbcon->prepare($query);
echo $query;
$statement->execute();


?>