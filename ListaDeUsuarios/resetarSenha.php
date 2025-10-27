<?php

// Obter dados de conexão
include '../conexao.php';

// Obter o ID do registro a ser editado
$idUsuario = $_POST['idUsuario'];

// Definir a nova senha fixa como "hemopa123"
$novaSenha = md5('123');

date_default_timezone_set('America/Sao_Paulo'); // Para o horário de Brasília
$dataUltimoResetSenha = date('Y-m-d H:i:s');

// Preparar o comando de atualização no Banco de Dados
$recebendo_usuarios = "UPDATE ListaDeUsuarios
                        SET senha = '$novaSenha', dataUltimoResetSenha = '$dataUltimoResetSenha'
                        WHERE idUsuario = '$idUsuario'";

// Validar se a query foi executada com sucesso
$query_usuarios = mysqli_query($connx, $recebendo_usuarios);

// Verificar se a query foi executada com sucesso
if ($query_usuarios) {
    // Mensagem de sucesso e redirecionamento
    $mensagem = "Senha resetada com sucesso!";
    $tipo = 'success';
    header('Location: listagem_usuarios.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
} else {
    $erro_mysql = mysqli_error($connx);
    $mensagem = "Não foi possível resetar a senha. Por favor, tente novamente!\nErro: " . $erro_mysql;
    $tipo = 'danger';
    header('Location: listagem_usuarios.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
}

// exit();
