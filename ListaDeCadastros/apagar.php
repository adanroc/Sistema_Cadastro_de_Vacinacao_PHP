<?php

// Obter dados de conexão
include '../conexao.php';

// Obter dados dos campos preenchidos
$idServidor = $_POST['idServidor'];

// Preparar inserção de dados no Bd
$recebendo_cadastros = "DELETE FROM
                        ListaDeCadastros
                        WHERE idServidor = '$idServidor'";

// Validar query
$query_cadastros = mysqli_query($connx, $recebendo_cadastros);

// Verificar se a query foi executada com sucesso
if ($query_cadastros) {
    $mensagem = "Cadastro apagado com sucesso!";
    $tipo = 'success';
    header('Location: listagem_cadastros.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
} else {
    $erro_mysql = mysqli_error($connx);
    $mensagem = "Não foi possível apagar o cadastro!/nErro: " . $erro_mysql;
    $tipo = 'success';
    header('Location: listagem_cadastros.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
}
