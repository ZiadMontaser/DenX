<?php

//load.php

require ('connect-mysql.php');

$data = array();
if(isset($_POST["vid"])){
    $x = $_POST["vid"];
    $query = "SELECT * FROM prescription where visitid=$x ORDER BY id";

    $statement = $dbcon->prepare($query);

    $statement->execute();

    $results = $statement->get_result();

    $result = $results->fetch_all();

    foreach($result as $row)
    {
        $data[] = array(
            0   => $row[2],
            1   => $row[3],
            2   => $row[4],
            3   => $row[6]
        );
    }

    echo json_encode($data);
}
?>