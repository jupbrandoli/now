<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['ID'])) {
    header("location: index.php");
    exit;
}

// Conexão com o banco de dados
$conexao = new mysqli("localhost", "root", "", "now");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

$query = "SELECT m.id, m.titulo, m.descricao, m.data, m.foto, m.sentimento 
        FROM memoria m 
        LEFT JOIN album a ON m.id = a.id_memoria AND a.id_user = $usuario_id
        WHERE a.favorita IS NOT NULL;"

// Executa a consulta
$result = $conexao->query($query);



?>
