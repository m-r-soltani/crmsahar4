<?php

/*
require_once ("nusoap/nusoap.php");


$client = new nusoap_client("http://localhost/Siam/index.php?wsdl");

$input = array("first"=>"hello");

$result = $client->call("lib.test", array($input));

//var_dump($result);

var_dump($result);*/

//require_once("Db.php");

// Create connection
$conn = new mysqli("localhost", "amin", "Night123", "test");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$sql = "SELECT * FROM asd";
try{
$result = $conn->query($sql);

var_dump($result);

}catch(Exception $e){
    echo $e;
}
$conn->close();

//var_dump(Db::fetchall_Query("SELECT * FROM test"));