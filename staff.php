<?php
 
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
 
// DB table to use
$table = 'staff';
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'id',      'dt' => 0 ),
    array( 'db' => 'name',    'dt' => 1 ),
    array( 'db' => 'password',     'dt' => 2 ),
    array( 'db' => 'type',   'dt' => 3 ),
    array( 'db' => 'sex',   'dt' => 4 ),
    array( 'db' => 'birthdate',   'dt' => 5 ),
    array( 'db' => 'address',   'dt' => 6 ),
    array( 'db' => 'nationality',   'dt' => 7 ),
    array( 'db' => 'phone',   'dt' => 8 ),
    array( 'db' => 'ssn',   'dt' => 9 ),
    array( 'db' => 'hidden',   'dt' => 10 )
);


// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => 'redpen_reusedPaper26296',
    'db'   => 'denx',
    'host' => 'localhost'
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'ssp.class.php' );
$where = "not type='1'";
$c = SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,$where );

for ($i = 0; $i < sizeof($c['data']); $i++){
    if($c['data'][$i][3] == '1') {
        $c['data'][$i][3] = 'admin';
    }
    if($c['data'][$i][3] == '2') {
        $c['data'][$i][3] = 'receptionist';
    }
    if($c['data'][$i][3] == '3') {
        $c['data'][$i][3] = 'dentist';
    }
    if($c['data'][$i][10] == '0') {
        $c['data'][$i][10] = 'no';
    }
    if($c['data'][$i][10] == '1') {
        $c['data'][$i][10] = 'yes';
    }
    
}
echo json_encode(
    $c
);