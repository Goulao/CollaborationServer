<?php


$statement = $pdo->prepare('DELETE FROM projekte WHERE id=?');
$statement->bindValue(1, $_GET['project']);
$statement->execute();


print json_encode(array('status' => 'ok'));
?>
