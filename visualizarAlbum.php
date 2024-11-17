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

// Obtém o id da memória do GET ou POST
if (isset($_GET['id'])) {
    $id_memoria = $_GET['id'];
} elseif (isset($_POST['id'])) {
    $id_memoria = $_POST['id'];
} else {
    die("ID da memória não informado.");
}

// ID do usuário logado
$usuario_id = (int)$_SESSION['ID'];

// Sanitiza o id_memoria
$id_memoria = $conexao->real_escape_string($id_memoria); // Contra SQL Injection

// Monta a consulta SQL (não alterada)
$query = "SELECT m.id, m.titulo, m.descricao, m.data, m.foto, m.sentimento 
FROM memoria m 
INNER JOIN album a ON m.id = a.id_memoria AND a.id_user = '{$usuario_id}' AND a.id_memoria = '{$id_memoria}'";

// Executa a consulta
$result = $conexao->query($query);

if ($result && $result->num_rows > 0) {
    $memoria = $result->fetch_assoc();

    // Exibe os dados formatados
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <meta charset="UTF-8">
        <title>Visualizar Memória Favorita</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body, html { height: 100%; width: 100%; overflow: hidden; font-family: Arial, sans-serif; }
            .container { 
                position: relative; 
                height: 100%; width: 100%;
                display: flex;
                justify-content: center; 
                align-items: center; 
                background-color: white; 
            }
            .box {
                width: 50%;
                height: 400px; 
                background-color: #f9d805; /* Cor padrão */
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                position: relative; 
                display: flex; 
                justify-content: center; 
                align-items: center; 
            }
            .text { 
                text-align: center; 
                position: absolute; 
                top: 10%; 
                width: 100%; 
            }
            .text h1 { 
                font-size: 24px; 
                font-weight: bold; 
            }
            .text-bottom { 
                position: absolute; 
                bottom: 5%; 
                width: 100%; 
                text-align: center; 
            }

            .text-bottom p { 
                font-size: 18px; 
                margin-top: 10px; 
            }
            .text-date { 
                font-weight: bold; 
                margin-top: 10px; 
            }
            .circle { 
                border-radius: 50%; 
                position: absolute; 
                background-color: #f9d805; /* Cor padrão */
            }
            .circle-top-left { 
                width: 150px; 
                height: 150px;
                top: 25%; 
                left: 5%; 
            }
            .circle-bottom-left { 
                width: 160px; height: 160px; 
                bottom: -5%; 
                left: -3%; 
            }
            .circle-top-right { 
                width: 160px; 
                height: 160px; 
                top: -5%; 
                right: -3%; 
            }
            .circle-bottom-right { 
                width: 150px; 
                height: 150px; 
                bottom: 25%; 
                right: 5%; 
            }
            .back-button { 
                position: absolute;
                top: 2%;
                left: 2%;
                width: 40px;
                height: 40px;
                background-color: white;
                border: 2px solid #f9d805; /* Cor padrão */
                border-radius: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
                cursor: pointer; 
                text-decoration: none; 
                }
            
            .back-button::before {
                content: "←";
                font-size: 18px;
                color: black;
            }
            .heart-button {
                position: absolute;
                top: 10px; 
                right: 10px; 
                width: 50px; 
                height: 50px; 
                background-color: white;
                border: none;
                border-radius: 50%; 
                display: flex;
                justify-content: center;
                align-items: center;
                cursor: pointer;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
                transition: background-color 0.3s, transform 0.2s, box-shadow 0.3s;
            }

            /* Ícone do coração */
            .heart-button i {
                font-size: 24px; 
                color: gray; 
                transition: color 0.3s;
            }

            .heart-button.active i {
                color: red; 
            }

            .heart-button:hover {
                transform: scale(1.1); 
                background-color: #f8f9fa;
                box-shadow: 0 6px 8px rgba(0, 0, 0, 0.3);
            }


        </style>
    </head>
    <body>
        <div class="container">
            <a href="albumMemoria.php" class="back-button"></a>

            <!-- Texto no topo -->
            <div class="text">
                <h1><?php echo htmlspecialchars($memoria['titulo']); ?></h1> <!-- Título da memória -->
            </div>

            <!-- Caixa colorida no centro para a imagem -->
            <div class="box">
                <?php if (!empty($memoria['foto'])): ?>
                    <img src="<?php echo htmlspecialchars($memoria['foto']); ?>" alt="Imagem da Memória" style="max-width:100%; max-height:100%;">
                <?php endif; ?>

                <button id="favoriteButton" class="heart-button" alt="Favoritar" onclick="toggleFavorite(<?php echo $memoria['id']; ?>)">
                    <i class="bi bi-heart"></i> <!-- Ícone de coração vazio -->
                </button>

            </div>

            <!-- Texto da data e descrição -->
            <div class="text-bottom">
                <p><?php echo nl2br(htmlspecialchars($memoria['descricao'])); ?></p> <!-- Descrição da memória -->
                <p class="text-date"><?php echo htmlspecialchars((new DateTime($memoria['data']))->format('d/m/Y')); ?></p> <!-- Data da memória -->
            </div>

            <!-- Círculos decorativos -->
            <div class="circle circle-top-left"></div>
            <div class="circle circle-bottom-left"></div>
            <div class="circle circle-top-right"></div>
            <div class="circle circle-bottom-right"></div>
        </div>

        <script>
            // Seu array colorData
            const colorData = [
                { color: 'yellow', id: 'felicidade' },
                { color: 'blue', id: 'tristeza' },
                { color: 'pink', id: 'nostalgia' },
                { color: 'purple', id: 'outofcontext' },
                { color: 'red', id: 'raiva' }
            ];

            // Variável sentimento passada do PHP
            const sentimento = '<?php echo htmlspecialchars($memoria['sentimento'], ENT_QUOTES, 'UTF-8'); ?>';

            // Encontra a cor correspondente ao sentimento
            const colorEntry = colorData.find(entry => entry.id === sentimento.toLowerCase());
            const color = colorEntry ? colorEntry.color : 'gray'; // Define 'gray' como padrão se não encontrar

            // Altera a cor dos elementos após o carregamento da página
            window.addEventListener('DOMContentLoaded', (event) => {
                // Altera a cor de fundo da caixa central
                const box = document.querySelector('.box');
                if (box) {
                    box.style.backgroundColor = color;
                    box.style.borderColor = color;
                }

                // Altera a cor dos círculos
                const circles = document.querySelectorAll('.circle');
                circles.forEach(circle => {
                    circle.style.backgroundColor = color;
                });

                // Altera a cor da borda do botão voltar
                const backButton = document.querySelector('.back-button');
                if (backButton) {
                    backButton.style.borderColor = color;
                }
            });

        document.addEventListener('DOMContentLoaded', () => {
            const button = document.getElementById('favoriteButton');
            const icon = button.querySelector('i');
            const idMemoria = button.getAttribute('onclick').match(/\d+/)[0]; // Extrai o ID do botão

            // Verifica o estado atual do favorito ao carregar a página
            fetch(`verificarFavorita.php?id_memoria=${idMemoria}`, { method: "GET" })
                .then(response => response.json())
                .then(data => {
                    if (data.favorita === 1) {
                        // Se for favorita, atualiza o botão e o ícone
                        button.classList.add('active');
                        icon.classList.remove('bi-heart'); // Ícone vazio
                        icon.classList.add('bi-heart-fill'); // Ícone preenchido
                    } else {
                        // Se não for favorita, mantém o estado padrão
                        button.classList.remove('active');
                        icon.classList.remove('bi-heart-fill'); // Ícone preenchido
                        icon.classList.add('bi-heart'); // Ícone vazio
                    }
                })
                .catch(error => console.error("Erro ao verificar favorito:", error));
        });
        function toggleFavorite(idMemoria) {
            const button = document.getElementById('favoriteButton');
            const icon = button.querySelector('i');

            // Faz uma requisição para verificar o estado atual
            fetch(`verificarFavorita.php?id_memoria=${idMemoria}`, { method: "GET" })
                .then(response => response.json())
                .then(data => {
                    let favorita = 0;

                    // Determina o novo estado com base no valor recebido
                    if (data.favorita === 0) {
                        favorita = 1;
                        button.classList.add('active');
                        icon.classList.remove('bi-heart'); // Ícone vazio
                        icon.classList.add('bi-heart-fill'); // Ícone preenchido
                    } else {
                        favorita = 0;
                        button.classList.remove('active');
                        icon.classList.remove('bi-heart-fill'); // Ícone preenchido
                        icon.classList.add('bi-heart'); // Ícone vazio
                    }

                    // Envia o novo estado para o backend
                    return fetch("favoritaMemoria.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ id_memoria: idMemoria, favorita: favorita })
                    });
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        console.error("Erro ao atualizar favorito:", data.message);
                    }
                })
                .catch(error => console.error("Erro:", error));
        }

        </script>
    </body>
    </html>
    <?php

} else {
    // Caso não haja memórias disponíveis
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Nenhuma Memória Disponível</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body, html { 
                height: 100%; 
                width: 100%; 
                overflow: hidden; 
                font-family: Arial, sans-serif; 
                background-color: white; 
            }
            .container { 
                position: relative;  
                height: 100%; 
                width: 100%;
                display: flex;
                justify-content: center; 
                align-items: center; 
            }
            .box {
                width: 50%;
                height: 400px; 
                background-color: gray; /* Cor cinza */
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                position: relative; 
                display: flex; 
                justify-content: center; 
                align-items: center; 
            }
            .text { 
                text-align: center; 
                position: absolute; 
                top: 10%; 
                width: 100%; 
            }
            .text h1 { 
                font-size: 24px; 
                font-weight: bold; 
            }
            .text-bottom { 
                position: absolute; 
                bottom: 5%; 
                width: 100%; 
                text-align: center; 
            }

            .text-bottom p { 
                font-size: 18px; 
                margin-top: 10px; 
            }
            .circle { 
                border-radius: 50%; 
                position: absolute; 
                background-color: gray; /* Cor cinza */
            }
            .circle-top-left { 
                width: 150px; 
                height: 150px;
                top: 25%; 
                left: 5%; 
            }
            .circle-bottom-left { 
                width: 160px; height: 160px; 
                bottom: -5%; 
                left: -3%; 
            }
            .circle-top-right { 
                width: 160px; 
                height: 160px; 
                top: -5%; 
                right: -3%; 
            }
            .circle-bottom-right { 
                width: 150px; 
                height: 150px; 
                bottom: 25%; 
                right: 5%; 
            }
            .back-button { 
                position: absolute;
                top: 2%;
                left: 2%;
                width: 40px;
                height: 40px;
                background-color: white;
                border: 2px solid gray; /* Cor cinza */
                border-radius: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
                cursor: pointer; 
                text-decoration: none; 
                }
            
            .back-button::before {
                content: "←";
                font-size: 18px;
                color: black; }

        </style>
    </head>
    <body>
        <div class="container">
            <a href="index.php" class="back-button"></a>

            <!-- Texto no topo -->
            <div class="text">
                <h1>Nenhuma Memória Disponível</h1>
            </div>

            <!-- Caixa colorida no centro -->
            <div class="box">
                <p>Não há memórias com esse sentimento que você ainda não tenha visto.</p>
            </div>

            <!-- Círculos decorativos -->
            <div class="circle circle-top-left"></div>
            <div class="circle circle-bottom-left"></div>
            <div class="circle circle-top-right"></div>
            <div class="circle circle-bottom-right"></div>
        </div>
    </body>
    </html>
    <?php
}


// Fecha a conexão
$conexao->close();
?>
