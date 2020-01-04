<?php
$username = "root";
$password = "";
$connect = mysql_connect("localhost", $username, $password) or die("Failed Connection.");
$c = mysql_select_db("question") or die("Failed at selecting the DB");
?>