<?php

//load.php

require ('connect-mysql.php');

$obj = json_decode($_POST["myData"]);
$x1 = $obj->v;
$x3 = $obj->t;
$x4 = $obj->d;
$x5 = $obj->p;
$x6 = $obj->c;

$query = "INSERT INTO `soc_hist`(`Patient_ID`, `Visit_ID`, `Family`, `soc`, `travel`) VALUES ($x5,$x1,\"$x3\",\"$x4\",\"$x6\") ON DUPLICATE KEY UPDATE family=\"$x3\", soc=\"$x4\", travel=\"$x6\";";

$statement = $dbcon->prepare($query);
echo $query;
$statement->execute();


?>