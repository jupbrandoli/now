<?php
    session_start();

    if (!isset($_SESSION['ID'])) {
        header("location: index.php");
        exit();
    }

    $conexao = new mysqli("localhost", "root", "", "now");

    if ($conexao->connect_error) {
        die("Falha na conexão: " . $conexao->connect_error);
    }

    $usuario_id = $_SESSION['ID'];

    // Consulta para selecionar todas as memórias visualizadas pelo usuário
    $query = "
        SELECT m.id, m.titulo, m.descricao, m.data, m.foto 
        FROM memoria m
        INNER JOIN album a ON m.id = a.memoria_id 
        WHERE a.usuario_id = ?
        ORDER BY m.data DESC
    ";

    $stmt = $conexao->prepare($query);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($memoria = $result->fetch_assoc()) {
            $titulo = $memoria['titulo'];
            $descricao = $memoria['descricao'];
            $data = $memoria['data'];
            $foto = $memoria['foto'];

            echo "<div>";
            echo "<h2>$titulo</h2>";
            echo "<p><strong>Descrição:</strong> $descricao</p>";
            echo "<p><strong>Data:</strong> $data</p>";

            if (!empty($foto)) {
                echo "<img src='$foto' alt='Foto da Memória' />";
            }
            
            echo "</div><hr>";
        }
    } else {
        echo "Nenhuma memória visualizada disponível para esse usuário.";
    }

    $stmt->close();
    $conexao->close();
?>
