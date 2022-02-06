<?php

//load.php

require ('connect-mysql.php');

$data = array();

$query = "SELECT `diagnosis` FROM `diagnosis` WHERE 1";

$statement = $dbcon->prepare($query);

$statement->execute();

$results = $statement->get_result();

$result = $results->fetch_all();

$myfile = fopen("src/dental_diagnosis_codes.txt", "r");
while(!feof($myfile)) {
    array_push($data,str_replace("\r\n","", fgets($myfile)));
}

foreach($result as $row)
{
    if(!is_in_array($row[0], $data)){
        array_push($data,$row[0]);
    }
}

echo json_encode($data);

function normlize_item($n) { return str_replace(' ', '', strtolower($n));}

function is_in_array($item, $array){

    foreach($array as $x)
    {
        if(normlize_item($item) == normlize_item($x)) return true;
    }
    return false;

}

?>