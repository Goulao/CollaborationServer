<?php


$statement = $pdo->prepare('SELECT benutzername, passwort ,rolle FROM login_daten WHERE id=? ');
$statement->bindValue(1, $_GET['user']);
$statement->execute();
$logindaten = $statement->fetch();
if (isset($logindaten['rolle']) 
    && ($logindaten['rolle'] != 'locked')) {
   } else {
    print 'false';
    return;
}
$statement = $pdo->prepare('SELECT name, erstellung FROM projekte');
$statement->execute();
$check = $statement->fetchALL();
if ($statement->errorCode() != '0000') {
            print '<pre>';
            var_dump($statement->queryString);
            var_dump($statement->debugDumpParams());
            var_dump($statement->errorInfo());
            print '</pre>';
}



$statement = $pdo->prepare('SELECT id, erstellung FROM projekte WHERE name=? ');
$statement->bindValue(1, $_GET['name']);
$statement->execute();
$check2 = $statement->fetchALL();

$reason = array();
if (strlen($_GET['name']) < 2) {
    $reason[] = 'Projektname ist zu kurz';
} 
if (count($check2) !=0 ) {
    $reason[] = 'Projektname ist bereits vergeben';
}

if (count ($reason) == 0 
    ) {
$statement = $pdo->prepare('INSERT INTO projekte (name, benutzer_Id, erstellung, status) VALUES (?,?,CURDATE(), ?)');
$statement->bindValue(1, $_GET['name']);
$statement->bindValue(2, $_GET['user']);
$statement->bindValue(3, 'open');
$statement->execute();
if ($statement->errorCode() != '0000') {
            print '<pre>';
            var_dump($statement->queryString);
            var_dump($statement->debugDumpParams());
            var_dump($statement->errorInfo());
            print '</pre>';
        } 
       

       $json = array('id' => $pdo->lastInsertId(), 'name' => $_GET['name'], 'owner' => array('id' => $_GET['user'], 'name' => $logindaten['benutzername']), 'creation' => time(), 'status' => 'ok');
       print json_encode($json);
} else {
    print json_encode(array('status' => 'failed', 'reason' => $reason));
    return;
}
?>

