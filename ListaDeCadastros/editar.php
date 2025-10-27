<?php

session_start(); // Inicia a sessão

// Obter dados de conexão
include '../conexao.php';

// Obter o ID do registro a ser editado
$idServidor = $_POST['idServidor'];

// Obter os dados preenchidos no formulário de edição
$nome = $_POST['nome'];
$numMatricula = $_POST['numMatricula'];
$dataNascimento = evitarDataHoraVazia($_POST['dataNascimento']);
$setor = $_POST['setor'];
$cargo = $_POST['cargo'];
$unidade = $_POST['unidade'];
$municipio = $_POST['municipio'];
$dataDose1HepatiteB = evitarDataHoraVazia($_POST['dataDose1HepatiteB']);
$dataDose2HepatiteB = evitarDataHoraVazia($_POST['dataDose2HepatiteB']);
$dataDose3HepatiteB = evitarDataHoraVazia($_POST['dataDose3HepatiteB']);
$dataDoseReforcoHepatiteB = evitarDataHoraVazia($_POST['dataDoseReforcoHepatiteB']);
$dataExameAntiHBS = evitarDataHoraVazia($_POST['dataExameAntiHBS']);
$resultadoExameAntiHBS = $_POST['resultadoExameAntiHBS'];
$dataDose1DifteriaTetano = evitarDataHoraVazia($_POST['dataDose1DifteriaTetano']);
$dataDose2DifteriaTetano = evitarDataHoraVazia($_POST['dataDose2DifteriaTetano']);
$dataDose3DifteriaTetano = evitarDataHoraVazia($_POST['dataDose3DifteriaTetano']);
$dataDoseReforcoDifteriaTetano = evitarDataHoraVazia($_POST['dataDoseReforcoDifteriaTetano']);
$dataDose1TripliceViral = evitarDataHoraVazia($_POST['dataDose1TripliceViral']);
$dataDose2TripliceViral = evitarDataHoraVazia($_POST['dataDose2TripliceViral']);
$dataDose1Covid = evitarDataHoraVazia($_POST['dataDose1Covid']);
$dataDose2Covid = evitarDataHoraVazia($_POST['dataDose2Covid']);
$dataDose3Covid = evitarDataHoraVazia($_POST['dataDose3Covid']);
$dataDoseReforco1Covid = evitarDataHoraVazia($_POST['dataDoseReforco1Covid']);
$dataDoseReforco2Covid = evitarDataHoraVazia($_POST['dataDoseReforco2Covid']);
$dataDoseUnicaFebreAmarela = evitarDataHoraVazia($_POST['dataDoseUnicaFebreAmarela']);
$dataDoseAnualInfluenza = evitarDataHoraVazia($_POST['dataDoseAnualInfluenza']);

$IdUsuarioUltimaEdicao = $_SESSION['idUsuario'];

date_default_timezone_set('America/Sao_Paulo'); // Para o horário de Brasília
$dataUltimaEdicao = date('Y-m-d H:i:s');

// Verificar se já existe cadastro com a mesma matrícula (exceto o próprio cadastro)
$query_check_matricula = "SELECT COUNT(*) AS total FROM ListaDeCadastros WHERE numMatricula = '$numMatricula' AND apagadoFalso = '0' AND idServidor != '$idServidor'";
$result_check_matricula = mysqli_query($connx, $query_check_matricula);
$row = mysqli_fetch_assoc($result_check_matricula);

