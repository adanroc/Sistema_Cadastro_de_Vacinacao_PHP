<?php
include '../validar.php';

session_start();
//print_r($_SESSION);

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
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> -->
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
        <h2 class="titulo-cadastro">Criar Cadastro</h2>
        <!-- <h2>Criar Cadastro</h2> -->
        <!-- <hr class="linha-abaixo-titulo"> -->
        <br>
        <div class="cadastro-servidor-container">
            <form action="cadastrar.php" method="post">
                <legend>Dados do Servidor</legend>
                <!-- <hr> -->
                <div class="row">
                    <div class="form-group col-auto">
                        <label for="numMatricula">Número de Matrícula <span class="obrigatorio">*</span></label>
                        <input type="number" name="numMatricula" class="form-control" placeholder="Digite a matricula..." required>
                    </div>
                    <div class="form-group col-auto">
                        <label for="nome">Nome <span class="obrigatorio">*</span></label>
                        <input type="text" name="nome" class="form-control" placeholder="Digite o nome..." required>
                    </div>
                    <div class="form-group col-auto">
                        <label for="dataNascimento">Data de Nascimento</label>
                        <input type="date" name="dataNascimento" class="form-control">
                    </div>
                    <div class="form-group col-auto">
                        <label for="setor">Setor</label>
                        <input type="text" name="setor" class="form-control" placeholder="Digite o setor...">
                    </div>
                    <div class="form-group col-auto">
                        <label for="cargo">Cargo</label>
                        <input type="text" name="cargo" class="form-control" placeholder="Digite o cargo...">
                    </div>
                    <div class="form-group col-auto">
                        <label for="unidade">Unidade</label>
                        <input type="text" name="unidade" class="form-control" placeholder="Digite a unidade...">
                    </div>
                    <div class="form-group col-auto">
                        <label for="municipio">Município</label>
                        <input type="text" name="municipio" class="form-control" placeholder="Digite o município...">
                    </div>
                </div>

                <legend>Vacinação do servidor</legend>
                <!-- <hr> -->
                <div class="row">

                    <div class="col-auto">

                        <p class="subtitulo-vacinas">HEPATITE B (HB)</p>
                        <div class="form-group col-auto">
                            <label for="dataDose1HepatiteB">Data 1ªDose</label>
                            <input type="date" name="dataDose1HepatiteB" class="form-control">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDose2HepatiteB">Data 2ªDose</label>
                            <input type="date" name="dataDose2HepatiteB" class="form-control">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDose3HepatiteB">Data 3ªDose</label>
                            <input type="date" name="dataDose3HepatiteB" class="form-control">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDoseReforcoHepatiteB">Data Dose de Reforço</label>
                            <input type="date" name="dataDoseReforcoHepatiteB" class="form-control">
                        </div>

                    </div>

                    <div class="col-auto">

                        <p class="subtitulo-vacinas">EXAME ANTI-HBS</p>
                        <div class="form-group col-auto">
                            <label for="dataExameAntiHBS">Data do Exame</label>
                            <input type="date" name="dataExameAntiHBS" class="form-control">
                        </div>
                        <div class="form-group col-auto">
                            <label for="resultadoExameAntiHBS">Resultado</label>
                            <input type="text" name="resultadoExameAntiHBS" class="form-control" placeholder="Digite o resultado...">
                            <div id="resultadoExameAntiHBS" class="form-text">Reagente/Não Reagente</div>
                            <!-- <div id="resultadoExameAntiHBS" class="form-text">Intervalo de Referência: unidad de medida</div> -->
                        </div>

                    </div>

                    <div class="col-auto">

                        <p class="subtitulo-vacinas">DIFTERIA E TÉTANO (DT)</p>

                        <div class="form-group col-auto">
                            <label for="dataDose1DifteriaTetano">Data 1ªDose</label>
                            <input type="date" name="dataDose1DifteriaTetano" class="form-control">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDose2DifteriaTetano">Data 2ªDose</label>
                            <input type="date" name="dataDose2DifteriaTetano" class="form-control">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDose3DifteriaTetano">Data 3ªDose</label>
                            <input type="date" name="dataDose3DifteriaTetano" class="form-control">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDoseReforcoDifteriaTetano">Data Dose de Reforço</label>
                            <input type="date" name="dataDoseReforcoDifteriaTetano" class="form-control">
                        </div>
                    </div>

                    <div class="col-auto">

                        <p class="subtitulo-vacinas">TRÍPLICE VIRAL</p>

                        <div class="form-group col-auto">
                            <label for="dataDose1TripliceViral">Data 1ªDose</label>
                            <input type="date" name="dataDose1TripliceViral" class="form-control">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDose2TripliceViral">Data 2ªDose</label>
                            <input type="date" name="dataDose2TripliceViral" class="form-control">
                        </div>
                    </div>

                    <div class="col-auto">

                        <p class="subtitulo-vacinas">COVID-19</p>

                        <div class="form-group col-auto">
                            <label for="dataDose1Covid">Data 1ªDose</label>
                            <input type="date" name="dataDose1Covid" class="form-control">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDose2Covid">Data 2ªDose</label>
                            <input type="date" name="dataDose2Covid" class="form-control">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDose3Covid">Data 3ªDose</label>
                            <input type="date" name="dataDose3Covid" class="form-control">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDoseReforco1Covid">Data 1ª Dose de Reforço</label>
                            <input type="date" name="dataDoseReforco1Covid" class="form-control">
                        </div>
                        <div class="form-group col-auto">
                            <label for="dataDoseReforco2Covid">Data 2ª Dose de Reforço</label>
                            <input type="date" name="dataDoseReforco2Covid" class="form-control">
                        </div>
                    </div>

                    <div class="col-auto">

                        <p class="subtitulo-vacinas">FEBRE AMARELA</p>

                        <div class="form-group col-auto">
                            <label for="dataDoseUnicaFebreAmarela">Data Dose Única</label>
                            <input type="date" name="dataDoseUnicaFebreAmarela" class="form-control">
                        </div>
                    </div>

                    <div class="col-auto">

                        <p class="subtitulo-vacinas">INFLUENZA</p>

                        <div class="form-group col-auto">
                            <label for="dataDoseAnualInfluenza">Data Dose Anual</label>
                            <input type="date" name="dataDoseAnualInfluenza" class="form-control">
                        </div>

                    </div>
                </div>
                <p class="legenda_obrigatorio"><span class="obrigatorio">*</span> Campos Obrigatórios</p>

                <button type="submit" class="btn btn-primary">Cadastrar</button>
                <a href="listagem_cadastros.php" class="btn btn-secondary">Voltar</a>
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