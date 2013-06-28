

<?php

// Erstellung von Überprüfungskritieren von Projekten!!
//Hinzufügen von Projekten vllt.
//MySQL-abfragen erstellen

$statement = $pdo->prepare('SELECT benutzername, passwort ,rolle FROM login_daten WHERE id=? ');
$statement->bindValue(1, $_GET['user']);
$statement->execute();
$logindaten = $statement->fetch();
//var_dump($logindaten['rolle']);
if (isset($logindaten['rolle']) 
    && ($logindaten['rolle'] != 'locked')) {
   } else {
    print 'false';
    return;
}

$where = '';
if ($_GET['status'] == 'open') {
    $where = "WHERE status = 'open' ";
} elseif ($_GET['status'] == 'closed') {
    $where = "WHERE status = 'closed'";
} elseif (!isset ($_GET['status'])) {
   $where = 'WHERE status = closed';
}
        
$statement = $pdo->prepare('SELECT p.id, p.name, UNIX_TIMESTAMP(p.erstellung) as creation, p.status, u.id as owner_id, u.benutzername '
                           . 'FROM projekte p LEFT JOIN login_daten u '
                           . 'ON p.benutzer_id=u.id '
                           . $where);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $key => $project) {
    $result[$key]['owner']['id'] = $project['owner_id'];
    unset($result[$key]['owner_id']);
    $result[$key]['owner']['name'] = $project['benutzername'];
    unset($result[$key]['benutzername']);
}
print json_encode($result);
if ($statement->errorCode() != '0000') {
            print '<pre>';
            var_dump($statement->queryString);
            var_dump($statement->debugDumpParams());
            var_dump($statement->errorInfo());
            print '</pre>';
}
/*print'<pre>';
var_dump($pdaten);
print'</pre>'; 

$projektdaten=array();
foreach ($pdaten as $projectInfos) {
    $projektdaten[] = $projectInfos;
}
print'<pre>';
var_dump($projektdaten[0]['id']);
print'</pre>';
$json = array('id' => $projektdaten['id'], 'projektname' => $projektdaten['name'], 'benutzername' => $logindaten['benutzername'], 'erstellungsdatum' => $projektdaten['erstellung'], 'status' => 'ok');
    print json_encode($json);
    */
?>



