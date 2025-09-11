<?php
$host = 'localhost';
$user = 'root';
$pass = '&tec77@info!';
$db   = 'sae_db';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_errno) {
    die("Falha na conexão: (" . $conn->connect_errno . ") " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');

function formatarCPF($cpf) {
    return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
}
