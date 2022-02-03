<?php

//load.php

require ('connect-mysql.php');

$obj = json_decode($_POST["myData"]);
$x1 = $obj->patientId;
$x2 = $obj->dentistId;
$x3 = $obj->start;
$x4 = $obj->end;
$x5 = $obj->payment;
$x6 = $obj->Comment;

$query = "INSERT INTO `visits`(`patientId`, `dentistId`, `start`, `end`, `payment`, `Comment`) VALUES ('$x1','$x2','$x3','$x4','$x5','$x6')";

$statement = $dbcon->prepare($query);

$statement->execute();


?>