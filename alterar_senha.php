<?php

session_start();

// Obter dados de conexão
include '../conexao.php';

// Obter o ID do registro a ser editado
$idUsuario = $_POST['idUsuario'];

// Dados do servidor
$senhaAtual = md5($_POST['senhaAtual']);
$novaSenha = md5($_POST['novaSenha']);
$confirmarNovaSenha = md5($_POST['confirmarNovaSenha']);

date_default_timezone_set('America/Sao_Paulo'); // Para o horário de Brasília
$dataUltimaAlteracaoSenha = date('Y-m-d H:i:s');

// Primeiro, verifique se a nova senha e a confirmação são iguais
if ($novaSenha !== $confirmarNovaSenha) {
    $mensagem = "A nova senha e a confirmação não coincidem.";
    $tipo = 'danger';
    header('Location: listagem_usuarios.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
    exit();
}

// Verificar se a senha atual está correta no banco de dados
$query_verificar_senha = "SELECT senha FROM ListaDeUsuarios WHERE idUsuario = '$idUsuario'";
$resultado = mysqli_query($connx, $query_verificar_senha);

// Verifique se a consulta retornou um usuário válido
if (mysqli_num_rows($resultado) > 0) {
    $usuario = mysqli_fetch_assoc($resultado);

    // Verificar se a senha atual informada corresponde ao hash armazenado no banco de dados
    if ($usuario['senha'] === $senhaAtual) {
        // Se a senha atual estiver correta, proceda para atualizar a senha

        // Preparar o comando de atualização no Banco de Dados
        $recebendo_usuarios = "UPDATE ListaDeUsuarios
                                SET senha = '$novaSenha', dataUltimaAlteracaoSenha = '$dataUltimaAlteracaoSenha'
                                WHERE idUsuario = '$idUsuario'";

        // Validar se a query foi executada com sucesso
        $query_usuarios = mysqli_query($connx, $recebendo_usuarios);

        // Verificar se a query foi executada com sucesso
        if ($query_usuarios) {
            // Mensagem de sucesso e redirecionamento
            $mensagem = "Senha Alterada com sucesso!";
            $tipo = 'success';
            header('Location: ListaDeCadastros/listagem_cadastros.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
        } else {
            $erro_mysql = mysqli_error($connx);
            $mensagem = "Não foi possível alterar sua senha. Por favor, tente novamente!\nErro: " . $erro_mysql;
            $tipo = 'danger';
            header('Location: ListaDeCadastros/listagem_cadastros.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
        }
    } else {
        // Caso a senha atual não esteja correta
        $mensagem = "A senha atual informada está incorreta.";
        $tipo = 'danger';
        header('Location: ListaDeCadastros/listagem_cadastros.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
    }
} else {
    // Caso o usuário não seja encontrado no banco
    $mensagem = "Usuário não encontrado.";
    $tipo = 'danger';
    header('Location: ListaDeCadastros/listagem_cadastros.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
}
