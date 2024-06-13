<?php
$dsn = 'mysql:host=localhost;dbname=id22260447_bancoregister';
$user = 'id22260447_usuarioregister'; 
$password = '@liceLyan2024'; 

try {
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit; // interrompe a execução do script em caso de falha na conexão
}
?>
