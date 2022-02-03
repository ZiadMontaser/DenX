<?php

//load.php

require ('connect-mysql.php');

$obj = json_decode($_POST["myData"]);
$x1 = $obj->vid;

$query = "DELETE FROM `visits` WHERE `id`=$x1";

$statement = $dbcon->prepare($query);
echo $query;
$statement->execute();


?>