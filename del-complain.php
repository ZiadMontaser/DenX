<?php

//load.php

require ('connect-mysql.php');

$obj = json_decode($_POST["myData"]);
$x1 = $obj->x1;
$x2 = $obj->x2;
$x3 = $obj->x3;

$query = "DELETE FROM `complaints` WHERE Patient_ID='$x1' and Visit_ID='$x2' and Complaint='$x3'";

$statement = $dbcon->prepare($query);
echo $query;
$statement->execute();


?>