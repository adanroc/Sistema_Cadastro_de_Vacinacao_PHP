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

$fotoPerfil = $_FILES['fotoPerfil'];
// $nomeFotoPerfil = $fotoPerfil['nome'];
// $tipoFotoPerfil = $fotoPerfil['type'];
// $diretorioTempFotoPerfil = $fotoPerfil['tmp_name'];
// $erroFotoPerfil = $fotoPerfil['error'];
// $tamanhoFotoPerfil = $fotoPerfil['size'];

// var_dump($fotoPerfil);

// Codificar nome da foto para ele ser único (mesmo com mesmos nomes normais)
$nomeCodificadoFotoPerfil = mover_e_codificar_nome_unico_foto($fotoPerfil);

// Se ele não mandar nada, vai receber zero
if($nomeCodificadoFotoPerfil == 0){
    // Para armazenar nulo no banco de dados
    $nomeCodificadoFotoPerfil = null;
}

date_default_timezone_set('America/Sao_Paulo'); // Para o horário de Brasília
$dataCadastro = date('Y-m-d H:i:s');

//Criar uma string complemente aleatória
$token = bin2hex(openssl_random_pseudo_bytes(20));   
$secure = rand(1000000, 99999999999999); // Valor mínimo 1 milhão e máximo quantos noves quisermos

$online = date('Y-m-d H:i:s');

// Preparar inserção de dados no Bd
$recebendo_usuarios = "INSERT INTO ListaDeUsuarios (
    dataCadastro, nome, login, senha, email, cargo, setor, unidade, municipio, perfil, fotoPerfil, Online_, Token, Secure 
) VALUES (
    '$dataCadastro', '$nome', '$login', '$senha', '$email', '$cargo', '$setor','$unidade' , '$municipio', '$perfil', '$nomeCodificadoFotoPerfil', '$online', '$token', '$secure'
)";

// Validar query
$query_usuarios = mysqli_query($connx, $recebendo_usuarios);

// recupere o último ID com mysqli_insert_id()
// Por que mysqli_insert_id() é seguro mesmo com múltiplos usuários?
//O mysqli_insert_id() retorna o último ID gerado pela conexão atual. Isso significa:
// Mesmo que outros usuários estejam cadastrando ao mesmo tempo, cada conexão tem seu próprio último ID.
//Portanto, **desde que você use a mesma variável de conexão do INSERT, o ID retornado será exatamente daquele cadastro.
$idUsuario = mysqli_insert_id($connx);

// ou buscando esse usuário no banco (não necessário nesse caso)
// $consulta = "SELECT idUsuario FROM ListaDeUsuarios WHERE email = '$email' LIMIT 1";
// $resultado = mysqli_query($connx, $consulta);
// $usuario = mysqli_fetch_assoc($resultado);
// $idUsuario = $usuario['idUsuario'];


if ($query_usuarios) {    

    // Se for cadastrado e o usuário for recuperado, existir, criar os cookies
    $duracao = time() + (10 * 365 * 24 * 60 * 60); // 10 anos
    setcookie("ID", $idUsuario, $duracao);
    setcookie("TOKEN", $token, $duracao);
    setcookie("SECURE", $secure, $duracao);

    // só tenta mostrar a foto se ela for enviada
    if ($nomeCodificadoFotoPerfil != null){
    // echo "<img src='img_usuario/$nomeCodificadoFotoPerfil' title='$nomeCodificadoFotoPerfil'>";

    // echo "<img src=img_usuario/$nomeCodificadoFotoPerfil' title='$nomeCodificadoFotoPerfil' width:250px>";
    // echo "<img src=img_usuario/$nomeCodificadoFotoPerfil' title='$nomeCodificadoFotoPerfil' class='mostrar_foto'>";    
    }

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
