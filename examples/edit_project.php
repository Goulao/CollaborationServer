<?php

$statement = $pdo->prepare('SELECT erstellung FROM projekte WHERE id=? ');
$statement->bindValue(1, $_GET['id']);
$statement->execute();
$datum = $statement->fetchColumn();


$statement = $pdo->prepare('SELECT benutzername FROM login_daten WHERE id=? ');
$statement->bindValue(1, $_GET['user']);
$statement->execute();
$benutzerRolle = $statement->fetch(PDO::FETCH_ASSOC);


$statement = $pdo->prepare('SELECT id, erstellung FROM projekte WHERE name=? AND id!=?');
$statement->bindValue(1, $_GET['name']);
$statement->bindValue(2, $_GET['id']);
$statement->execute();





if ($statement->rowCount() == 0) {
$statement = $pdo->prepare('UPDATE projekte SET name=?, status=? WHERE id=?');
$statement->bindValue(1, $_GET['name']);
$statement->bindValue(2, $_GET['status']);
$statement->bindValue(3, $_GET['id']);
$statement->execute();
if ($statement->errorCode() != '0000') {
            print '<pre>';
            var_dump($statement->queryString);
            var_dump($statement->debugDumpParams());
            var_dump($statement->errorInfo());
            print '</pre>';
}

$json = array('id' => $_GET['id'], 'name' => $_GET['name'], 'owner' => array ('id' => $_GET['user'], 'name' => $benutzerRolle['benutzername']), 'creation' => time(), 'status' => 'ok');
print json_encode($json);
} else {
     print json_encode(array('status' => 'failed', 'reason' => array('name bereits vergeben')));
   
}

?>
