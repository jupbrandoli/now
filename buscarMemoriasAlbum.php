<?php
// Verifica se a sessão já foi iniciada e inicia se necessário
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado
if (!isset($_SESSION['ID'])) {
    header("Location: index.php");
    exit;
}

// Inicia a conexão com o banco de dados
$conexao = new mysqli("localhost", "root", "", "now");
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

$usuario_id = $_SESSION['ID'];

// Parâmetros para paginação
$memorias_por_pagina = 12;
$pagina_atual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($pagina_atual - 1) * $memorias_por_pagina;

// Consulta para buscar memórias vistas e não vistas
$query = "
    SELECT m.id, m.titulo, m.descricao, m.data, m.foto, m.sentimento,
           CASE WHEN a.id_user IS NOT NULL THEN 1 ELSE 0 END AS visualizada
    FROM memoria m
    LEFT JOIN album a ON m.id = a.id_memoria AND a.id_user = ?
    ORDER BY m.data DESC
    LIMIT ? OFFSET ?
";

$stmt = $conexao->prepare($query);
$stmt->bind_param("iii", $usuario_id, $memorias_por_pagina, $offset);
$stmt->execute();
$result = $stmt->get_result();

$memorias = [];
if ($result->num_rows > 0) {
    while ($memoria = $result->fetch_assoc()) {
        $memorias[] = $memoria;
    }
}

// Conta o número total de memórias para a paginação
$total_query = "
    SELECT COUNT(*) as total
    FROM memoria
";
$total_result = $conexao->query($total_query);
$total_memorias = $total_result->fetch_assoc()['total'];
$total_paginas = ceil($total_memorias / $memorias_por_pagina);

$stmt->close();
$conexao->close();
?>
