<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'redpen_reusedPaper26296';
$dbname = 'denx';


if (!file_exists('backups')) {
    mkdir('backups', 0777, true);
}

$action = "\"../../mysql/bin/mysqldump.exe\" -u $dbuser -p $dbname --password=$dbpass > \"$backup_name\" ";
exec($action, $output, $return_var);
error_log($action);
$content = file_get_contents($backup_name);

ob_get_clean(); 
header('Content-Type: application/octet-stream');  
header("Content-Transfer-Encoding: Binary");  
header('Content-Length: '. (function_exists('mb_strlen') ? mb_strlen($content, '8bit'): strlen($content)) );
header("Content-disposition: attachment; filename=\"".$backup_name."\"");
?>