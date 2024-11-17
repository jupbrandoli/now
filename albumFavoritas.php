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
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f0f0f0;
    }

    .gallery-container {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        gap: 20px; /* Espaçamento entre os blocos */
    }

    .photo-card {
        width: 250px; /* Aumenta ainda mais a largura */
        height: 400px; /* Aumenta ainda mais a altura */
        border: 2px solid #000;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        padding: 20px;
        position: relative;
        text-align: center;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adiciona sombra para destaque */
    }

    .photo {
        width: 100%;
        height: 250px; /* Ajusta a altura da área da imagem */
        background-color: #ddd; /* Placeholder for images */
        border-radius: 5px;
    }

    .stars {
        position: absolute;
        top: -30px; /* Ajusta a posição das estrelas */
        font-size: 32px; /* Aumenta o tamanho das estrelas */
        color: orange;
    }

    .photo-card p {
        font-size: 18px; /* Aumenta o tamanho do texto */
        margin: 10px 0 0;
    }

    .bottom-stars {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        font-size: 32px; /* Aumenta o tamanho das estrelas na parte inferior */
        color: orange;
    }

    .arrow {
        background: none;
        border: none;
        font-size: 36px; /* Aumenta o tamanho das setas */
        cursor: pointer;
        padding: 10px;
        color: #555;
    }

    .arrow:focus {
        outline: none;
    }

    </style>
</head>
<body>
    <!-- Teste fixo -->
    <!-- Página semelhante a albumMemoria.php -->
    <div class="gallery-container">
        <button class="arrow left">&#9664;</button>

        <div class="photo-card" style="background-color: #FFD700;">
            <img src="images/photo1.jpg" alt="Imagem 1" class="photo">
            <p>Primeira aula presencial<br>10/08/2021</p>
            <div class="stars">&#9733;</div>
        </div>

        <div class="photo-card" style="background-color: #800080;">
            <img src="images/photo2.jpg" alt="Imagem 2" class="photo">
            <p>Iraniani<br>11/08/2024</p>
            <div class="stars">&#9733;</div>
        </div>

        <div class="photo-card" style="background-color: #FFC0CB;">
            <img src="images/photo3.jpg" alt="Imagem 3" class="photo">
            <p>Iraniani</p>
            <div class="stars">&#9733;</div>
        </div>

        <button class="arrow right">&#9654;</button>

        <!-- Paginação -->
        <div class="pagination">
            <?php if ($pagina_atual > 1): ?>
                <a href="?pagina=<?= $pagina_atual - 1 ?>" class="prev"></a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <a href="?pagina=<?= $i ?>" class="<?= $i == $pagina_atual ? 'current-page' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
            <?php if ($pagina_atual < $total_paginas): ?>
                <a href="?pagina=<?= $pagina_atual + 1 ?>" class="next"></a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
