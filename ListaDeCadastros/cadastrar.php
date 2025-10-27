<?php

session_start();

// Obter dados de conexão
include '../conexao.php';

// Dados do servidor
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

// ---------------------- Forma de validar dados e cadastrar ----------------------

// if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["repPassword"])) {
//    $username = $_POST["username"];
//    $email = $_POST["email"];
//    $password = $_POST["password"];
//    $repPassword = $_POST["repPassword"];

//    if($username == "" || $email == "" || $password == "" || $repPassword == ""){
//         die(header("HTTP/1.0 401 Preencha todos os campos do formulário"));
//    }

//    $checkUsername = $connx->prepare("SELECT Id FROM User WHERE Username = ? LIMIT 1");
//    $checkUsername->bind_param("s", $username);
//    $checkUsername->execute();
//    $count = $checkUsername->get_result()->num_rows;
//    if($count > 0) {
//     die(header("HTTP/1.0 401 Este username já existe"));
//    }

//    $checkEmail = $connx->prepare("SELECT Id FROM User WHERE Email = ? LIMIT 1");
//    $checkEmail->bind_param("s", $email);
//    $checkEmail->execute();
//    $count = $checkEmail->get_result()->num_rows;
//    if($count > 0) {
//     die(header("HTTP/1.0 401 Conta com esse email já existe"));
//    }

//    if($password !=repPasswor){
//     die(header("HTTP/1.0 401 Senhas diferentes"));
//     // Debug
//     die(header("HTTP/1.0 401".$password"".$repPassword"));
//    }

//    $password = password_hash($password, PASSWORD_DEFAULT);

//    $token = bin2hex(openssl_random_pseudo_bytes(20));
//    $secure = rand(1000000, 99999999999);

//    $stmt = $connx->prepare("INSERT INTO User (Username, Email, Password, Online, Token, Secure, Creation)
//                           VALUES (?, ?, ?, now(), ?, ?, now())");
//    $stmt->bind_param("ssssi",$username,$email,$password,$token,$secure);
//    $stmt->execute();

//    $GetUser = $connx->prepare("SELECT Id WHERE Email = ? LIMIT 1");
//    $GetUser->bind_param("s", $email);
//    $GetUser->execute();
//    $user = $GetUser->get_result()->fetch_assoc();

//    if($stmt && $user){
//      setcookie("ID", $user["Id"], time() + (10*365*24*60*60));
//      setcookie("TOKEN", $token, time() + (10*365*24*60*60));
//      setcookie("SECURE", $secure, time() + (10*365*24*60*60));
//      return true;
//    } else {
//      die(header("HTTP/1.0 401 Ocorreu um erro no banco de dados"));                    
//    }

// } else {
//     die(header("HTTP/1.0 401 Formulário de autenticação inválida"));
// }


// Upload de imagem
// include ('check.php');

// if($_SERVER['RESQUEST_METHOD'] == 'POST'){
//     $imagename = $username."_".rand(999, 999999).$_FILES['imgInp']['name'];
//     // dados temporários da imagem
//     $imagetemp = $_FILES['imgInp']['tmp_name']; 
//     $imagePath = "../profilePics/";

//     if(is_uploaded_file($imagetemp)){
//         if(move_uploaded_file($imagetemp, $imagePath.$imagename)){
//             $stmt = $connx->prepare("UPDATE User SET 'Picture' = ? WHERE Id = ?");
//             $stmt->bind_param("si", $imagename, $uid);
//             $stmt->execute();
//             if(!$stmt){
//                 die(header("HTTP/1.0 401 Erro ao guardar imagem na base de dados"));
//             }
//         } else {
//             die(header("HTTP/1.0 401 Erro ao salvar da imagem"));
//         }
//     } else {
//         die(header("HTTP/1.0 401 Erro no upload da imagem"));
//     } 
// } else {
//     die(header("HTTP/1.0 401 Faltam parâmetros"));
// }


// Pega o Id do usuário que o cadastrou
$IdUsuarioCadastrou = $_SESSION['idUsuario'];
// Obtém a data e hora atual no formato correto para o MySQL
date_default_timezone_set('America/Sao_Paulo'); // Para o horário de Brasília
$dataCadastro = date('Y-m-d H:i:s');

// // Nome do usuário que está realizando o cadastro, seu cargo, setor ou unidade
// if (strtolower($_SESSION['setor']) == 'sass') {
//     // Se o cargo for 'SisSASS' (ignorando case sensitive), concatenar com o setor
//     $usuarioCadastrador = $_SESSION['nome'] . '/' . $_SESSION['setor'];  // Concatenando nome e setor
// } else {
//     // Caso contrário, concatenar com a unidade
//     $usuarioCadastrador = $_SESSION['nome'] . '/' . $_SESSION['unidade'];  // Concatenando nome e unidade
// }


