<?php
$mysqli = new mysqli("localhost", "root", "", "test");
if ($mysqli->connect_errno) 
{
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}
?>