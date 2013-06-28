<?php

$statement = $pdo->prepare('SELECT p.name, UNIX_TIMESTAMP(p.erstellung) as creation, p.status, u.id as owner_id, u.benutzername '
                           . 'FROM projekte p LEFT JOIN login_daten u '
                           . 'ON p.benutzer_id=u.id WHERE p.id=?'
                           );
$statement->bindValue(1, $_GET['id']);
$statement->execute();
$projektDetails = $statement->fetch();

$json = array('id' => $_GET['id'], 'name' => $projektDetails['name'], 'owner' => array('user-id' => $projektDetails['owner_id'], 'user-name' => $projektDetails['benutzername']), 'creation' => $projektDetails['creation']);
print json_encode($json);
?>

