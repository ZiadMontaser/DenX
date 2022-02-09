<?php

//load.php

require ('connect-mysql.php');

$obj = json_decode($_POST["myData"]);
$x0 = $obj->id;
$x1 = $obj->name;
$x2 = $obj->phone;
$x3 = $obj->sex;
$x4 = $obj->bdate;
$x5 = $obj->address;
$x6 = $obj->nation;
$x7 = $obj->comment;
$x8 = $obj->sn;

$query = "UPDATE `patients` SET `name`='$x1',`ssn`='$x2',`sex`='$x3',`birthdate`='$x4',`address`='$x5',`nationality`='$x6',`Comment`='$x7', `sn`='$x8' WHERE `id`='$x0'";

$statement = $dbcon->prepare($query);
$statement->execute();


?>