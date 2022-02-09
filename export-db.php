<?php
$date = date("j-n-Y");

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'denx';

$command = "'../../mysql/bin/mysqldump' --opt -h $dbhost -u $dbuser -p$dbpass $dbname > ./$dbname-$date.sql";
error_log($command);
exec($command);
?>