<?php

//load.php

require ('connect-mysql.php');

if(isset($_POST["phone"]) && isset($_POST["desc"])){
    $x1 = $_POST["phone"];
    $x3 = $_POST["desc"];

    $query = "DELETE FROM `phones` WHERE `phone`='$x1' and `description`='$x3'";

    $statement = $dbcon->prepare($query);
    echo $query;
    $statement->execute();
}

?>