<?php
$ts_pw = posix_getpwuid(posix_getuid());
$ts_mycnf = parse_ini_file($ts_pw['dir'] . "/replica.my.cnf");

$mysqli = new mysqli('tools-db', $ts_mycnf['user'], $ts_mycnf['password'], "p50380g50454__wikigini");
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}
