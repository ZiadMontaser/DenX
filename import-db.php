<?php	  

$content = $_POST['content'];

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'redpen_reusedPaper26296';
$dbname = 'denx';

if (!file_exists('backups')) {
    mkdir('backups', 0777, true);
}

$backup_name = "backups/db-backup.sql";
file_put_contents($backup_name, $content);

$action = "\"../../mysql/bin/mysql.exe\" -u $dbuser -p $dbname --password=$dbpass < \"$backup_name\" ";
exec($action, $output, $return_var);

unlink($backup_name)

?>