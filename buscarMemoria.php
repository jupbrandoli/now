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

// Obtém o ballId (sentimento_id) do GET ou POST
if (isset($_GET['ballId'])) {
    $sentimento_id = $_GET['ballId'];
} elseif (isset($_POST['ballId'])) {
    $sentimento_id = $_POST['ballId'];
} else {
    die(json_encode(["success" => false, "message" => "ID do sentimento não informado."]));
}

// ID do usuário logado
$usuario_id = (int)$_SESSION['ID'];

// Sanitiza o sentimento_id
$sentimento_id = $conexao->real_escape_string($sentimento_id); // Contra SQL Injection

// Monta a consulta SQL
$query = "SELECT m.id, m.titulo, m.descricao, m.data, m.foto, m.sentimento 
FROM memoria m 
LEFT JOIN album a ON m.id = a.id_memoria AND a.id_user = '{$usuario_id}'
WHERE a.id_memoria IS NULL AND m.sentimento = '{$sentimento_id}' 
ORDER BY RAND() LIMIT 1;";

// Executa a consulta
$result = $conexao->query($query);

// Caso exista uma memória disponível
if ($result && $result->num_rows > 0) {
    $memoria = $result->fetch_assoc();

    // Insere um registro na tabela 'album'
    $memoria_id = (int)$memoria['id'];
    $insert_query = "INSERT INTO album (id_user, id_memoria, favorita) VALUES ($usuario_id, $memoria_id, 0)";
    $conexao->query($insert_query);

    echo json_encode(["success" => true, "memoria" => $memoria]);
} else {
    // Caso não haja memórias disponíveis
    echo json_encode(["success" => false, "message" => "Nenhuma memória disponível."]);
}

// Fecha a conexão
$conexao->close();
?>
