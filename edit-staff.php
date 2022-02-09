<?php

//load.php

require ('connect-mysql.php');

$obj = json_decode($_POST["myData"]);
$x0 = $obj->id;
$x1 = $obj->x1;
$x2 = $obj->x2;
$x3 = $obj->x4;
$x4 = $obj->x5;
$x5 = $obj->x6;
$x6 = $obj->x7;
$x7 = $obj->x8;
$x8 = $obj->x9;

$query = "UPDATE `staff` SET `name`='$x1',`password`='$x2',`sex`='$x3',`birthdate`='$x4',`address`='$x5',`nationality`='$x6',`phone`='$x7',`ssn`='$x8' WHERE `id`='$x0'";
echo $query;
$statement = $dbcon->prepare($query);
$statement->execute();


?>