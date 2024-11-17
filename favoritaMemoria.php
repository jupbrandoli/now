<?php
session_start();
header('Content-Type: application/json');

// Verifica se o usuário está logado
if (!isset($_SESSION['ID'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.']);
    exit;
}

// Lê os dados JSON da requisição
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Verifica se os dados necessários foram fornecidos
if (!isset($data['id_memoria']) || !isset($data['favorita'])) {
    echo json_encode(['success' => false, 'message' => 'Dados insuficientes para processar a requisição.']);
    exit;
}

$id_memoria = (int)$data['id_memoria'];
$favorita = (int)$data['favorita'];

// Conexão com o banco de dados
$conexao = new mysqli("localhost", "root", "", "now");

// Verifica a conexão
if ($conexao->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Falha na conexão: ' . $conexao->connect_error]);
    exit;
}

// ID do usuário logado
$usuario_id = (int)$_SESSION['ID'];

// Verifica se o registro já existe
$query = "SELECT * FROM album WHERE id_memoria = $id_memoria AND id_user = $usuario_id";
$result = $conexao->query($query);

if ($result && $result->num_rows > 0) {
    // Atualiza o estado de favorita
    $update_query = "UPDATE album SET favorita = $favorita WHERE id_memoria = $id_memoria AND id_user = $usuario_id";
    if ($conexao->query($update_query)) {
        echo json_encode(['success' => true, 'message' => 'Favorito atualizado com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar favorito: ' . $conexao->error]);
    }
} else {
    // Insere um novo registro
    $insert_query = "INSERT INTO album (id_user, id_memoria, favorita) VALUES ($usuario_id, $id_memoria, $favorita)";
    if ($conexao->query($insert_query)) {
        echo json_encode(['success' => true, 'message' => 'Favorito adicionado com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao adicionar favorito: ' . $conexao->error]);
    }
}

// Fecha a conexão com o banco de dados
$conexao->close();
?>
