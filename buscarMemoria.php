<?php
    session_start();

    if (!isset($_SESSION['ID'])) {
        header("location: login.html");
    }

    $conexao = new mysqli("localhost", "root", "", "now");

    if ($conexao->connect_error) {
        die("Falha na conexão: " . $conexao->connect_error);
    }

    if (isset($_GET['ballId'])) {
        $sentimento_id = $_GET['ballId'];
    } else {
        die("ID do sentimento não informado.");
    }

    $usuario_id = $_SESSION['ID'];

    $query = "SELECT m.id, m.titulo, m.descricao, m.data, m.foto, m.sentimento 
          FROM memoria m 
          LEFT JOIN album a ON m.id = a.id_memoria AND a.id_user = '{$usuario_id}'
          WHERE a.id_memoria IS NULL AND m.sentimento = '{$sentimento_id}' 
          ORDER BY RAND() LIMIT 1;";



    $result = $conexao->query($query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $memoria = $result->fetch_assoc();
        echo json_encode([
            'titulo' => $memoria['titulo'],
            'descricao' => $memoria['descricao'],
            'data' => $memoria['data'],
            'foto' => $memoria['foto'],
            'ballId' => $memoria['sentimento']
        ]);


        $memoria_id = $memoria['id'];
        $registro = $conexao->prepare("INSERT INTO album (id_user, id_memoria) VALUES (?, ?)");
        $registro->bind_param("ii", $usuario_id, $memoria_id);
        $registro->execute();
    

    } else {
        echo "Nenhuma memória disponível com esse sentimento que você ainda não tenha visto.";
    }

    $stmt->close();
    $conexao->close();
?>