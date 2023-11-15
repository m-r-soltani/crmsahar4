<?php defined('__ROOT__') or exit('No direct script access allowed');
class Db
{
    private static $instance = null;
    public function __construct($localhost = null, $dbname = null, $username = null, $password = null)
    {
        if (self::$instance === null) {
            $localhost = $localhost ? $localhost : __HOSTNAME__;
            $dbname    = $dbname ? $dbname : __DATABASE__;
            $username  = $username ? $username : __USERNAME__;
            $password  = $password ? $password : __PASSWORD__;
            //$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            try {
                return self::$instance = new pdo('mysql:host=' . $localhost . ';dbname=' . $dbname . ';charset=utf8',
                    $username,
                    $password,
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_EMULATE_PREPARES, false)
                    //array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
                );
            } catch (PDOException $ex) {
                die(json_encode(array($ex, 'message' => 'مشکل در برقراری ارتباط با پایگاه داده!')));
            }
        } else {
            return self::$instance;
        }

    }

    private static function sql_connect($localhost = null, $dbname = null, $username = null, $password = null)
    {
        if (self::$instance === null) {
            $localhost = $localhost ? $localhost : __HOSTNAME__;
            $dbname    = $dbname ? $dbname : __DATABASE__;
            $username  = $username ? $username : __USERNAME__;
            $password  = $password ? $password : __PASSWORD__;
            //$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            try {
                self::$instance = new pdo('mysql:host=' . $localhost . ';dbname=' . $dbname . ';charset=utf8',
                    $username,
                    $password,
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_EMULATE_PREPARES, false)
                    //array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
                );
            } catch (PDOException $ex) {
                die(json_encode(array($ex, 'message' => 'مشکل در برقراری ارتباط با پایگاه داده!')));
            }
        } else {
            return self::$instance;
        }

    }
    public function __clone()
    {
        throw new Exception("Can't clone a singleton");
    }

    public static function secure_update_array($sql, $params, $connection_destroy = true)
    {
        try {
            if (self::$instance === null) {
                self::sql_connect();
            }
            $arr = array();
            if ($params) {
                $keys = array_keys($params);
                try {
                    $sth = self::$instance->prepare($sql);
                    for ($i = 0; $i < count($keys); $i++) {
                        $sth->bindValue(':' . $keys[$i], $params[$keys[$i]]);
                    }
                    //todo... check below
                    //execute($arr);
                    $sth->execute($params);
                    $result = $sth->rowCount();
                    if ($connection_destroy) {
                        self::$instance = null;
                    }
                    if($result){
                        return true;
                    }else{
                        return false;
                    }

                } catch (PDOException $e) {
                    return $e;
                }
            }
        } catch (Throwable $e) {
            Helper::Exc_Error_Debug($e, true, '', false);
        }
    }
    public static function secure_insert_array($sql, $params, $connection_destroy = true)
    {
        try {
            $arr = array();
            if (self::$instance === null) {
                self::sql_connect();
            }
            if ($params) {
                $keys = array_keys($params);
                for ($i = 0; $i < count($keys); $i++) {
                    $arr[$i] = $params[$keys[$i]];
                }
                $result = self::$instance->prepare($sql);

                for ($i = 0; $i < count($keys); $i++) {
                    $result->bindValue($i + 1, $keys[$i]);
                }
                if (!$result = $result->execute($arr)) {
                    if ($connection_destroy) {
                        self::$instance = null;
                    }
                    return false;
                }
                $last_insert_id = self::$instance->lastInsertId();
                if ($connection_destroy) {
                    self::$instance = null;
                }
                return $last_insert_id;
                // return $result;
            }
        } catch (Throwable $e) {
            echo $res = Helper::Exc_Error_Debug($e, true, '', true);
            die();
        }
    }

    public static function secure_fetchall($sql, $params, $fetch_assoc = true, $connection_destroy = true)
    {
        if (self::$instance === null) {
            self::sql_connect();
        }
        $arr = array();
        if ($params) {
            $keys = array_keys($params);
            for ($i = 0; $i < count($keys); $i++) {
                $arr[$i] = $params[$keys[$i]];
            }
            try {
                $sth = self::$instance->prepare($sql);
                if (!$sth->execute($arr)) {
                    if ($connection_destroy) {
                        self::$instance = null;
                    }
                    return false;
                }
                if ($fetch_assoc) {
                    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $result = $sth->fetchAll();
                }
                if ($connection_destroy) {
                    self::$instance = null;
                }
                return $result;
            } catch (PDOException $e) {
                return $e;
            }
        } else {
            return false;
        }
    }
    public static function secure_delete($sql, $param, $connection_destroy = true)
    {
        if ($param && $sql) {
            if (self::$instance === null) {
                self::sql_connect();
            }
            try {
                $sth    = self::$instance->prepare($sql);
                $sth->bindValue(':id',$param,PDO::PARAM_INT);
                $sth->execute();
                $result = $sth->rowCount();
                if ($connection_destroy) {
                    self::$instance = null;
                }
                if($result){
                    return true;
                }else{
                    return false;
                }        
            } catch (PDOException $e) {
                return $e;
            }
        } else {
            return false;
        }
    }
    public static function justexecute($sql, $connection_destroy = true)
    {
        try {
            if (self::$instance === null) {
                self::sql_connect();
            }
            $result = self::$instance->prepare($sql);
            //$result->execute();
            if (!$result->execute()) {
                if ($connection_destroy) {
                    self::$instance = null;
                }
                return false;
            } else {
                if ($connection_destroy) {
                    self::$instance = null;
                }
                return true;
            }

        } catch (PDOException $e) {
            return $e;
        }
    }
    public static function fetchall_Query($sql, $fetch_assoc = true, $connection_destroy = true)
    {
        if (self::$instance === null) {
            self::sql_connect();
        }
        try {
            $result = self::$instance->prepare($sql);
            $result->execute();
            if ($fetch_assoc) {
                $rows = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $rows = $result->fetchAll();
            }
            // $rows     = $result->fetchAll();

            if ($connection_destroy) {
                self::$instance = null;
            }
            return $rows;
        } catch (PDOException $e) {
            return false;
        }

    }
    public static function Get_Column_Names($table, $connection_destroy = true)
    {
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = :table";
        try {
            if (self::$instance === null) {
                self::sql_connect();
            }
            $stmt = self::$instance->prepare($sql);
            $stmt->bindValue(':table', $table, PDO::PARAM_STR);
            $stmt->execute();
            $output = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $output[] = $row['COLUMN_NAME'];
            }
            if ($connection_destroy) {
                self::$instance = null;
            }
            return $output;
        } catch (PDOException $pe) {
            trigger_error('Could not connect to MySQL database. ' . $pe->getMessage(), E_USER_ERROR);
        }
    }
    public static function fetch_assoc($sql, $connection_destroy = true)
    {
        try {
            if (self::$instance === null) {
                self::sql_connect();
            }
            $result = self::$instance->prepare($sql);
            $result->execute();
            $rows = $result->fetchAll(PDO::FETCH_ASSOC);
            if ($connection_destroy === true) {
                self::$instance = null;
            }
            return $rows;
        } catch (PDOException $e) {
            return false;
        }
    }
    /**
     * Create the data output array for the DataTables rows
     *
     *  @param  array $columns Column information array
     *  @param  array $data    Data from the SQL get
     *  @return array          Formatted data in a row based format
     */
    public static function data_output($columns, $data)
    {
        $out = array();

        for ($i = 0, $ien = count($data); $i < $ien; $i++) {
            $row = array();

            for ($j = 0, $jen = count($columns); $j < $jen; $j++) {
                $column = $columns[$j];

                // Is there a formatter?
                if (isset($column['formatter'])) {
                    $row[$column['dt']] = $column['formatter']($data[$i][$column['db']], $data[$i]);
                } else {
                    $row[$column['dt']] = $data[$i][$columns[$j]['db']];
                }
            }

            $out[] = $row;
        }

        return $out;
    }
    /**
     * Paging
     *
     * Construct the LIMIT clause for server-side processing SQL query
     *
     *  @param  array $request Data sent to server by DataTables
     *  @param  array $columns Column information array
     *  @return string SQL limit clause
     */
    public static function limit($request, $columns)
    {
        $limit = '';

        if (isset($request['start']) && $request['length'] != -1) {
            $limit = "LIMIT " . intval($request['start']) . ", " . intval($request['length']);
        }

        return $limit;
    }
    /**
     * Ordering
     *
     * Construct the ORDER BY clause for server-side processing SQL query
     *
     *  @param  array $request Data sent to server by DataTables
     *  @param  array $columns Column information array
     *  @return string SQL order by clause
     */
    public static function order($request, $columns)
    {
        $order = '';

        if (isset($request['order']) && count($request['order'])) {
            $orderBy   = array();
            $dtColumns = self::pluck($columns, 'dt');

            for ($i = 0, $ien = count($request['order']); $i < $ien; $i++) {
                // Convert the column index into the column data property
                $columnIdx     = intval($request['order'][$i]['column']);
                $requestColumn = $request['columns'][$columnIdx];

                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column    = $columns[$columnIdx];

                if ($requestColumn['orderable'] == 'true') {
                    $dir = $request['order'][$i]['dir'] === 'asc' ?
                    'ASC' :
                    'DESC';

                    $orderBy[] = '`' . $column['db'] . '` ' . $dir;
                }
            }

            $order = 'ORDER BY ' . implode(', ', $orderBy);
        }

        return $order;
    }
    /**
     * Searching / Filtering
     *
     * Construct the WHERE clause for server-side processing SQL query.
     *
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here performance on large
     * databases would be very poor
     *
     *  @param  array $request Data sent to server by DataTables
     *  @param  array $columns Column information array
     *  @param  array $bindings Array of values for PDO bindings, used in the
     *    sql_exec() function
     *  @return string SQL where clause
     */
    public static function filter($request, $columns, &$bindings, $default = false)
    {
        $globalSearch = array();
        $columnSearch = array();
        $dtColumns    = self::pluck($columns, 'dt');

        if (isset($request['search']) && $request['search']['value'] != '') {
            $str = $request['search']['value'];

            for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
                $requestColumn = $request['columns'][$i];
                $columnIdx     = array_search($requestColumn['data'], $dtColumns);
                $column        = $columns[$columnIdx];

                if ($requestColumn['searchable'] == 'true') {
                    $binding        = self::bind($bindings, '%' . $str . '%', PDO::PARAM_STR);
                    $globalSearch[] = "`" . $column['db'] . "` LIKE " . $binding;
                }
            }
        }

        // Individual column filtering
        for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
            $requestColumn = $request['columns'][$i];
            $columnIdx     = array_search($requestColumn['data'], $dtColumns);
            $column        = $columns[$columnIdx];

            $str = $requestColumn['search']['value'];

            if ($requestColumn['searchable'] == 'true' &&
                $str != '') {
                $binding        = self::bind($bindings, '%' . $str . '%', PDO::PARAM_STR);
                $columnSearch[] = "`" . $column['db'] . "` LIKE " . $binding;
            }
        }

        // Combine the filters into a single string
        $where = '';

        if (count($globalSearch)) {
            $where = '(' . implode(' OR ', $globalSearch) . ')';
        }

        if (count($columnSearch)) {
            $where = $where === '' ?
            implode(' AND ', $columnSearch) :
            $where . ' AND ' . implode(' AND ', $columnSearch);
        }

        if ($default !== false) {
            if ($where !== '') {
                $where = $default . ' AND ' . $where;
            } else {
                $where = $default;
            }

        }
        if ($where !== '') {
            $where = 'WHERE ' . $where;
        }

        return $where;
    }
    /**
     * Perform the SQL queries needed for an server-side processing requested,
     * utilising the helper functions of this class, limit(), order() and
     * filter() among others. The returned array is ready to be encoded as JSON
     * in response to an SSP request, or can be modified if needed before
     * sending back to the client.
     *
     *  @param  array $request Data sent to server by DataTables
     *  @param  array $sql_details SQL connection details - see sql_connect()
     *  @param  string $table SQL table to query
     *  @param  string $primaryKey Primary key of the table
     *  @param  array $columns Column information array
     *  @param  string $default Default Where clause string
     *  @return array          Server-side processing response array
     */
    public static function simple($request, $table, $primaryKey, $columns, $default = false)
    {
        if (self::$instance === null) {
            self::sql_connect();
        }
        $bindings = array();
        // $db       = self::sql_connect();

        // Build the SQL query string from the request
        $limit = self::limit($request, $columns);
        $order = self::order($request, $columns);
        $where = self::filter($request, $columns, $bindings, $default);

        // Main query to actually get the data
        $data = self::sql_exec($bindings,
            "SELECT SQL_CALC_FOUND_ROWS `" . implode("`, `", self::pluck($columns, 'db')) . "`
			 FROM $table
			 $where
			 $order
			 $limit"
        );

        // Data set length after filtering
        $resFilterLength = self::sql_exec("SELECT FOUND_ROWS()");
        $recordsFiltered = $resFilterLength[0][0];

        // Total data set length
        $resTotalLength = self::sql_exec(
            "SELECT COUNT(`{$primaryKey}`)
			 FROM   $table " . ($default !== false ? ' WHERE ' . $default : '')
        );
        $recordsTotal = $resTotalLength[0][0];

        /*
         * Output
         */
        self::$instance = null;
        return array(
            "draw"            => intval($request['draw']),
            "recordsTotal"    => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data"            => self::data_output($columns, $data),
        );
    }
    /**
     * Execute an SQL query on the database
     *
     * @param  resource $db  Database handler
     * @param  array    $bindings Array of PDO binding values from bind() to be
     *   used for safely escaping strings. Note that this can be given as the
     *   SQL query string if no bindings are required.
     * @param  string   $sql SQL query to execute.
     * @return array         Result from the query (all rows)
     */
    public static function sql_exec($bindings, $sql = null)
    {
        // Argument shifting
        if ($sql === null) {
            $sql = $bindings;
        }

        $stmt = self::$instance->prepare($sql);
        //echo $sql;

        // Bind parameters
        if (is_array($bindings)) {
            for ($i = 0, $ien = count($bindings); $i < $ien; $i++) {
                $binding = $bindings[$i];
                $stmt->bindValue($binding['key'], $binding['val'], $binding['type']);
            }
        }

        // Execute
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            self::fatal("An SQL error occurred: " . $e->getMessage());
        }

        // Return all
        return $stmt->fetchAll();
    }
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Internal methods
     */
    /**
     * Throw a fatal error.
     *
     * This writes out an error message in a JSON string which DataTables will
     * see and show to the user in the browser.
     *
     * @param  string $msg Message to send to the client
     */
    public static function fatal($msg)
    {
        echo json_encode(array(
            "error" => $msg,
            "Error" => $msg,
        ));

        exit(0);
    }
    /**
     * Create a PDO binding key which can be used for escaping variables safely
     * when executing a query with sql_exec()
     *
     * @param  array &$a    Array of bindings
     * @param  *      $val  Value to bind
     * @param  int    $type PDO field type
     * @return string       Bound key to be used in the SQL where this parameter
     *   would be used.
     */
    public static function bind(&$a, $val, $type)
    {
        $key = ':binding_' . count($a);

        $a[] = array(
            'key'  => $key,
            'val'  => $val,
            'type' => $type,
        );

        return $key;
    }
    /**
     * Pull a particular property from each assoc. array in a numeric array,
     * returning and array of the property values from each item.
     *
     *  @param  array  $a    Array to get data from
     *  @param  string $prop Property to read
     *  @return array        Array of property values
     */
    public static function pluck($a, $prop)
    {
        $out = array();

        for ($i = 0, $len = count($a); $i < $len; $i++) {
            $out[] = $a[$i][$prop];
        }

        return $out;
    }
    /*DATATABLE*/
}
