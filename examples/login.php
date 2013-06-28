<?php
$statement = $pdo->prepare(
        'SELECT benutzername, id, passwort, vorname, nachname, e_mail_adresse, rolle FROM login_daten 
        WHERE benutzername=? AND passwort=?'
    );
    $statement->bindValue(1, $_GET['user']);
    $statement->bindValue(2, $_GET['pwd']);
    $statement->execute();
    $result = $statement->fetch();
    
/**
 * Wozu die Pr�fung von $_GET['do']? Das hast du doch schon gepr�ft in der index.php
 * Achtung! isset($logindaten['password']) liefert einen boolean zur�ck, $_GET['pwd'] ist ein String.
 * Was du hier suchst, ist vermutlich $statement->rowCount()
 */
if (isset($_GET['do']) && $_GET['do'] == 'login' 
    && isset ($result['benutzername'])
    && isset ($result['passwort'])
    && $result['rolle'] != 'locked'
) {
   

    /**
     * Das hier ist fast die gleiche Query wie oben. Das geht eleganter.
     */
    
    
    $json = array(
        'benutzername' => $result['benutzername'],
        'id'           => $result['id'],
        'vorname'      => $result['vorname'],
        'nachname'     => $result['nachname'],
        'email'        => $result['e_mail_adresse'],
        'rolle'        => $result['rolle'],
        'status'       => 'ok'
    );
    print json_encode($json);
} else {
    print json_encode(array('status' => 'failed'));
}
