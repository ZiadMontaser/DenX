<?php
$date = date('Y-m-d');
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'redpen_reusedPaper26296';
$dbname = 'denx';
$backup_name = "backups/$dbname-$date.sql";

if (!file_exists('backups')) {
    mkdir('backups', 0777, true);
}

$action = "\"../../mysql/bin/mysqldump.exe\" -u $dbuser -p $dbname --password=$dbpass > \"$backup_name\" ";
exec($action, $output, $return_var);
$content = file_get_contents($backup_name);
error_log($content);

ob_get_clean(); header('Content-Type: application/octet-stream');  header("Content-Transfer-Encoding: Binary");  header('Content-Length: '. (function_exists('mb_strlen') ? mb_strlen($content, '8bit'): strlen($content)) );    header("Content-disposition: attachment; filename=\"$dbname-$date.sql\""); 
echo $content; exit;

// ob_get_clean(); 
// header('Content-Type: application/octet-stream');  
// header("Content-Transfer-Encoding: Binary");  
// header('Content-Length: '. (function_exists('mb_strlen') ? mb_strlen($content, '8bit'): strlen($content)) );
// header("Content-disposition: attachment; filename=\"$dbname-$date.sql\"");
?>