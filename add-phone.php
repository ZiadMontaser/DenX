<?php

//load.php

require ('connect-mysql.php');

if(isset($_POST["phone"]) && isset($_POST["desc"])){
    $x1 = $_POST["phone"];
    $x3 = $_POST["desc"];

    $query = "INSERT INTO `phones`(`phone`, `description`) VALUES ('$x1','$x3')";

    $statement = $dbcon->prepare($query);
    echo $query;
    $statement->execute();
}

?>