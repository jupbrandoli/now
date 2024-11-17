<?php include 'buscarMemoriasAlbum.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Álbum de Memórias</title>
    <style>
        /* Botão de navegação estilizado como círculo */
.back-button {
    position: absolute;
    top: 2%;
    left: 2%;
    width: 50px;
    height: 50px;
    background-color: #ffffff;
    border: 2px solid #ff7043; /* Cor amarela */
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    text-decoration: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s, transform 0.2s;
}

/* Estilizando o ícone de seta */
.back-button::before {
    content: "←"; /* Seta para a esquerda */
    font-size: 20px;
    color: #ff7043; /* Cor laranja mais escura */
    font-weight: bold;
    display: flex;
    justify-content: center;
    align-items: center;
}


/* Estilos gerais */
body {
    font-family: Arial, sans-serif;
    background-color: #ffcc80; /* Fundo laranja claro */
    margin: 0;
    padding: 0;
    overflow: hidden; /* Remove a barra de rolagem vertical */
}

.container {
    width: 100vw; /* Largura total da tela */
    height: 100vh; /* Altura total da tela */
    padding: 20px;
    background-color: #fff3e0;
    border-radius: 20px;
    position: relative;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    box-sizing: border-box;
}

/* Estilo do livro */
.book {
    display: flex;
    flex-direction: row; /* Disposição horizontal das memórias */
    gap: 60px; /* Espaçamento entre as memórias */
    padding: 30px;
    align-content: center;
    background-color: #ffe0b2;
    border-radius: 15px;
    box-shadow: inset 0 4px 6px rgba(0, 0, 0, 0.2);
    overflow-x: auto; /* Permite rolagem horizontal */
    overflow-y: hidden; /* Remove a rolagem vertical */
    width: 100%;
    height: calc(100vh - 160px); /* Ajusta a altura para caber na tela */
    flex-wrap: wrap;
    justify-content: center;
}

.book::-webkit-scrollbar {
    height: 10px;
}

.book::-webkit-scrollbar-thumb {
    background-color: #ffb74d;
    border-radius: 10px;
}
        /* Aqui, as cores para sentimentos */
        .memory {
            width: 140px;
            height: 140px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 5px solid transparent;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            cursor: pointer;
        }
            
        
        .memory img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
        }

        .memory.locked {
        background: #ddd;
        color: #666;
        font-size: 1.5em;
        font-weight: bold;
        }

        .memory.gray {
        background-color: #d3d3d3; /* Cinza claro */
        color: #666;
        font-size: 1.5em;
        font-weight: bold;
        }
        
        /* Cores para sentimentos */
        .felicidade { background-color: yellow; }
        .tristeza { background-color: blue; }
        .nostalgia { background-color: pink; }
        .raiva { background-color: red; }
        .outofcontext { background-color: purple; }

        /* Paginação com botões mais compactos */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
            padding: 5px 10px;  /* Menos padding para reduzir altura */
            background-color: #ffe0b2;
            border-radius: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        /* Estilo dos botões de paginação */
        .pagination a {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 35px;
            height: 35px;
            text-decoration: none;
            color: #fff;
            background-color: #ff7043;
            border-radius: 50%;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.2s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            font-size: 18px; /* Tamanho de fonte menor */
        }

        /* Página atual */
        .pagination a.current-page {
            background-color: #f4511e; /* Tom mais escuro para a página atual */
            color: #fff;
        }

        /* Efeito de hover */
        .pagination a:hover {
            background-color: #f4511e; /* Tom mais escuro no hover */
            transform: scale(1.1); /* Aumenta levemente o botão */
        }

        /* Seta para os botões Anterior e Próxima */
        .pagination a.prev, .pagination a.next {
            font-size: 20px; /* Tamanho maior para as setas */
            text-align: center;
            justify-content: center;
        }

        /* Estilo das setas */
        .pagination a.prev::before {
            content: "←"; /* Seta para a esquerda */
        }

        .pagination a.next::before {
            content: "→"; /* Seta para a direita */
        }

        .custom-alert {
            display: none; /* Escondido por padrão */
            position: fixed; /* Fica no lugar */
            z-index: 1000; /* Sobrepõe outros elementos */
            left: 0;
            top: 0;
            width: 100%; /* Largura total */
            height: 100%; /* Altura total */
            overflow: auto; /* Habilita scroll se necessário */
            background-color: rgba(0,0,0,0.5); /* Fundo preto com transparência */
        }

        .custom-alert-content {
            background-color: #fff;
            margin: 15% auto; /* Centraliza verticalmente */
            padding: 20px;
            border-radius: 5px;
            width: 80%; /* Largura do conteúdo */
            max-width: 400px;
            text-align: center;
            position: relative;
        }

        .close-button {
            color: #aaa;
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
        }

    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-button"></a>
        <h1>Meu Álbum de Memórias</h1>

        <div class="book">
            <?php if (!empty($memorias)): ?>
                <?php foreach ($memorias as $memoria): ?>
                    <?php
                    // Atribuindo a classe de cor com base no sentimento
                    $sentimento = strtolower($memoria['sentimento']);
                    $sentimentoClass = ($memoria['visualizada']) ? (in_array($sentimento, ['felicidade', 'tristeza', 'nostalgia', 'raiva', 'outofcontext']) ? $sentimento : 'gray') : 'gray';
                    $memoriaId = $memoria['id']; // Certifique-se de que o ID da memória está disponível
                    ?>
                    <div class="memory <?= $sentimentoClass ?>" 
                        data-memoria-id="<?= $memoriaId ?>" 
                        data-visualizada="<?= $memoria['visualizada'] ? '1' : '0' ?>">
                        <?php if ($memoria['visualizada']): ?>
                            <img src="<?= $memoria['foto'] ?>" alt="<?= $memoria['titulo'] ?>">
                        <?php else: ?>
                            <span>?</span> <!-- Memória bloqueada -->
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Não há memórias para exibir.</p>
            <?php endif; ?>
        </div>  

        <!-- Modal de Alerta Personalizado -->
        <div id="custom-alert" class="custom-alert">
            <div class="custom-alert-content">
                <span class="close-button" onclick="closeAlert()">&times;</span>
                <p>Esta memória ainda não foi desbloqueada.</p>
            </div>
        </div>

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
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const memoryDivs = document.querySelectorAll('.memory');
        memoryDivs.forEach(function(div) {
            div.addEventListener('click', function() {
                const visualizada = this.getAttribute('data-visualizada');
                const memoriaId = this.getAttribute('data-memoria-id');
                if (visualizada === '1') {
                    window.location.href = 'visualizarAlbum.php?id=' + memoriaId;
                } else {
                    showAlert();
                }
            });
        });
    });

    function showAlert() {
        document.getElementById('custom-alert').style.display = 'block';
    }

    function closeAlert() {
        document.getElementById('custom-alert').style.display = 'none';
    }
</script>
</body>
</html>
