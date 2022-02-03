<?php

//load.php

require ('connect-mysql.php');

$obj = json_decode($_POST["myData"]);
$x1 = $obj->v;
$x3 = $obj->t;
$x4 = $obj->d;
$x5 = $obj->p;
$x6 = $obj->c;

$query = "INSERT INTO `surgeries`(`visitId`, `tooth`, `surgery`, `price`, `Comment`) VALUES ('$x1','$x3','$x4','$x5','$x6')";

$statement = $dbcon->prepare($query);
echo $query;
$statement->execute();


?>