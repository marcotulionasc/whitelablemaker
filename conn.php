<?php
/*
* (c) COPYRIGHT 2024, MARCO NASCIMENTO
* CAMPINAS-SP, BRASIL
* ALL RIGHTS RESERVED - TODOS DIREITOS RESERVADOS
* CONFIDENTIAL, UNPUBLISHED PROPERTY OF MARCO NASCIMENTO
* PROPRIEDADE CONFIDENCIAL, NÃO PUBLICADA DE MARCO NASCIMENTO
*/

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}
?>
