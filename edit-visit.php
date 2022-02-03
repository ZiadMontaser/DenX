<?php

//load.php

require ('connect-mysql.php');

$obj = json_decode($_POST["myData"]);
$x1 = $obj->vid;
$x3 = $obj->start;
$x4 = $obj->end;
$x5 = $obj->payment;
$x6 = $obj->Comment;

$query = "UPDATE `visits` SET `start`='$x3', `end`='$x4', `payment`='$x5', `Comment`='$x6' WHERE `id`=$x1";

$statement = $dbcon->prepare($query);
echo $query;
$statement->execute();


?>