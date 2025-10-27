<?php
include 'conexao.php';

session_start();

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
    <link rel="stylesheet" href="alterar_senha_estilo.css">
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

    <div class="container-fluid">
        <br>
        <h2 class="titulo-cadastro">Alterar Senha</h2>
        <!-- <h2>Criar Cadastro</h2> -->
        <!-- <hr class="linha-abaixo-titulo"> -->
        <br>
        <div class="cadastro-servidor-container">

            <div class="form-group">
                <label for="nome">Nome do Usuário</label>
                <input type="text" name="nome" class="form-control" value="<?php echo $_SESSION['nome']; ?>" readonly>
            </div>
            <form action="alterar_senha.php" method="post">
                <!-- <hr> -->
                <div class="form-group">
                    <label for="senhaAtual">Senha Atual <span class="obrigatorio">*</span></label>
                    <input type="password" name="senhaAtual" class="form-control" placeholder="Digite sua senha atual..." required>
                </div>
                <div class="form-group">
                    <label for="novaSenha">Nova Senha <span class="obrigatorio">*</span></label>
                    <input type="password" name="novaSenha" class="form-control" placeholder="Digite uma nova senha..." required>
                </div>
                <div class="form-group">
                    <label for="confirmarNovaSenha">Confirmar Nova Senha <span class="obrigatorio">*</span></label>
                    <input type="password" name="confirmarNovaSenha" class="form-control" placeholder="Digite novamente a nova senha para confirmação..." required>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Alterar Senha">
                    <input type="hidden" name="idUsuario" value="<?php echo $_SESSION['idUsuario']; ?>">
                    <!-- <input type="hidden" name="idUsurario" value="<?php echo $usuario['idUsuario']; ?>"> -->
                    <a href="ListaDeCadastros/listagem_cadastros.php" class="btn btn-secondary">Voltar</a>
                </div>
                <p class="legenda_obrigatorio"><span class="obrigatorio">*</span> Campos Obrigatórios</p>
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