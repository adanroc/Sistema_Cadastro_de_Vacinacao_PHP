<?php

session_start();

// Obter dados de conexão
include '../conexao.php';

// Dados do servidor
$nome = $_POST['nome'];
$login = $_POST['login'];
$senha = md5($_POST['senha']);
$email = $_POST['email'];
$cargo = $_POST['cargo'];
$setor = $_POST['setor'];
$unidade = $_POST['unidade'];
$municipio = $_POST['municipio'];
$perfil = $_POST['perfil'];

date_default_timezone_set('America/Sao_Paulo'); // Para o horário de Brasília
$dataCadastro = date('Y-m-d H:i:s');

// Preparar inserção de dados no Bd
$recebendo_usuarios = "INSERT INTO ListaDeUsuarios (
    dataCadastro, nome, login, senha, email, cargo, setor, unidade, municipio, perfil 
) VALUES (
    '$dataCadastro', '$nome', '$login', '$senha', '$email', '$cargo', '$setor','$unidade' , '$municipio', '$perfil'
)";

// Validar query
$query_usuarios = mysqli_query($connx, $recebendo_usuarios);

if ($query_usuarios) {
    $mensagem = "Usuário cadastrado com sucesso!";
    $tipo = 'success';
    header('Location: listagem_usuarios.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
} else {
    $erro_mysql = mysqli_error($connx);
    $mensagem = "Não foi possível cadastrar o Usuário!\nErro: " . $erro_mysql;
    $tipo = 'danger';
    // header('Location: cadastrar_view.php');
    header('Location: listagem_usuarios.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
    // header("Refresh: 0; url=cadastrar_view.php?mensagem=" . urlencode($mensagem) . "&tipo=" . $tipo);
}
