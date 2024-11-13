<?php

$conn=new mysqli("localhost","root","","iwt");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>


