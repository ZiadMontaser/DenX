<?php

//load.php

require ('connect-mysql.php');

$obj = json_decode($_POST["myData"]);
$x1 = $obj->x1;
$x2 = $obj->x2;
$x3 = $obj->x3;
$x4 = $obj->x4;

$query = "DELETE FROM `prescription` WHERE medicine='$x1' and mg='$x2' and dose='$x3' and Comment='$x4'";

$statement = $dbcon->prepare($query);
echo $query;
$statement->execute();


?>