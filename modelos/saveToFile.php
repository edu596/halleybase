<?php
require "../config/Conexion.php";
include('MySqlBackup.php');



$arrayDbConf['host'] = DB_HOST;
$arrayDbConf['user'] = DB_USERNAME;
$arrayDbConf['pass'] = DB_PASSWORD;
$arrayDbConf['name'] = DB_NAME;


try {

  $bck = new MySqlBackupLite($arrayDbConf);
  $bck->backUp();
  $bck->setFileDir('../copia/');
  $bck->setFileName('backupFileNae.sql');
  $bck->saveToFile();

}
catch(Exception $e) {

  echo $e;

}

?>
