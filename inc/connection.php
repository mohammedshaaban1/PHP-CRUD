<?php
session_start();
$hostdb = "localhost";
$userdb = "root";
$passdb = "";
$namedb = "db-CRUD";
$con = mysqli_connect($hostdb, $userdb, $passdb, $namedb);
