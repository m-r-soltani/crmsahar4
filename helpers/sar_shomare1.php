<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
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
$table = 'bnm_sar_shomare';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case object
// parameter names
$columns = array(
    array( 'db' => 'id', 'dt' => 'id' ),
    array( 'db' => 'ostan', 'dt' => 'ostan' ),
    array( 'db' => 'shahr', 'dt' => 'shahr' ),
    array( 'db' => 'markaze_mokhaberati', 'dt' => 'markaze_mokhaberati' ),
    array( 'db' => 'sar_shomare', 'dt' => 'sar_shomare' )
);

// SQL server connection information
$sql_details = array(
    'user' => 'amin',
    'pass' => 'Night123',
    'db'   => 'saharertebat',
    'host' => 'localhost'
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( 'ssp.class.php' );
//$where = "name_sherkat = 'sdf'";
$where=false;
echo json_encode(
    SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns,$where )
);


