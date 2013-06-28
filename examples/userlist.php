<?php
$statement = $pdo->prepare('SELECT benutzername, passwort, rolle FROM login_daten WHERE id=?');
$statement->bindValue(1, $_GET['user']);
$statement->execute();
$logindaten = $statement->fetch();

/**
 * Wozu die Pr�fung von $_GET['do']? Das hast du doch schon gepr�ft in der index.php
 * Achtung! isset($logindaten['user']) liefert einen boolean zur�ck, $logindaten['benutzername'] ist ein String.
 */
if (isset($_GET['do'])
    && $_GET['do'] == 'getuserlist'
    && isset($_GET['user']) == ($logindaten['benutzername'])
    && ($logindaten['rolle']) == 'admin'
) {
    $statement = $pdo->prepare('SELECT id, benutzername AS user FROM login_daten');
    $statement->execute();
    if ($statement->errorCode() != '0000') {
        print '<pre>';
        var_dump($statement->queryString);
        var_dump($statement->debugDumpParams());
        var_dump($statement->errorInfo());
        print '</pre>';
    }
    print json_encode($statement->fetchAll(PDO::FETCH_ASSOC));
} else {
    print json_encode(array('status' => 'failed'));
}
