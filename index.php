<?php
$pdo = new PDO(
    'mysql:host=localhost;dbname=auftrag',
    'root',
    '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
);

/**
 * Das l�sst sich sch�ner l�sen.
 *
 * 1. Du pr�fst jedes mal, ob $_GET['do'] gesetzt ist. Warum nicht einmal pr�fen
 *    und wenn es nicht gesetzt ist, aussteigen (exit)?
 * 2. Warum nicht ein Array nutzen, dass den in $_GET erwarteten Wert als
 *    Schl�ssel hat und die einzubindende Datei als Wert?
 */
$lookupTable = array( 
    'login' => 'examples/login.php',
    'create_user' => 'create_user.php',
    'getuser'   => 'getuser.php',
    'userlist' => 'userlist.php',
    'projecte' => 'projecte.php',
    'work_user'=> 'work_user.php',
    'changepwd' => 'changepwd.php'
);
 
 
if (isset($_GET['do'])
    && $_GET['do'] == 'login'
) {
    include 'examples/login.php';
} elseif (isset($_GET['do'])
    && $_GET['do'] == 'getuserlist'
) {
    include 'examples/userlist.php';
} elseif (isset($_GET['do'])
    && $_GET['do'] == 'get_projects'
) {
    include 'examples/get_projects.php';
} elseif (!isset($_GET['do'])
   || $_GET['do'] == 'create_user'
) {
    include 'examples/create_user.php';
} elseif (isset ($_GET['do'])
    && $_GET['do'] == 'getuser'
) {
    include 'examples/getuser.php';
} elseif (isset ($_GET['do'])
    && $_GET['do'] == 'work_user'
    ) {
    include 'examples/work_user.php';
} elseif (isset ($_GET['do'])
    && $_GET['do'] == 'changepwd'
    ) {
    include 'examples/changepwd.php';
} elseif (isset($_GET['do'])
    && $_GET['do'] == 'edit_project'
) {
    include 'examples/edit_project.php'; 
} elseif (isset($_GET['do'])
    && $_GET['do'] == 'create_projecte'
) {
    include 'examples/create_projecte.php'; 
} elseif (isset($_GET['do'])
    && $_GET['do'] == 'pull_project'
) {
    include 'examples/pull_project.php'; 
} elseif (isset($_GET['do'])
    && $_GET['do'] == 'push_project'
) {
    include 'examples/push_project.php'; 
}elseif (isset($_GET['do'])
    && $_GET['do'] == 'get_project'
) {
    include 'examples/get_project.php';
} elseif (isset($_GET['do'])
    && $_GET['do'] == 'get_versionsproject'
) {
    include 'examples/get_versionsproject.php';
    
} elseif (isset($_GET['do'])
    && $_GET['do'] == 'loeschen'
) {
    include 'examples/loeschen.php';
    
} elseif (isset($_GET['do'])
    && $_GET['do'] == 'project_loeschen'
) {
    include 'examples/project_loeschen.php';
    
}else {
    print 'fehler';
}
