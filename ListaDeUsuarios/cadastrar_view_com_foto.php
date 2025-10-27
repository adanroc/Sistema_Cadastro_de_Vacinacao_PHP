<?php
include '../validar.php';
include '../filtro_administrador.php';

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
    <link rel="stylesheet" href="cadastrar_estilo.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <?php
    if (isset($_GET['mensagem']) && isset($_GET['tipo'])) {
        $mensagem = $_GET['mensagem'];
        $tipo = $_GET['tipo'];
        mensagem($mensagem, $tipo);
    }
    ?>

    <?php include '../cabecalho_compartilhado.php' ?>

    <div class="container-fluid">

        <br>
        <h2 class="titulo-cadastro">Criar Usuario</h2>
        <!-- <h2>Criar Cadastro</h2> -->
        <!-- <hr class="linha-abaixo-titulo"> -->
        <br>
        <div class="cadastro-servidor-container">
            <!-- <form action="cadastrar.php" method="post" > -->
            <form action="cadastrar_com_foto.php" method="post" enctype="multipart/form-data">
                <legend>Dados do Usuario</legend>
                <!-- <hr> -->
                <div class="form-group">
                    <label for="nome">Nome <span class="obrigatorio">*</span></label>
                    <input type="text" name="nome" class="form-control" placeholder="Digite o nome..." required>
                </div>
                <div class="form-group">
                    <label for="login">Login <span class="obrigatorio">*</span></label>
                    <input type="text" name="login" class="form-control" placeholder="Digite o login..." required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha <span class="obrigatorio">*</span></label>
                    <input type="password" name="senha" class="form-control" placeholder="Digite a senha..." required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Digite o email...">
                </div>
                <div class="form-group">
                    <label for="cargo">Cargo</label>
                    <input type="text" name="cargo" class="form-control" placeholder="Digite o cargo...">
                </div>
                <div class="form-group">
                    <label for="setor">Setor</label>
                    <input type="text" name="setor" class="form-control" placeholder="Digite o setor...">
                </div>
                <div class="form-group">
                    <label for="unidade">Unidade <span class="obrigatorio">*</span></label>
                    <input type="text" name="unidade" class="form-control" placeholder="Digite a unidade..." required>
                </div>
                <div class="form-group">
                    <label for="municipio">Municipio</label>
                    <input type="text" name="municipio" class="form-control" placeholder="Digite o municipio...">
                </div>
                <div class="form-group">
                    <label for="perfil">Perfil <span class="obrigatorio">*</span></label>
                    <select name="perfil" class="form-control" required>
                        <option value="">Selecione o Perfil...</option>
                        <option value="1">Administrador</option>
                        <option value="2">Padrão</option>
                        <option value="3">Externo</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="fotoPerfil">Foto de Perfil</label>
                    <input type="file" name="fotoPerfil" class="form-control" accept="image/*">  
                </div>
                <p class="legenda_obrigatorio"><span class="obrigatorio">*</span> Campos Obrigatórios</p>

                <button type="submit" class="btn btn-primary">Cadastrar</button>
                <a href="listagem_usuarios.php" class="btn btn-secondary">Voltar</a>
            </form>
        </div>


    </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <?php include '../rodape_compartilhado.php' ?>

</body>

</html>