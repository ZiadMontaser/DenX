<?php

//load.php

require ('connect-mysql.php');

$data = array();
if(isset($_POST["vid"])){
    $x = $_POST["vid"];
    $query = "DELETE FROM `diagnosis` WHERE visitId='$x';";

    $statement = $dbcon->prepare($query);

    $statement->execute();
}
?>