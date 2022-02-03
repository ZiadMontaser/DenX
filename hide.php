<?php

//load.php

require ('connect-mysql.php');

$data = array();
$obj = json_decode($_POST["myData"]);
$x = $obj->x;
$query = "UPDATE `staff` SET `hidden`=true WHERE `id`='$x';";
echo $query;
$statement = $dbcon->prepare($query);

$statement->execute();

?>