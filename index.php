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
            cursor: pointer;
        
        }
        /* Estilos do menu */
    .menu {
        position: absolute;
        top: 10px; /* Mantém o menu próximo ao topo */
        left: 10px; /* Mantém o menu próximo ao canto esquerdo */
        width: 50px;
        height: 50px;
        background-color: #444;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s;
        z-index: 3;
    }

    .menu:hover {
        background-color: #555;
    }

    /* Estilo das opções do menu */
    .menu-item {
        display: none;
        position: absolute;
        width: 60px;
        height: 60px;
        background-color: #333;
        color: white;
        text-align: center;
        border-radius: 50%;
        transition: background-color 0.3s;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .menu-item a {
        color: white;
        text-decoration: none;
    }

    /* Posições ajustadas das opções */
    .menu-item:nth-child(1) { top: calc(-60px - 10px); left: 0; } /* Acima */
    .menu-item:nth-child(2) { top: 0; left: calc(60px + 10px); }  /* Direita */
    .menu-item:nth-child(3) { top: calc(60px + 10px); left: 0; }  /* Abaixo */

    /* Botão de Logout */
    .logout-button {
        position: absolute;
        bottom: 10px; /* Localizado na parte inferior */
        left: 10px;   /* Localizado à esquerda */
        background-color: #d9534f; /* Vermelho suave */
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        text-align: center;
        text-decoration: none;
        font-family: Arial, sans-serif;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        transition: background-color 0.3s ease;
        z-index: 4;
    }

    .logout-button a {
        color: white;
        text-decoration: none;
    }

    .logout-button:hover {
        background-color: #c9302c; /* Cor mais escura ao passar o mouse */
    }
</style>
    <link rel="stylesheet" href="https://unpkg.com/phosphor-icons@latest/src/styles.css">
</head>
<body>
    <h1>NOW!</h1>
    <canvas id="canvas"></canvas>

    <!-- Menu circular -->
    <div class="menu">
        <span><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#ffffff" viewBox="0 0 256 256"><path d="M224,128a8,8,0,0,1-8,8H40a8,8,0,0,1,0-16H216A8,8,0,0,1,224,128ZM40,72H216a8,8,0,0,0,0-16H40a8,8,0,0,0,0,16ZM216,184H40a8,8,0,0,0,0,16H216a8,8,0,0,0,0-16Z"></path></svg></span>
        <div class="menu-item">
            <a href="albumMemoria.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 256 256">
                    <path d="M232,48H160a40,40,0,0,0-32,16A40,40,0,0,0,96,48H24a8,8,0,0,0-8,8V200a8,8,0,0,0,8,8H96a24,24,0,0,1,24,24,8,8,0,0,0,16,0,24,24,0,0,1,24-24h72a8,8,0,0,0,8-8V56A8,8,0,0,0,232,48ZM96,192H32V64H96a24,24,0,0,1,24,24V200A39.81,39.81,0,0,0,96,192Zm128,0H160a39.81,39.81,0,0,0-24,8V88a24,24,0,0,1,24-24h64Z"></path>
                </svg>
            </a>
        </div>
        <div class="menu-item">
            <a href="albumFavoritas.php">✩</a>
        </div>
        <div class="menu-item">
            <a href="sobre.php">sob</a>
        </div>
    </div>
    <div class="logout-button">
        <a href="logout.php">Logout</a>
    </div>

    <script>
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');

        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const colorData = [
            { color: 'yellow', id: 'felicidade' },
            { color: 'blue', id: 'tristeza' },
            { color: 'pink', id: 'nostalgia' },
            { color: 'purple', id: 'outofcontext' },
            { color: 'red', id: 'raiva' }
        ];

        let balls = [];
        let hoveredBall = null;

        function isOverlapping(ball1, ball2) {
            const dx = ball1.x - ball2.x;
            const dy = ball1.y - ball2.y;
            const distance = Math.sqrt(dx * dx + dy * dy);
            return distance < ball1.radius + ball2.radius;
        }

        function isOverlappingTextArea(ball) {
            const textTop = canvas.height * 0.4 - 20;
            const textBottom = canvas.height * 0.4 + 20;
            const textLeft = canvas.width * 0.25;
            const textRight = canvas.width * 0.75;

            return (
                ball.y - ball.radius < textBottom &&
                ball.y + ball.radius > textTop &&
                ball.x + ball.radius > textLeft &&
                ball.x - ball.radius < textRight
            );
        }

        function drawBall(x, y, radius, color, highlight = false) {
            ctx.beginPath();
            ctx.arc(x, y, radius, 0, Math.PI * 2);
            ctx.fillStyle = color;
            ctx.fill();
            if (highlight) {
                ctx.lineWidth = 4;
                ctx.strokeStyle = 'white';
                ctx.stroke();
            }
            ctx.closePath();
            return { x, y, radius, color };
        }

        function getRandomNumber(min, max) {
            return Math.random() * (max - min) + min;
        }

        function drawRandomBalls(numBallsPerColor) {
            for (let color of colorData) {
                let count = 0;
                while (count < numBallsPerColor) {
                    const radius = getRandomNumber(20, 50);
                    const x = getRandomNumber(-radius, canvas.width + radius);
                    const y = getRandomNumber(-radius, canvas.height + radius);

                    const newBall = { x, y, radius, color: color.color, id: color.id };
                    let overlapping = balls.some(ball => isOverlapping(ball, newBall)) || isOverlappingTextArea(newBall);

                    if (!overlapping) {
                        balls.push(newBall);
                        count++;
                    }
                }
            }
        }

        function isBallClicked(ball, clickX, clickY) {
            const distance = Math.sqrt((ball.x - clickX) ** 2 + (ball.y - clickY) ** 2);
            return distance < ball.radius;
        }

        function sendIdToPHP(ballId) {
            var form = document.createElement("form");
            form.method = "POST";
            form.action = "visualizarMemoria.php";

            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "ballId";
            input.value = ballId;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }

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

        canvas.addEventListener('mousemove', function(event) {
            const rect = canvas.getBoundingClientRect();
            const mouseX = event.clientX - rect.left;
            const mouseY = event.clientY - rect.top;
            let isHovering = false;
            hoveredBall = null;

            for (let ball of balls) {
                if (isBallClicked(ball, mouseX, mouseY)) {
                    hoveredBall = ball;
                    isHovering = true;
                    break;
                }
            }

            if (isHovering) {
                canvas.classList.add("pin-cursor");
            } else {
                canvas.classList.remove("pin-cursor");
            }

            redrawBalls();
        });

        function redrawBalls() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            balls.forEach(ball => {
                drawBall(ball.x, ball.y, ball.radius, ball.color, ball === hoveredBall);
            });
        }

        drawRandomBalls(20);
        redrawBalls();
    </script>
</body>
</html>
