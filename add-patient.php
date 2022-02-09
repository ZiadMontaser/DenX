<?php

//load.php

require ('connect-mysql.php');

$obj = json_decode($_POST["myData"]);
$x1 = $obj->name;
$x3 = $obj->ssn;
$x4 = $obj->phone;
$x5 = $obj->comment;
$y1 = $obj->sex;
$y3 = $obj->bdate;
$y4 = $obj->address;
$y5 = $obj->nationality;
$y6 = $obj->sn;

$query = "INSERT INTO `patients`(`name`, `ssn`,  `Comment`, `sex`, `birthdate`, `address`, `nationality`, `sn`) VALUES ('$x1','$x3','$x5', '$y1','$y3','$y4','$y5', '$y6')";
$statement = $dbcon->prepare($query);
$statement->execute();


$query = "SELECT id FROM patients WHERE ssn = '$x3';";
$statement = $dbcon->prepare($query);
$statement->execute();
$results = $statement->get_result();
$result = $results->fetch_all();
echo json_encode($result[0][0]);

?>