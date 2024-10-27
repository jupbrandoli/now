<?php
session_start();
    if(!isset($_SESSION['ID'])){
        header("location: login.html");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOW</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        h1 {
            position: absolute;
            top: 30%;
            text-align: center;
            width: 100vw;
            font-size: 100px;
            color: #000000;
            z-index: 2; /* Mantém o texto na frente das bolas */
        }
        canvas {
            width: 100vw;
            height: 100vh;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1; /* Coloca o canvas atrás do texto */
        }
    </style>
</head>
<body>
    <h1>NOW!</h1>
    <canvas id="canvas"></canvas>

    <script>
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');

        // Ajusta o tamanho do canvas para cobrir a tela inteira
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        // Definindo as cores e seus IDs emocionais
        const colorData = [
            { color: 'yellow', id: 'felicidade' },
            { color: 'blue', id: 'tristeza' },
            { color: 'pink', id: 'nostalgia' },
            { color: 'purple', id: 'outofcontext' },
            { color: 'red', id: 'raiva' }
        ];

        // Array para armazenar as bolas desenhadas
        let balls = [];

        // Função para verificar se duas bolas se sobrepõem
        function isOverlapping(ball1, ball2) {
            const dx = ball1.x - ball2.x;
            const dy = ball1.y - ball2.y;
            const distance = Math.sqrt(dx * dx + dy * dy);
            return distance < ball1.radius + ball2.radius;
        }

        // Função para verificar se a bola está sobrepondo o texto com margem reduzida lateralmente
        function isOverlappingTextArea(ball) {
            const textTop = canvas.height * 0.4 - 20; // 20px de margem vertical
            const textBottom = canvas.height * 0.4 + 20;
            const textLeft = canvas.width * 0.25;  // Reduz a margem lateral
            const textRight = canvas.width * 0.75;

            return (
                ball.y - ball.radius < textBottom &&
                ball.y + ball.radius > textTop &&
                ball.x + ball.radius > textLeft &&
                ball.x - ball.radius < textRight
            );
        }

        // Função para desenhar uma bola
        function drawBall(x, y, radius, color) {
            ctx.beginPath();
            ctx.arc(x, y, radius, 0, Math.PI * 2);
            ctx.fillStyle = color;
            ctx.fill();
            ctx.closePath();
            return { x, y, radius, color };
        }

        // Função para gerar um número aleatório entre um intervalo
        function getRandomNumber(min, max) {
            return Math.random() * (max - min) + min;
        }

        // Função para desenhar várias bolas aleatórias sem sobreposição e fora da área do texto
        function drawRandomBalls(numBallsPerColor) {
            for (let color of colorData) {
                let count = 0;
                while (count < numBallsPerColor) {
                    const radius = getRandomNumber(20, 50);
                    const x = getRandomNumber(-radius, canvas.width + radius); // Permite sair da tela
                    const y = getRandomNumber(-radius, canvas.height + radius);

                    const newBall = { x, y, radius, color: color.color, id: color.id };
                    let overlapping = balls.some(ball => isOverlapping(ball, newBall)) || isOverlappingTextArea(newBall);

                    if (!overlapping) {
                        drawBall(newBall.x, newBall.y, newBall.radius, newBall.color);
                        balls.push(newBall);
                        count++;
                    }
                }
            }
        }

        // Função para detectar se o clique ocorreu dentro de uma bola
        function isBallClicked(ball, clickX, clickY) {
            const distance = Math.sqrt((ball.x - clickX) ** 2 + (ball.y - clickY) ** 2);
            return distance < ball.radius;
        }

        // Função para enviar o ID selecionado para o PHP via link (query string)
        
        function sendIdToPHP(ballId) {
            // Cria um elemento de formulário
            var form = document.createElement("form");
            form.method = "POST";
            form.action = "visualizarMemoria.php"; // Altere para o arquivo PHP apropriado

            // Cria um elemento de entrada para armazenar o ballId
            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "ballId";
            input.value = ballId;

            // Anexa o input ao formulário
            form.appendChild(input);

            // Anexa o formulário ao corpo (necessário para submissão)
            document.body.appendChild(form);

            // Submete o formulário
            form.submit();
        }

 
        // Função de clique para detectar a bola e enviar o ID correspondente ao PHP
        canvas.addEventListener('click', function(event) {
            const rect = canvas.getBoundingClientRect();
            const clickX = event.clientX - rect.left;
            const clickY = event.clientY - rect.top;

            for (let ball of balls) {
                if (isBallClicked(ball, clickX, clickY)) {
                    sendIdToPHP(ball.id);
                    break;
                }
            }
        });
        canvas.addEventListener('click', function(event) {
    const rect = canvas.getBoundingClientRect();
    const clickX = event.clientX - rect.left;
    const clickY = event.clientY - rect.top;

    for (let ball of balls) {
        if (isBallClicked(ball, clickX, clickY)) {
            sendIdToPHP(ball.id);
            break;
        }
    }
});


        // Desenha 20 bolas de cada cor de forma proporcional sem sobreposição e fora da área do texto
        drawRandomBalls(20);
    </script>
</body>
</html>
