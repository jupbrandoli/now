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
    die("ID do sentimento não informado.");
}

// ID do usuário logado
$usuario_id = (int)$_SESSION['ID'];

// Sanitiza o sentimento_id
$sentimento_id = $conexao->real_escape_string($sentimento_id); // Contra SQL Injection

// Monta a consulta SQL
$query = "SELECT m.id, m.titulo, m.descricao, m.data, m.foto, m.sentimento 
        FROM memoria m 
        LEFT JOIN album a ON m.id = a.id_memoria AND a.id_user = $usuario_id
        WHERE a.id_memoria IS NULL AND m.sentimento = '$sentimento_id' 
        ORDER BY RAND() LIMIT 1;";

// Executa a consulta
$result = $conexao->query($query);

if ($result && $result->num_rows > 0) {
    $memoria = $result->fetch_assoc();

    // Insere um registro na tabela 'album'
    $memoria_id = (int)$memoria['id'];
    $insert_query = "INSERT INTO album (id_user, id_memoria, favorita) VALUES ($usuario_id, $memoria_id, 0)";
    $conexao->query($insert_query);

    // Exibe os dados formatados
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Visualizar Memória</title>
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
                color: black; }
        </style>
    </head>
    <body>
        <div class="container">
            <a href="index.php" class="back-button"></a>

            <!-- Texto no topo -->
            <div class="text">
                <h1><?php echo htmlspecialchars($memoria['titulo']); ?></h1> <!-- Título da memória -->
            </div>

            <!-- Caixa colorida no centro para a imagem -->
            <div class="box">
                <?php if (!empty($memoria['foto'])): ?>
                    <img src="<?php echo htmlspecialchars($memoria['foto']); ?>" alt="Imagem da Memória" style="max-width:100%; max-height:100%;">
                <?php endif; ?>
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

        <!-- Script JavaScript -->
        <script>
            // Seu array colorData
            const colorData = [
                { color: 'yellow', id: 'felicidade' },
                { color: 'blue', id: 'tristeza' },
                { color: 'pink', id: 'nostalgia' },
                { color: 'purple', id: 'outofcontext' },
                { color: 'red', id: 'raiva' }
            ];

            // Variável sentimentoId passada do PHP
            const sentimentoId = '<?php echo htmlspecialchars($sentimento_id, ENT_QUOTES, 'UTF-8'); ?>';

            // Encontra a cor correspondente ao sentimentoId
            const colorEntry = colorData.find(entry => entry.id === sentimentoId);
            const color = colorEntry ? colorEntry.color : 'black'; // Define grayk' como padrão se não encontrar

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
    </head>
    <body>
        <p>Nenhuma memória disponível com esse sentimento que você ainda não tenha visto.</p>
    </body>
    </html>
    <?php
}

// Fecha a conexão
$conexao->close();
?>
