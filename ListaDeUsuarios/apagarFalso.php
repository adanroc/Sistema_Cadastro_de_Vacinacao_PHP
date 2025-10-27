<?php

// Obter dados de conexão
include '../conexao.php';

// Obter dados dos campos preenchidos
$idUsuario = $_POST['idUsuario'];

// Hora errada, minutos e segundos corretos
// $dataApagado = date('Y-m-d H:i:s');

date_default_timezone_set('America/Sao_Paulo'); // Para o horário de Brasília
$dataApagado = date('Y-m-d H:i:s');
// $dataApagado = date('d/m/Y H:i:s', time());

// Preparar inserção de dados no Bd
$recebendo_usuarios = "UPDATE ListaDeUsuarios 
                         SET apagadoFalso = '1', dataApagado = '$dataApagado' 
                         WHERE idUsuario = '$idUsuario'";

// Validar query
$query_usuarios = mysqli_query($connx, $recebendo_usuarios);

// Verificar se a query foi executada com sucesso
if ($query_usuarios) {
    $mensagem = "Usuário apagado com sucesso!";
    $tipo = 'success';
    header('Location: listagem_usuarios.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
} else {
    $erro_mysql = mysqli_error($connx);
    $mensagem = "Não foi possível apagar o Usuário!/nErro: " . $erro_mysql;
    $tipo = 'success';
    header('Location: listagem_usuarios.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
}
