<?php 

$host     = 'localhost';
$user     = 'root';
$db       = 'sistema-escolar';
$password = '';

try{
    $pdo = new PDO('mysql:host='.$host.';dbname='.$db.';charset-uft8',$user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
    'error: '.$e->getMessage();
}

?>