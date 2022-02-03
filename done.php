<?php

//load.php

require ('connect-mysql.php');

$data = array();
if(isset($_POST["vid"])){
    $x = $_POST["vid"];
    $query = "UPDATE `visits` SET `done`=1 WHERE id=$x;";

    $statement = $dbcon->prepare($query);

    $statement->execute();
}
?>