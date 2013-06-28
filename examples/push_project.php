<?php
$statement = $pdo->prepare('SELECT rolle FROM login_daten WHERE id=?');
$statement->bindValue(1, $_GET['user']);
$statement->execute();
$benutzerRolle = $statement->fetchColumn(); 

$statement = $pdo->prepare('SELECT status FROM projekte WHERE id=?');
$statement->bindValue(1, $_GET['project']);
$statement->execute();
$projektStatus = $statement->fetchColumn(); 

$statement = $pdo->prepare('SELECT MAX(versionsnummer) FROM aenderung_track WHERE projekt = ?');
$statement->bindValue(1, $_GET['project']);
$statement->execute();
if ($statement->errorCode() != '0000') {
    print '<pre>';
    var_dump($statement->queryString);
    var_dump($statement->debugDumpParams());
    var_dump($statement->errorInfo());
    print '</pre>';
}
$lastVersionNumber = $statement->fetchColumn();
$nextVersionNumber = $lastVersionNumber + 1;


$statement = $pdo->prepare('SELECT versionsnummer FROM aenderung_track WHERE projekt = ? ORDER BY versionsnummer DESC LIMIT 3,1000');
$statement->bindValue(1, $_GET['project']);
$statement->execute();
$versionen = $statement->fetchAll();




$reason = array();
if ($benutzerRolle == 'locked') {
    $reason[] = 'Sie dürfen noch nichts bearbeiten';
}
if ($projektStatus != 'open') {
      $reason[] = 'Auf das Projekt kann nicht zugegriffen werden.';
}

if (count($reason) > 0) {
    print json_encode(array('status' => 'failed', 'reason' => $reason));
    return;
}

$versions2Delete = array();
foreach ($versionen as $version) { 
    $statement = $pdo->prepare('DELETE From aenderung_track WHERE projekt=? AND versionsnummer=?');
    $statement->bindValue(1, $_GET['project']);
    $statement->bindValue(2, $version['versionsnummer']);
    $statement->execute();
    $versions2Delete[] = $version['versionsnummer'];
}



$statement = $pdo->prepare('INSERT INTO aenderung_track (user, projekt, datetime, versionsnummer, groesse) VALUE (?,?,NOW(), ?, ?)');
$statement->bindValue(1, $_GET['user']);
$statement->bindValue(2, $_GET['project']);
$statement->bindValue(3, $nextVersionNumber);
$statement->bindValue(4, $_GET['groesse']);
$statement->execute();
if ($statement->errorCode() != '0000') {
    print '<pre>';
    var_dump($statement->queryString);
    var_dump($statement->debugDumpParams());
    var_dump($statement->errorInfo());
    print '</pre>';
}

print json_encode(array('status' => 'ok', 'version' => $nextVersionNumber, 'delete' => $versions2Delete));