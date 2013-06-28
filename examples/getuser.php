<?php
if (isset($_GET['do'])
    && $_GET['do'] == 'getuser'
    /**
     * Achtung!
     * isset($_GET['user']) liefert immer einen boolean zur�ck.
     * $logindaten['benutzername'] hingegen einen String.
     * Das funktioniert so nicht und ist auch nicht gewollt.
     * Was du hier wirklich suchst, ist vermutlich ein row-count.
     */
   
   
) {
    /**
     * Fehlt hier nicht eine Bedingung?
     */
    $statement = $pdo->prepare(
        'SELECT id, benutzername AS user, vorname, nachname, e_mail_adresse, rolle FROM login_daten WHERE id=?'
    );
    $statement->bindValue(1, $_GET['user']);
    $statement->execute();

    if ($statement->errorCode() != '0000') {
        print '<pre>';
        var_dump($statement->queryString);
        var_dump($statement->debugDumpParams());
        var_dump($statement->errorInfo());
        print '</pre>';
    }
    
    /**
     * Was ist mit dem status? (siehe getuser.yml)
     */
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $result['status'] = 'existing'; 
    print json_encode($result);
} else {
    /**
     * Bitte die getuser.yml beachten. Der Status hier sollte nicht failed hei�en.
     */
    print json_encode(array('status' => 'missing'));
}
