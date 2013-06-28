<?php

$statement = $pdo->prepare('SELECT versionsnummer FROM aenderung_track WHERE projekt=?');
$statement->bindValue(1, $_GET['project']);
$statement->execute();
if ($statement->errorCode() != '0000') {
    print '<pre>';
    var_dump($statement->queryString);
    var_dump($statement->debugDumpParams());
    var_dump($statement->errorInfo());
    print '</pre>';
}

if ($_GET['project'] && isset ($_GET['versionsnummer'])
 ) {
$statement = $pdo->prepare('DELETE From aenderung_track WHERE projekt=? AND versionsnummer=?');
$statement->bindValue(1, $_GET['project']);
$statement->bindValue(2, $_GET['versionsnummer']);
$statement->execute();
if ($statement->errorCode() != '0000') {
    print '<pre>';
    var_dump($statement->queryString);
    var_dump($statement->debugDumpParams());
    var_dump($statement->errorInfo());
    print '</pre>';
} 

} elseif ($_GET['project'] && !isset ($_GET['versionnummer'])) {
$statement = $pdo->prepare('DELETE From aenderung_track WHERE projekt=?');
$statement->bindValue(1, $_GET['project']);
$statement->execute();
if ($statement->errorCode() != '0000') {
    print '<pre>';
    var_dump($statement->queryString);
    var_dump($statement->debugDumpParams());
    var_dump($statement->errorInfo());
    print '</pre>';
}
}

print json_encode(array('status' => 'ok'));
?>
