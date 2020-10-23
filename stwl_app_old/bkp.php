<?php
   $dbhost = 'localhost';
   $dbuser = 'root';
   $dbpass = '';
   $dbname = 'stwl_db';
   
   $backup_file = 'bkk.gz';
   $command = "mysqldump --opt -h ".$dbhost." -u ".$dbuser." -p ".$dbpass." ". "stwl_db | gzip > ".$backup_file;
   
   system($command);
?>