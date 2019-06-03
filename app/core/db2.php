<?php

$dbHost = "127.0.0.1";
// $dbUsername = "shadecom_admin";
// $dbPassword = "*?G0DHELPME?*";
$dbUsername = "root";
$dbPassword = "";
$dbName = "icms_cpc";

$prefix = "";

// Create connection
$con = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

//Create connection and select DB
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_error) {
    die("Unable to connect database: " . $db->connect_error);
}