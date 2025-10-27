<?php

// Obter dados de conexão
include '../conexao.php';

// Obter o ID do registro a ser editado
$idUsuario = $_POST['idUsuario'];

// Dados do servidor
$nome = $_POST['nome'];
$login = $_POST['login'];
// $senha = md5($_POST['senha']);
$email = $_POST['email'];
$cargo = $_POST['cargo'];
$setor = $_POST['setor'];
$unidade = $_POST['unidade'];
$municipio = $_POST['municipio'];
$perfil = $_POST['perfil'];

// Hora errada(fuso horário errado), minutos e segundos corretos 
// $dataUltimaEdicao = date('Y-m-d H:i:s');

date_default_timezone_set('America/Sao_Paulo'); // Para o horário de Brasília
$dataUltimaEdicao = date('Y-m-d H:i:s');
// $dataUltimaEdicao = date('d/m/Y H:i:s', time());


// Preparar o comando de atualização no Banco de Dados
$recebendo_usuarios = "UPDATE ListaDeUsuarios
SET 
    dataUltimaEdicao = '$dataUltimaEdicao',
    nome = '$nome', 
    login = '$login',
    -- senha = '$senha', 
    email = '$email', 
    cargo = '$cargo',
    setor = '$setor',
    unidade = '$unidade',
    municipio = '$municipio',
    perfil = '$perfil'
WHERE idUsuario = '$idUsuario'";

// Validar se a query foi executada com sucesso
$query_usuarios = mysqli_query($connx, $recebendo_usuarios);

// Verificar se a query foi executada com sucesso
if ($query_usuarios) {
    // Mensagem de sucesso e redirecionamento
    $mensagem = "Usuário editado com sucesso!";
    $tipo = 'success';
    header('Location: listagem_usuarios.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
} else {
    $erro_mysql = mysqli_error($connx);
    $mensagem = "Não foi possível editar o Usuário!\nErro: " . $erro_mysql;
    $tipo = 'danger';
    header('Location: listagem_usuarios.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
}

exit();
