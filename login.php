<?php

    $conexao = new mysqli("localhost","root","","now");

    $sql = "SELECT * FROM user WHERE nome = '{$_POST['nome']}' and senha = '{$_POST['senha']}'";

    $resultado = $conexao->query($sql);

    $usuarios = $resultado->fetch_all(MYSQLI_ASSOC);

    if(count($usuarios)!=0){
        session_start();
        $_SESSION['ID'] = $usuarios[0]['id'];
        
        header("location: index.php");
    }else{
        header("location: login.html");
    }

?>