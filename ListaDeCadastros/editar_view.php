<?php
include '../conexao.php';
include '../validar.php';

// $id_contador = $_GET['id_contador'];

// $id = $_GET['id'] ?? ''; //Funcionando em versões atuais e não funciona em versões anteriores
// Tratar e garantir que o 'id' seja um número inteiro
$idServidor = isset($_GET['idServidor']) ? intval($_GET['idServidor']) : 0;
if ($idServidor == 0) {
    // Se 'id' for 0 ou inválido, redirecionar ou exibir mensagem de erro
    die("ID inválido.");
}

// Preparar consulta SQL
$buscar_cadastros = "SELECT * FROM ListaDeCadastros WHERE idServidor = $idServidor";
$query_cadastros = mysqli_query($connx, $buscar_cadastros);

// Verificar se a consulta foi bem-sucedida
if (!$query_cadastros) {
    die("Erro na consulta SQL: " . mysqli_error($connx));
}

$cadastro = mysqli_fetch_assoc($query_cadastros);

// Verificar se o cadastro foi encontrado
if (!$cadastro) {
    die("Cadastro não encontrado.");
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

    <?php include '../cabecalho_compartilhado.php' ?>

    <div class="container-fluid">

        <br>
        <h2 class="titulo-cadastro">Editar Cadastro</h2>
        <!-- <h2>Criar Cadastro</h2> -->
        <!-- <hr class="linha-abaixo-titulo"> -->
        <br>
        <div class="cadastro-servidor-container">

            <!-- <form action="cadastrar.php" method="post">     -->
            <form action="editar.php" method="post" enctype="multipart/form-data">

                <legend>Dados do Servidor</legend>
                <!-- <hr> -->
                <div class="row">

                    <!-- <div class="form-group col-auto"> -->
                    <!-- <label for="id">Id</label> -->
                    <!-- <div id="id" class="form-control-plaintext border rounded p-2"><?php echo $cadastro['idServidor']; ?></div> -->

                    <!-- Não usado -->
                    <!-- <div id="id" class="form-control-plaintext border rounded p-2"><?php echo $cadastro['idServidor']; ?> <?php echo $id_contador; ?></div> -->
                    <!-- <div id="id" class="form-text border p-2">100</div> -->
                    <!-- <div id="id" class="form-text">100</div> -->
                    <!-- <div id="id" class="form-text"><?php echo $cadastro['idServidor']; ?></div> -->
                    <!-- </div> -->

                    <div class="form-group col-auto">
                        <label for="NumMatricula">Número de Matrícula <span class="obrigatorio">*</span></label>
                        <input type="number" id="numMatricula" name="numMatricula" class="form-control" value="<?php echo $cadastro['numMatricula']; ?>" placeholder="Digite a matricula..." required>
                    </div>

                    <div class="form-group col-auto">
                        <label for="nome">Nome <span class="obrigatorio">*</span></label>
                        <input type="text" name="nome" class="form-control" value="<?php echo $cadastro['nome']; ?>" placeholder="Digite o nome..." required>
                    </div>
                    <div class="form-group col-auto">
                        <label for="dataNascimento">Data de Nascimento</label>
                        <input type="date" name="dataNascimento" class="form-control" value="<?php echo mostrarDataEditar($cadastro['dataNascimento']); ?>">
                    </div>
                    <div class="form-group col-auto">
                        <label for="setor">Setor</label>
                        <input type="text" name="setor" class="form-control" value="<?php echo $cadastro['setor']; ?>" placeholder="Digite o setor...">
                    </div>
                    <div class="form-group col-auto">
                        <label for="cargo">Cargo</label>
                        <input type="text" name="cargo" class="form-control" value="<?php echo $cadastro['cargo']; ?>" placeholder="Digite o cargo...">
                    </div>
                    <div class="form-group col-auto">
                        <label for="unidade">Unidade <span class="obrigatorio">*</span></label>
                        <input type="text" name="unidade" class="form-control" value="<?php echo $cadastro['unidade']; ?>" placeholder="Digite a unidade...">
                    </div>
                    <div class="form-group col-auto">
                        <label for="municipio">Município</label>
                        <input type="text" name="municipio" class="form-control" value="<?php echo $cadastro['municipio']; ?>" placeholder="Digite o município...">
                    </div>
                </div>

                <legend>Vacinação do servidor</legend>
                <!-- <hr> -->
                <div class="row">

                    <div class="col-auto">

                        <p class="subtitulo-vacinas">HEPATITE B (HB)</p>
                        <div class="form-group col-auto">
                            <label for="dataDose1HepatiteB">Data 1ªDose</label>
                            <input type="date" name="dataDose1HepatiteB" class="form-control" value="<?php echo mostrarDataEditar($cadastro['dataDose1HepatiteB']); ?>">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDose2HepatiteB">Data 2ªDose</label>
                            <input type="date" name="dataDose2HepatiteB" class="form-control" value="<?php echo mostrarDataEditar($cadastro['dataDose2HepatiteB']); ?>">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDose3HepatiteB">Data 3ªDose</label>
                            <input type="date" name="dataDose3HepatiteB" class="form-control" value="<?php echo mostrarDataEditar($cadastro['dataDose3HepatiteB']); ?>">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDoseReforcoHepatiteB">Data Dose de Reforço</label>
                            <input type="date" name="dataDoseReforcoHepatiteB" class="form-control" value="<?php echo mostrarDataEditar($cadastro['dataDoseReforcoHepatiteB']); ?>">
                        </div>

                    </div>

                    <div class="col-auto">

                        <p class="subtitulo-vacinas">EXAME ANTI-HBS</p>
                        <div class="form-group col-auto">
                            <label for="dataExameAntiHBS">Data do Exame</label>
                            <input type="date" name="dataExameAntiHBS" class="form-control" value="<?php echo mostrarDataEditar($cadastro['dataExameAntiHBS']); ?>">
                        </div>
                        <div class="form-group col-auto">
                            <label for="resultadoExameAntiHBS">Resultado</label>
                            <input type="text" name="resultadoExameAntiHBS" class="form-control" value="<?php echo $cadastro['resultadoExameAntiHBS']; ?>" placeholder="Digite o resultado...">
                            <div id="resultadoExameAntiHBS" class="form-text">Reagente/Não Reagente</div>
                            <!-- <div id="resultadoExameAntiHBS" class="form-text">Intervalo de Referência: unidad de medida</div> -->
                        </div>

                    </div>

                    <div class="col-auto">

                        <p class="subtitulo-vacinas">DIFTERIA E TÉTANO (DT)</p>

                        <div class="form-group col-auto">
                            <label for="dataDose1DifteriaTetano">Data 1ªDose</label>
                            <input type="date" name="dataDose1DifteriaTetano" class="form-control" value="<?php echo mostrarDataEditar($cadastro['dataDose1DifteriaTetano']); ?>">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDose2DifteriaTetano">Data 2ªDose</label>
                            <input type="date" name="dataDose2DifteriaTetano" class="form-control" value="<?php echo mostrarDataEditar($cadastro['dataDose2DifteriaTetano']); ?>">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDose3DifteriaTetano">Data 3ªDose</label>
                            <input type="date" name="dataDose3DifteriaTetano" class="form-control" value="<?php echo mostrarDataEditar($cadastro['dataDose3DifteriaTetano']); ?>">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDoseReforcoDifteriaTetano">Data Dose de Reforço</label>
                            <input type="date" name="dataDoseReforcoDifteriaTetano" class="form-control" value="<?php echo mostrarDataEditar($cadastro['dataDoseReforcoDifteriaTetano']); ?>">
                        </div>
                    </div>

                    <div class="col-auto">

                        <p class="subtitulo-vacinas">TRÍPLICE VIRAL</p>

                        <div class="form-group col-auto">
                            <label for="dataDose1TripliceViral">Data 1ªDose</label>
                            <input type="date" name="dataDose1TripliceViral" class="form-control" value="<?php echo mostrarDataEditar($cadastro['dataDose1TripliceViral']); ?>">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDose2TripliceViral">Data 2ªDose</label>
                            <input type="date" name="dataDose2TripliceViral" class="form-control" value="<?php echo mostrarDataEditar($cadastro['dataDose2TripliceViral']); ?>">
                        </div>
                    </div>

                    <div class="col-auto">

                        <p class="subtitulo-vacinas">COVID-19</p>

                        <div class="form-group col-auto">
                            <label for="dataDose1Covid">Data 1ªDose</label>
                            <input type="date" name="dataDose1Covid" class="form-control" value="<?php echo mostrarDataEditar($cadastro['dataDose1Covid']); ?>">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDose2Covid">Data 2ªDose</label>
                            <input type="date" name="dataDose2Covid" class="form-control" value="<?php echo mostrarDataEditar($cadastro['dataDose2Covid']); ?>">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDose3Covid">Data 3ªDose</label>
                            <input type="date" name="dataDose3Covid" class="form-control" value="<?php echo mostrarDataEditar($cadastro['dataDose3Covid']); ?>">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDoseReforco1Covid">Data 1ª Dose de Reforço</label>
                            <input type="date" name="dataDoseReforco1Covid" class="form-control" value="<?php echo mostrarDataEditar($cadastro['dataDoseReforco1Covid']); ?>">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDoseReforco2Covid">Data 2ª Dose de Reforço</label>
                            <input type="date" name="dataDoseReforco2Covid" class="form-control" value="<?php echo mostrarDataEditar($cadastro['dataDoseReforco2Covid']); ?>">
                        </div>
                    </div>

                    <div class="col-auto">

                        <p class="subtitulo-vacinas">FEBRE AMARELA</p>

                        <div class="form-group col-auto">
                            <label for="dataDoseUnicaFebreAmarela">Data Dose Única</label>
                            <input type="date" name="dataDoseUnicaFebreAmarela" class="form-control" value="<?php echo mostrarDataEditar($cadastro['dataDoseUnicaFebreAmarela']); ?>">
                        </div>
                    </div>

                    <div class="col-auto">

                        <p class="subtitulo-vacinas">INFLUENZA</p>

                        <div class="form-group col-auto">
                            <label for="dataDoseAnualInfluenza">Data Dose Anual</label>
                            <input type="date" name="dataDoseAnualInfluenza" class="form-control" value="<?php echo mostrarDataEditar($cadastro['dataDoseAnualInfluenza']); ?>">
                        </div>

                    </div>
                </div>
                <p class="legenda_obrigatorio"><span class="obrigatorio">*</span> Campos Obrigatórios</p>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Alterar">
                    <input type="hidden" name="idServidor" value="<?php echo $cadastro['idServidor']; ?>">
                    <a href="listagem_cadastros.php" class="btn btn-secondary">Voltar</a>
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