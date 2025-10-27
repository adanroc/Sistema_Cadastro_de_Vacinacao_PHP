<?php
include '../conexao.php';
include '../validar.php';
include '../filtro_administrador.php';

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
    <link rel="stylesheet" href="editar_estilo.css">
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
        <h2 class="titulo-cadastro">Editar Usuário</h2>
        <!-- <h2>Criar Cadastro</h2> -->
        <!-- <hr class="linha-abaixo-titulo"> -->
        <br>
        <div class="cadastro-servidor-container">

            <!-- <form action="cadastrar.php" method="post">     -->
            <form action="editar.php" method="post">

                <!-- <div class="form-group col-auto"> -->
                <!-- <label for="id">Id</label> -->
                <!-- <div id="id" class="form-control-plaintext border rounded p-2"><?php echo $usuario['idUsuario']; ?></div> -->

                <!-- Não usado -->
                <!-- <div id="id" class="form-text border p-2">100</div> -->
                <!-- <div id="id" class="form-text">100</div> -->
                <!-- <div id="id" class="form-text"><?php echo $usuario['idUsuario']; ?></div> -->
                <!-- </div> -->
                <!-- <hr> -->
                <div class="form-group">
                    <label for="nome">Nome <span class="obrigatorio">*</span></label>
                    <input type="text" name="nome" class="form-control" value="<?php echo $usuario['nome']; ?>" placeholder="Digite o nome..." required>
                </div>
                <div class="form-group">
                    <label for="login">Login <span class="obrigatorio">*</span></label>
                    <input type="text" name="login" class="form-control" value="<?php echo $usuario['login']; ?>" placeholder="Digite o login..." required>
                </div>
                <!-- <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" class="form-control" value="<?php echo $usuario['senha']; ?>" placeholder="Digite a senha..." required>
                </div> -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $usuario['email']; ?>" placeholder="Digite o email...">
                </div>
                <div class="form-group">
                    <label for="cargo">Cargo</label>
                    <input type="cargo" name="cargo" class="form-control" value="<?php echo $usuario['cargo']; ?>" placeholder="Digite o cargo...">
                </div>
                <div class="form-group">
                    <label for="setor">Setor</label>
                    <input type="setor" name="setor" class="form-control" value="<?php echo $usuario['setor']; ?>" placeholder="Digite o setor...">
                </div>
                <div class="form-group">
                    <label for="unidade">Unidade <span class="obrigatorio">*</span></label>
                    <input type="unidade" name="unidade" class="form-control" value="<?php echo $usuario['unidade']; ?>" placeholder="Digite a unidade..." required>
                </div>
                <div class="form-group">
                    <label for="municipio">Municipio</label>
                    <input type="municipio" name="municipio" class="form-control" value="<?php echo $usuario['municipio']; ?>" placeholder="Digite o municipio...">
                </div>
                <div class="form-group">
                    <label for="perfil">Perfil <span class="obrigatorio">*</span></label>
                    <select name="perfil" class="form-control" required>
                        <option value="">Selecione o Perfil...</option>
                        <option value="1" <?php echo ($usuario['perfil'] == '1') ? 'selected' : ''; ?>>Administrador</option>
                        <option value="2" <?php echo ($usuario['perfil'] == '2') ? 'selected' : ''; ?>>Padrão</option>
                        <option value="3" <?php echo ($usuario['perfil'] == '3') ? 'selected' : ''; ?>>Externo</option>
                    </select>
                </div>

                <p class="legenda_obrigatorio"><span class="obrigatorio">*</span> Campos Obrigatórios</p>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Alterar">
                    <input type="hidden" name="idUsuario" value="<?php echo $usuario['idUsuario']; ?>">
                    <a href="listagem_usuarios.php" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
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