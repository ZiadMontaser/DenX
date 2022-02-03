<?php

//load.php

require ('connect-mysql.php');

$data = array();
if(isset($_POST['cr']) && isset($_POST['code']) && isset($_POST['box'])){
    $x1 = $_POST['cr'];
    $x2 = $_POST['code'];
    $x3 = $_POST['box'];
    $x4 = $_POST['name'];
    $query = "UPDATE `fd` SET `cr`='$x1',`code`='$x2',`box`='$x3',`name`='$x4';";

    $statement = $dbcon->prepare($query);

    $statement->execute();

    
}
?>