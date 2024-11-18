<?php
if (isset($_SESSION['ID'])) {
    session_unset();  // Remove todas as variáveis de sessão
    session_destroy(); // Destroi a sessão
}

// Redireciona para a página de login
header("Location: login.php"); // Altere "login.php" para o destino desejado
exit();