if ($row['total'] > 0) {
    // Já existe um cadastro com o mesmo número de matrícula
    $mensagem = "Erro: Já existe outro cadastro com esta matrícula!";
    $tipo = 'danger';
    header('Location: listagem_cadastros.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
    exit();
}

// Verificar se já existe cadastro idêntico (mesmo dados de servidor)
$query_check_identico = "SELECT COUNT(*) AS total FROM ListaDeCadastros WHERE nome = '$nome' AND numMatricula = '$numMatricula' AND dataNascimento = '$dataNascimento' AND setor = '$setor' AND cargo = '$cargo' AND unidade = '$unidade' AND municipio = '$municipio' AND apagadoFalso = '0' AND idServidor != '$idServidor'";
$result_check_identico = mysqli_query($connx, $query_check_identico);
$row_identico = mysqli_fetch_assoc($result_check_identico);

if ($row_identico['total'] > 0) {
    // Já existe um cadastro idêntico
    $mensagem = "Erro: Já existe um servidor cadastrado idêntico!";
    $tipo = 'danger';
    header('Location: listagem_cadastros.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
    exit();
}

// Verificar se já existe cadastro idêntico (todos os campos)
$query_check_identico = "SELECT COUNT(*) AS total FROM ListaDeCadastros WHERE 
    nome = '$nome' AND 
    numMatricula = '$numMatricula' AND 
    dataNascimento = '$dataNascimento' AND 
    setor = '$setor' AND 
    cargo = '$cargo' AND 
    unidade = '$unidade' AND
    municipio = '$municipio' AND
    dataDose1HepatiteB = '$dataDose1HepatiteB' AND 
    dataDose2HepatiteB = '$dataDose2HepatiteB' AND 
    dataDose3HepatiteB = '$dataDose3HepatiteB' AND 
    dataDoseReforcoHepatiteB = '$dataDoseReforcoHepatiteB' AND 
    dataExameAntiHBS = '$dataExameAntiHBS' AND 
    resultadoExameAntiHBS = '$resultadoExameAntiHBS' AND 
    dataDose1DifteriaTetano = '$dataDose1DifteriaTetano' AND 
    dataDose2DifteriaTetano = '$dataDose2DifteriaTetano' AND 
    dataDose3DifteriaTetano = '$dataDose3DifteriaTetano' AND 
    dataDoseReforcoDifteriaTetano = '$dataDoseReforcoDifteriaTetano' AND 
    dataDose1TripliceViral = '$dataDose1TripliceViral' AND 
    dataDose2TripliceViral = '$dataDose2TripliceViral' AND 
    dataDose1Covid = '$dataDose1Covid' AND 
    dataDose2Covid = '$dataDose2Covid' AND 
    dataDose3Covid = '$dataDose3Covid' AND 
    dataDoseReforco1Covid = '$dataDoseReforco1Covid' AND 
    dataDoseReforco2Covid = '$dataDoseReforco2Covid' AND 
    dataDoseUnicaFebreAmarela = '$dataDoseUnicaFebreAmarela' AND 
    dataDoseAnualInfluenza = '$dataDoseAnualInfluenza' AND
    apagadoFalso = '0'";

$result_check_identico = mysqli_query($connx, $query_check_identico);
$row_identico = mysqli_fetch_assoc($result_check_identico);

if ($row_identico['total'] > 0) {
    // Já existe um cadastro idêntico
    $mensagem = "Erro: Você não alterou nenhum dado do cadastro!";
    $tipo = 'danger';
    header('Location: listagem_cadastros.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
    exit();
}

// Preparar o comando de atualização no Banco de Dados
$recebendo_cadastros = "UPDATE ListaDeCadastros
SET 
    IdUsuarioUltimaEdicao = '$IdUsuarioUltimaEdicao',
    dataUltimaEdicao = '$dataUltimaEdicao',
    nome = '$nome', 
    numMatricula = '$numMatricula',
    dataNascimento = '$dataNascimento', 
    setor = '$setor', 
    cargo = '$cargo',
    unidade = '$unidade',
    municipio = '$municipio',
    dataDose1HepatiteB = '$dataDose1HepatiteB', 
    dataDose2HepatiteB = '$dataDose2HepatiteB', 
    dataDose3HepatiteB = '$dataDose3HepatiteB', 
    dataDoseReforcoHepatiteB = '$dataDoseReforcoHepatiteB',
    dataExameAntiHBS = '$dataExameAntiHBS', 
    resultadoExameAntiHBS = '$resultadoExameAntiHBS',
    dataDose1DifteriaTetano = '$dataDose1DifteriaTetano', 
    dataDose2DifteriaTetano = '$dataDose2DifteriaTetano', 
    dataDose3DifteriaTetano = '$dataDose3DifteriaTetano', 
    dataDoseReforcoDifteriaTetano = '$dataDoseReforcoDifteriaTetano',
    dataDose1TripliceViral = '$dataDose1TripliceViral', 
    dataDose2TripliceViral = '$dataDose2TripliceViral', 
    dataDose1Covid = '$dataDose1Covid', 
    dataDose2Covid = '$dataDose2Covid', 
    dataDose3Covid = '$dataDose3Covid', 
    dataDoseReforco1Covid = '$dataDoseReforco1Covid', 
    dataDoseReforco2Covid = '$dataDoseReforco2Covid', 
    dataDoseUnicaFebreAmarela = '$dataDoseUnicaFebreAmarela', 
    dataDoseAnualInfluenza = '$dataDoseAnualInfluenza'
WHERE idServidor = '$idServidor'";

// Validar se a query foi executada com sucesso
$query_cadastros = mysqli_query($connx, $recebendo_cadastros);

// Verificar se a query foi executada com sucesso
if ($query_cadastros) {
    // Mensagem de sucesso e redirecionamento
    $mensagem = "Cadastro editado com sucesso!";
    $tipo = 'success';
    header('Location: listagem_cadastros.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
} else {
    $erro_mysql = mysqli_error($connx);
    $mensagem = "Não foi possível editar o cadastro!\nErro: " . $erro_mysql;
    $tipo = 'danger';
    header('Location: listagem_cadastros.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
}

exit();
