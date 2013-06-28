<?php

// ne neue msql abfrage starten, und darüber versuchen da dran zu kommen!
/*$statement = $pdo->prepare('SELECT benutzername FROM login_daten WHERE id=?');
$statement->bindValue(1, $test['user']);
$statement->execute();
$benutzername = $statement->fetch();*/
    
    
$statement = $pdo->prepare('SELECT a.projekt, a.versionsnummer, UNIX_TIMESTAMP(a.datetime) as creation, a.groesse, u.id as owner_id, u.benutzername '
                           . 'FROM aenderung_track a LEFT JOIN login_daten u '
                           . 'ON a.user=u.id WHERE a.projekt=? ORDER BY a.versionsnummer DESC');
$statement->bindValue(1, $_GET['project']);
$statement->execute();
$aenderungen = $statement->fetchALL();
//var_dump($aenderungen);
if ($statement->errorCode() != '0000') {
    print '<pre>';
    var_dump($statement->queryString);
    var_dump($statement->debugDumpParams());
    var_dump($statement->errorInfo());
    print '</pre>';
} 




$json = array();
foreach ($aenderungen as $aenderung) {
    $json[] = array('pusher' => array ('id' => $aenderung['owner_id'], 'name' => $aenderung['benutzername']), 'datetime' => $aenderung['creation'], 'version' => $aenderung['versionsnummer'], 'groesse' => $aenderung['groesse']);
}

print json_encode($json);
/*
if ($test == NULL) {
print json_encode(array('status' => 'failed', 'reason' => 'Projeckt nicht vorhanden'));
    return;
} else {
    $json = array('pusher' => array ('id' => $test['user'], 'name' => $benutzername['benutzername']), 'datetime' => $test['UNIX_TIMESTAMP(datetime)'], 'version' => $test['versionsnummer']);
print json_encode($json);
}*/


?>
