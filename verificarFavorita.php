<?php
session_start();

if (!isset($_SESSION['ID'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Usuário não logado.']);
    exit;
}

$conexao = new mysqli("localhost", "root", "", "now");

if ($conexao->connect_error) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Erro na conexão com o banco de dados.']);
    exit;
}

$id_memoria = isset($_GET['id_memoria']) ? (int)$_GET['id_memoria'] : 0;
$id_user = (int)$_SESSION['ID'];

// Log para depuração
error_log("Executando consulta para id_memoria: $id_memoria, id_user: $id_user");

$query = "SELECT favorita FROM album WHERE id_memoria = '{$id_memoria}' AND id_user = '{$id_user}'";
$result = $conexao->query($query);

if ($result === false) {
    // Log de erro da consulta
    error_log("Erro na consulta SQL: " . $conexao->error);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Erro na consulta SQL.']);
    exit;
}

$favorita = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['favorita'] : 0;

// Log do resultado
error_log("Resultado favorita: '{$favorita}'");

header('Content-Type: application/json');
echo json_encode(['success' => true, 'favorita' => (int)$favorita]);

$conexao->close();
?>
