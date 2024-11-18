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
$usuario_id = $_SESSION['ID'];

// Parâmetros para paginação
$memorias_por_pagina = 4; // Quantidade de memórias por página
$pagina_atual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($pagina_atual - 1) * $memorias_por_pagina;

// Consulta para buscar memórias favoritas
$query = "SELECT m.id, m.titulo, m.descricao, m.data, m.foto, m.sentimento 
    FROM memoria m INNER JOIN album a ON a.id_memoria = m.id 
    WHERE a.id_user = ? AND a.favorita = 1
    LIMIT ? OFFSET ? ";

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
    FROM album a WHERE a.id_user = $usuario_id AND a.favorita = 1
";
$total_result = $conexao->query($total_query);
$total_memorias = $total_result->fetch_assoc()['total'];

$total_paginas = ceil($total_memorias / $memorias_por_pagina);

$stmt->close();
$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria de Imagens</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow-x: hidden;
        }

        .gallery-container {
            position: relative;
            width: 80%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            overflow-x: scroll;
            white-space: nowrap;
        }

        .photo-card {
            width: 200px;
            height: 300px;
            background-color: #fff;
            border: 2px solid #000;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            padding: 10px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin-top: 50px;
        }

        .photo-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 5px;
        }

        /* Estrelas acima das fotos */
        .stars {
            position: absolute;
            top: -50px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 64px; /* Estrelas maiores */
            color: orange;
            z-index: 10;
        }

        .photo-card p {
            margin: 10px 0 0;
            font-size: 16px;
        }

        .arrow {
            background: none;
            border: none;
            font-size: 36px;
            cursor: pointer;
            padding: 10px;
            color: #555;
        }

        .arrow:focus {
            outline: none;
        }

        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination a {
            margin: 0 5px;
            text-decoration: none;
            color: #555;
        }

        .pagination a.current-page {
            font-weight: bold;
            color: #000;
        }

        /* Linha de continuidade conectando as estrelas ao topo */
        .stars-line {
            position: absolute;
            top: -60px;
            left: 50%;
            transform: translateX(-50%);
            width: 2px;
            height: 50px;
            background-color: #000;
            z-index: 5;
        }
    </style>
</head>
<body>
    <div class="gallery-container">
        <!-- Botão para página anterior -->
        <?php if ($pagina_atual > 1): ?>
            <button class="arrow left" onclick="window.location.href='?pagina=<?= $pagina_atual - 1 ?>'">&#9664;</button>
        <?php endif; ?>

        <!-- Memórias favoritas -->
        <?php foreach ($memorias as $memoria): ?>
            <div class="photo-card">
                <div class="stars-line"></div> <!-- Linha conectando as estrelas -->
                <div class="stars">&#9733;</div>
                <img src="<?= htmlspecialchars($memoria['foto']) ?>" alt="<?= htmlspecialchars($memoria['titulo']) ?>">
                <p><?= htmlspecialchars($memoria['titulo']) ?></p>
            </div>
        <?php endforeach; ?>

        <!-- Botão para próxima página -->
        <?php if ($pagina_atual < $total_paginas): ?>
            <button class="arrow right" onclick="window.location.href='?pagina=<?= $pagina_atual + 1 ?>'">&#9654;</button>
        <?php endif; ?>
    </div>

    <!-- Paginação -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
            <a href="?pagina=<?= $i ?>" class="<?= $i == $pagina_atual ? 'current-page' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
</body>
</html>