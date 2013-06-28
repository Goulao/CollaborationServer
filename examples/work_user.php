<?php
$statement = $pdo->prepare('SELECT rolle FROM login_daten WHERE id=?');
$statement->bindValue(1, $_GET['user']);
$statement->execute();
$benutzerRolle = $statement->fetch();
 if ($benutzerRolle['rolle'] == 'admin') {
     
 } else {
     print'seite nicht verfügbar';
     return;
 }
$statement = $pdo->prepare('SELECT benutzername FROM login_daten WHERE benutzername=? AND id!=?');
$statement->bindValue(1, $_GET['name']);
$statement->bindValue(2, $_GET['id']);
$statement->execute();
$nameBereitsBenutzt = $statement->rowCount();

$statement = $pdo->prepare('SELECT e_mail_adresse FROM login_daten WHERE e_mail_adresse=? AND id!=?');
$statement->bindValue(1, $_GET['email']);
$statement->bindValue(2, $_GET['id']);
$statement->execute();
$emailsBereitsBenutzt = $statement->rowCount();


 $reason = array();
 if ($nameBereitsBenutzt == 1
     ) {
    $reason[] = 'Es existiert bereits ein Benutzer mit diesem Name.';
}
if ($emailsBereitsBenutzt == 1) {
    $reason[] = 'Es existiert bereits ein Benutzer mit dieser Email.';
} 
if (count($reason) > 0) {
    print json_encode(array('status' => 'failed', 'reason' => $reason));
    return;
}

if (count($reason) == 0) 
{
 $statement = $pdo->prepare('UPDATE login_daten SET benutzername=?, vorname=?, nachname=?, `e_mail_adresse`=?, rolle=? WHERE id=?');
 $statement->bindValue(1, $_GET['name']);
 $statement->bindValue(2, $_GET['vorname']);
 $statement->bindValue(3, $_GET['nachname']);
 $statement->bindValue(4, $_GET['email']);
 $statement->bindValue(5, $_GET['rolle']);
 $statement->bindValue(6, $_GET['id']);
 $statement->execute();
 
 $json = array('id' => $pdo->lastInsertId(), 'name' => $_GET['name'], 'vorname' => $_GET['vorname'],
    'nachname' => $_GET['nachname'], 'email' => $_GET['email'], 'rolle' => $_GET['rolle'],
    'status' => 'changed');
print json_encode($json);
} else  {  
    print json_encode(array('status' => 'missing'));
}
?>
