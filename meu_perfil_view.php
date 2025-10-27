<?php

session_start();

include 'conexao.php';
include 'validar.php';

// $idUsuario = $_GET['idUsuario'] ?? ''; //Funcionando em versões atuais e não funciona em versões anteriores

// Funcionando em versões anteriores
// Tratar e garantir que o 'id' seja um número inteiro
$idUsuario = isset($_GET['idUsuario']) ? intval($_GET['idUsuario']) : 0;
if ($idUsuario == 0) {
    // Se 'id' for 0 ou inválido, redirecionar ou exibir mensagem de erro
    die("ID inválido.");
}

// Preparar consulta SQL
$buscar_usuarios = "SELECT * FROM ListaDeUsuarios WHERE idUsuario = $idUsuario";
$query_usuarios = mysqli_query($connx, $buscar_usuarios);

// Verificar se a consulta foi bem-sucedida
if (!$query_usuarios) {
    die("Erro na consulta SQL: " . mysqli_error($connx));
}

$usuario = mysqli_fetch_assoc($query_usuarios);

// Verificar se o cadastro foi encontrado
if (!$usuario) {
    die("Usuário não encontrado.");
}

$protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$servidor = $_SERVER['HTTP_HOST'];
$basePath = "/SisSASS";
$baseURL = "$protocolo://$servidor$basePath";

?>

<!doctype html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="<?php echo $baseURL; ?>/icone-hemopa.ico" type="image/x-icon">
    <title>SisSASS</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="meu_perfil_estilo.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> <!-- FontAwesome (caso precise de ícones) -->
</head>

<body>

    <?php
    if (isset($_GET['mensagem']) && isset($_GET['tipo'])) {
        $mensagem = $_GET['mensagem'];
        $tipo = $_GET['tipo'];
        mensagem($mensagem, $tipo);
    }
    ?>

    <?php include 'cabecalho_compartilhado.php' ?>

    <?php
    // Capturar o perfil do usuário
    if($usuario['perfil'] == '1'){
        $perfilUsuario = 'Administrador';
    } elseif ($usuario['perfil'] == '2') {
        $perfilUsuario = 'Padrão';
    } elseif ($usuario['perfil'] == '3'){
        $perfilUsuario = 'Externo';
    } else {
        $perfilUsuario = '';
    }
    ?>

    <div class="container-fluid">
        <br>
        <h2 class="titulo-cadastro">Meu Perfil</h2>        
        <p style="font-size: 15;">Atenção! Para atualizar seu perfil, por favor, contatar o Administrador do Sistema.</p>
        <div class="cadastro-servidor-container">

            <form action="" method="post">

                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" class="form-control" value="<?php echo $usuario['nome']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="login">Login</label>
                    <input type="text" name="login" class="form-control" value="<?php echo $usuario['login']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $usuario['email']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="cargo">Cargo</label>
                    <input type="cargo" name="cargo" class="form-control" value="<?php echo $usuario['cargo']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="setor">Setor</label>
                    <input type="setor" name="setor" class="form-control" value="<?php echo $usuario['setor']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="unidade">Unidade</label>
                    <input type="unidade" name="unidade" class="form-control" value="<?php echo $usuario['unidade']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="municipio">Municipio</label>
                    <input type="municipio" name="municipio" class="form-control" value="<?php echo $usuario['municipio']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="perfil">Perfil</label>
                    <input type="perfil" name="perfil" class="form-control" value="<?php echo $perfilUsuario;?>" readonly>
                </div>

                <div class="form-group">
                    <!-- <input type="submit" class="btn btn-primary" value="Alterar"> -->
                    <!-- <input type="hidden" name="idUsuario" value="<?php echo $usuario['idUsuario']; ?>"> -->
                    <a href="ListaDeCadastros/listagem_cadastros.php" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
        </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <?php include 'rodape_compartilhado.php' ?>

</body>

</html>