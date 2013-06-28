<?php
if (isset($_GET['do'])
    && $_GET['do'] == 'changepwd') {
    
} else {
    print'seite nicht verfügbar';
    return;
} 

// das alte Passwort raussuchen und das neue mit dem vergleichen? das alte passowrt muss mit dem eingegebenen übereinstimmen nur dann update möglich

$statement = $pdo->prepare('SELECT passwort FROM login_daten WHERE id=?');
$statement->bindValue(1, $_GET['user']);
$statement->execute();
$pwd = $statement->fetchColumn();
/*if ($statement->errorCode() != '0000') {
    print '<pre>';
    var_dump($statement->queryString);
    var_dump($statement->debugDumpParams());
    var_dump($statement->errorInfo());
    print '</pre>';
}*/
$reason=array();

if ($pwd != $_GET['oldpwd']) {
    $reason[] = 'Altes Passwort ist nicht richtig!';
}
    
if (count($reason) == 0) {    
    
    $statement = $pdo->prepare('UPDATE login_daten SET passwort=? WHERE id=?');
    $statement->bindValue(1, $_GET['newpwd']);
    $statement->bindValue(2, $_GET['user']);
    $statement->execute();
    /*if ($statement->errorCode() != '0000') {
        print '<pre>';
        var_dump($statement->queryString);
        var_dump($statement->debugDumpParams());
        var_dump($statement->errorInfo());
        print '</pre>';
    }*/

    $json = array('status' => 'changed');
    print json_encode($json);
} else {
    $json = array('status' => 'failed', 'reason' => $reason);
    print json_encode($json);
}