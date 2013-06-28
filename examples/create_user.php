<?php
/**
 * Wozu diese Pr�fung? Du bindest die Datei doch nur dann ein, wenn die passenden Daten �bergeben wurden.
 *
 * Noch dazu: Du machst eine �berpr�fung, und wenn die passt, machst du nichts, sondern nur, wenn sie nicht passt.
 * Warum nicht folgendes:
 *
 * if (!isset($_GET['do']
 *     || $_GET['do'] == 'create_user'
 * ) {
 *     print 'seite nicht verf�gbar';
 *     return;
 * }
 */
if (!isset($_GET['do'])
    || $_GET['do'] == 'create_user'
) {

} else {
    print 'seite nicht verfügbar';
    return;
}

$statement = $pdo->prepare('SELECT benutzername FROM login_daten WHERE benutzername=?');
$statement->bindValue(1, $_GET['name']);
$statement->execute();
/**
 * $check2 ist ein schlechter Name f�r eine Variable. Warum nicht $nameBereitsBenutzt ?
 */
$nameBereitsBenutzt = $statement->rowCount();

$statement = $pdo->prepare('SELECT e_mail_adresse FROM login_daten WHERE e_mail_adresse=?');
$statement->bindValue(1, $_GET['email']);
$statement->execute();
/**
 * Hier gilt das gleiche, warum nicht z.B. $emailsBereitsBenutzt ?
 */
$emailsBereitsBenutzt = $statement->rowCount();

$reason = array();

if (strlen($_GET['name']) < 2) {
    $reason[] = 'Benutzername ist zu kurz';
}
if (strlen($_GET['passwort']) < 3) {
    $reason[] = 'Passwort ist zu kurz';
}
if (strlen($_GET['vorname']) < 2) {
    $reason[] = 'Vorname ist zu kurz';
}
if (strlen($_GET['nachname']) < 2) {
    $reason[] = 'Nachname ist zu kurz';
}
if (strlen($_GET['email']) < 2) {
    $reason[] = 'Email ist zu kurz';
}

if ($nameBereitsBenutzt == 1) {
    $reason[] = 'Es existiert bereits ein Benutzer mit diesem Name.';
}
if ($emailsBereitsBenutzt == 1) {
    $reason[] = 'Es existiert bereits ein Benutzer mit dieser Email.';
}
if (count($reason) > 0) {
    print json_encode(array('status' => 'failed', 'reason' => $reason));
    return;
}
//eventuell sinnvoll: ein neues script zu erstellen, was fürs registieren verwendet werden kann, weil da noch keine übertragung möglich ist, 
//zudem ist der index 'rolle' ein knachpunkt, da ich nicht über $_GET arbeiten kann oder gar post, weil er direkt über das Insert gegeben wird!
if (count($reason) == 0) {
    $statement = $pdo->prepare(
        'INSERT INTO login_daten '
        . '(benutzername, passwort, vorname, nachname, e_mail_adresse, rolle) '
        . 'VALUES (?,?,?,?,?,?)'
    );
    $statement->bindValue(1, $_GET['name']);
    $statement->bindValue(2, $_GET['passwort']);
    $statement->bindValue(3, $_GET['vorname']);
    $statement->bindValue(4, $_GET['nachname']);
    $statement->bindValue(5, $_GET['email']);
    $statement->bindValue(6, $_GET['rolle']);
    $statement->execute();
    if ($statement->errorCode() != '0000') {
        print '<pre>';
        var_dump($statement->queryString);
        var_dump($statement->debugDumpParams());
        var_dump($statement->errorInfo());
        print '</pre>';
    }
} 
$statement = $pdo->prepare('SELECT id, FROM login_daten WHERE benutzername=? ');
$statement->bindValue(1, $_GET['name']);
$statement->execute();
/**
 * Warum hei�t die Variable $projektdaten?
 * Davon ab, schau mal hier, das sollte dir auch helfen und ist etwas eleganter:
 * http://de2.php.net/manual/de/pdo.lastinsertid.php
 */
$createUserDaten = $statement->fetch();

$json = array('id' => $pdo->lastInsertId(), 'name' => $_GET['name'], 'vorname' => $_GET['vorname'],
    'nachname' => $_GET['nachname'], 'email' => $_GET['email'], 'rolle' => $_GET['rolle'],
    'status' => 'created');
print json_encode($json);
