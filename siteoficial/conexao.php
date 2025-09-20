<?php

$host = "localhost";
$db = "crud_clientes";
$user = "root";
$pass = "";

$mysqli = new mysqli($host, $user, $pass, $db);
if($mysqli->connect_errno) {
    die("Falha na conexão com o banco de dados");
}
function formatar_data($data){
    return implode('/', array_reverse(explode('-', $data)));
}
function formatar_celular($celular) {
        $ddd = substr ($celular, 0, 2);
        $parte1 = substr ($celular, 2, 5);
        $parte2 = substr ($celular, 7);
        return"($ddd) $parte1-$parte2";
}