// Verificar se já existe cadastro com a mesma matrícula
$query_check_matricula = "SELECT COUNT(*) AS total FROM ListaDeCadastros WHERE numMatricula = '$numMatricula' AND apagadoFalso = '0'";
$result_check_matricula = mysqli_query($connx, $query_check_matricula);
$row = mysqli_fetch_assoc($result_check_matricula);

if ($row['total'] > 0) {
    // Já existe um cadastro com o mesmo número de matrícula
    $mensagem = "Erro: Já existe um cadastro com esta matrícula!";
    $tipo = 'danger';
    header('Location: listagem_cadastros.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
    exit();
}

// Verificar se já existe cadastro idêntico (mesmo dados de servidor)
$query_check_identico = "SELECT COUNT(*) AS total FROM ListaDeCadastros WHERE nome = '$nome' AND numMatricula = '$numMatricula' AND dataNascimento = '$dataNascimento' AND setor = '$setor' AND cargo = '$cargo'  AND unidade = '$unidade' AND municipio = '$municipio' AND apagadoFalso = '0'";
$result_check_identico = mysqli_query($connx, $query_check_identico);
$row_identico = mysqli_fetch_assoc($result_check_identico);

if ($row_identico['total'] > 0) {
    // Já existe um cadastro idêntico
    $mensagem = "Erro: Já existe um servidor cadastrado!";
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
    $mensagem = "Erro: Já existe um cadastro idêntico com todos os dados identicos)!";
    $tipo = 'danger';
    header('Location: listagem_cadastros.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
    exit();
}

// Preparar inserção de dados no Bd
$recebendo_cadastros = "INSERT INTO ListaDeCadastros (
    nome, numMatricula, IdUsuarioCadastrou, dataCadastro, dataNascimento, setor, cargo, unidade, municipio,
    dataDose1HepatiteB, dataDose2HepatiteB, dataDose3HepatiteB, dataDoseReforcoHepatiteB,
    dataExameAntiHBS, resultadoExameAntiHBS,
    dataDose1DifteriaTetano, dataDose2DifteriaTetano, dataDose3DifteriaTetano, dataDoseReforcoDifteriaTetano,
    dataDose1TripliceViral, dataDose2TripliceViral, 
    dataDose1Covid, dataDose2Covid, dataDose3Covid, dataDoseReforco1Covid, dataDoseReforco2Covid, 
    dataDoseUnicaFebreAmarela, dataDoseAnualInfluenza
) VALUES (
    '$nome', '$numMatricula', '$IdUsuarioCadastrou', '$dataCadastro', '$dataNascimento', '$setor', '$cargo', '$unidade', '$municipio',
    '$dataDose1HepatiteB', '$dataDose2HepatiteB', '$dataDose3HepatiteB', '$dataDoseReforcoHepatiteB',
    '$dataExameAntiHBS', '$resultadoExameAntiHBS',
    '$dataDose1DifteriaTetano', '$dataDose2DifteriaTetano', '$dataDose3DifteriaTetano', '$dataDoseReforcoDifteriaTetano',
    '$dataDose1TripliceViral', '$dataDose2TripliceViral', 
    '$dataDose1Covid', '$dataDose2Covid', '$dataDose3Covid', '$dataDoseReforco1Covid', '$dataDoseReforco2Covid', 
    '$dataDoseUnicaFebreAmarela', '$dataDoseAnualInfluenza'
)";

// Validar query
$query_cadastros = mysqli_query($connx, $recebendo_cadastros);

if ($query_cadastros) {
    $mensagem = "Cadastro realizado com sucesso!";
    $tipo = 'success';
    header('Location: listagem_cadastros.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
} else {
    $erro_mysql = mysqli_error($connx);
    $mensagem = "Não foi possível realizar o cadastro!\nErro: " . $erro_mysql;
    $tipo = 'danger';
    // header('Location: cadastrar_view.php');
    header('Location: listagem_cadastros.php?mensagem=' . urlencode($mensagem) . '&tipo=' . $tipo);
    // header("Refresh: 0; url=cadastrar_view.php?mensagem=" . urlencode($mensagem) . "&tipo=" . $tipo);
}

// utilizando o método materialize
// if ($query_cadastros) {
//     header('Location: listagem_cadastros.php?status=sucesso');
// } else {
//     header('Location: listagem_cadastros.php?status=erro');
// }


