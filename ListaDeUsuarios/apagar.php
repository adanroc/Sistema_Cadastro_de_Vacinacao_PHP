<?php

// Obter dados de conexão
include '../conexao.php';

// Obter dados dos campos preenchidos
$idUsuario = $_POST['idUsuario'];

// Preparar inserção de dados no Bd
$recebendo_usuarios = "DELETE FROM
                        ListaDeUsuarios
                        WHERE idUsuario = '$idUsuario'";

// Validar query
$query_usuarios = mysqli_query($connx, $recebendo_usuarios);

// Verificar se a query foi executada com sucesso
if ($query_usuarios) {
    $mensagem = "Usuario apagado com sucesso!";
    $tipo = 'success';
    header('Location: listagem_usuarios.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
} else {
    $erro_mysql = mysqli_error($connx);
    $mensagem = "Não foi possível apagar o usuario!/nErro: " . $erro_mysql;
    $tipo = 'success';
    header('Location: listagem_usuarios.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
}
