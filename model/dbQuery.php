<?php
require_once('model/db.php');

// gör mindre specific databas som argument?
function queryUser ($user) {

// query string
$sql = "SELECT $user from user;";
// query
$result = mysqli_query($conn, $sql);
// query to array
$row = mysqli_fetch_assoc($result);
}


