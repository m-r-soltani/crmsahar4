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
if(isset($_POST['filter'])){
    $terminal=$_POST['filter'];
    if($terminal!=''){
    $where = "terminal = '$terminal'";
    }else{

        $where=false;
    }
$table = 'bnm_port';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case object
// parameter names
$columns = array(
    array( 'db' => 'id', 'dt' => 'id' ),
    array( 'db' => 'etesal', 'dt' => 'etesal' ),
    array( 'db' => 'terminal', 'dt' => 'terminal' ),
    array( 'db' => 'tighe', 'dt' => 'tighe' ),
    array( 'db' => 'port', 'dt' => 'port' ),
    array( 'db' => 'kart', 'dt' => 'kart' ),
    array( 'db' => 'dslam', 'dt' => 'dslam' ),
    array( 'db' => 'adsl_vdsl', 'dt' => 'adsl_vdsl' ),
    array( 'db' => 'radif', 'dt' => 'radif' ),
    array( 'db' => 'telephone', 'dt' => 'telephone' ),
    array( 'db' => 'status', 'dt' => 'status' ),
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

// $where=false;
echo json_encode(
    SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns,$where )
);
}


