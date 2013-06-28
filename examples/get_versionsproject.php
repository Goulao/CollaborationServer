<?php
$statement = $pdo->prepare('SELECT datetime, versionsnummer FROM aenderung_track WHERE projekt=?');
$statement->bindValue(1, $_GET['project']);
$statement->execute();
if ($statement->errorCode() != '0000') {
    print '<pre>';
    var_dump($statement->queryString);
    var_dump($statement->debugDumpParams());
    var_dump($statement->errorInfo());
    print '</pre>';
} 

$test = $statement->fetchAll();

var_dump($test);
?>
