<?php

//Variáveis de conexão(hemopa)
// $host = '10.95.2.9';
// $user = 'root';
// $passwd = '011372$$mysql';
// $bd_name = 'SisSASS';

//Variáveis de conexão(meu notebook)
// $host = 'localhost';
// $user = 'root';
// $passwd = '';
// $bd_name = 'SisSASS';

//Variáveis de conexão(meu notebook)
$host = '127.0.0.1';
$user = 'root';
$passwd = 'admin';
$bd_name = 'SisSASS';


//Conexão
$connx = mysqli_connect($host, $user, $passwd, $bd_name);

// Setar Time do zone do servidor como zero, igual a todo o mundo
// mysqli_query($connx,"SET time_zone='+00:00'");
// date_default_timezone_set("UTC");



// if ($connx) {
//     echo "conectado com sucesso";
// }

//Verificar se a conexão foi bem-sucedida (versão antiga)
// if (mysqli_connect_error($connx)) {
//     die("Erro de conexão com o Banco de Dados: " . mysqli_connect_error($connx));
//     //header('Location: index.php');
// }

// Versão atual
if (mysqli_connect_error()) {
    die("Erro de conexão com o Banco de Dados: ".mysqli_connect_error($connx));
    // echo"Erro de conexão com o Banco de Dados: ".mysqli_connect_error();
    // exit();
    //header('Location: index.php');
}

// Mensagem de Sucesso ou Erro
function mensagem($texto, $tipo)
{
    echo "<div id='alert-box' class='alert alert-$tipo custom-alert' role='alert'>
             <button type='button' class='btn btn-danger btn-sm close-alert' arial-label='Close'>x</button>
             $texto
          </div>";
}

// Campo somente DATE
// Formatar Data USA: yyyy-MM-dd -> Brasil: dd-MM-yyyy
// function data2brasil($data)
// {
//     // Verifica se a data é válida e não é nula
//     if ($data != '0000-00-00' && $data != '') {
//         $vetor_data = explode('-', $data);
//         $data_formatada = $vetor_data[2] . "/" . $vetor_data[1] . "/" . $vetor_data[0];
//         return $data_formatada;
//     }
//     return ''; // Retorna uma string vazia caso a data seja inválida ou nula
// }

// Campo DATETIME
function data2brasil($data)
{
    // Verifica se a data é válida e não é nula
    if (!empty($data) && $data != '0000-00-00 00:00:00') {
        // Se a data vier no formato DATETIME, removemos a hora
        $data = explode(' ', $data)[0]; // Pega apenas a parte da data (YYYY-MM-DD)
        $vetor_data = explode('-', $data);
        return $vetor_data[2] . "/" . $vetor_data[1] . "/" . $vetor_data[0];
    }
    return ''; // Retorna uma string vazia caso a data seja inválida ou nula
}

// Campo DATETIME
//  Campo para exibir data no editar
function mostrarDataEditar($data) {
    // Verifica se a data não é vazia e se não é '0000-00-00 00:00:00'
    if (!empty($data) && $data != '0000-00-00 00:00:00') {
        // Pega apenas a parte da data (YYYY-MM-DD) ignorando a hora
        return substr($data, 0, 10);
    }
    return ''; // Retorna uma string vazia caso a data seja inválida ou nula
}

// Campo DATETIME
function evitarDataHoraVazia($data) {
    // Verifica se a data está vazia e retorna a data padrão se necessário
    return empty($data) ? '0000-00-00 00:00:00' : $data;
}

// Função para extrair o ano de uma data
function extrairAno($data)
{
    return date('Y', strtotime($data));
}

// Verifica se a data é válida
function dataValida($data) {
    $valida = !empty($data) && $data !== '0000-00-00 00:00:00';
    return $valida;
}

// Converte data para o formato DATETIME do MySQL
function data2DATETIME($data)
{
    // Verifica se a data não está vazia
    if (!empty($data)) {
        // Converte para o formato 'Y-m-d 00:00:00' (sem hora, mas com data)
        $data_convertida = DateTime::createFromFormat('d/m/Y', $data);
        // Verifica se a conversão foi bem-sucedida
        if ($data_convertida) {
            return $data_convertida->format('Y-m-d') . ' 00:00:00'; // Retorna com a hora fixada para '00:00:00'
        }
    }
    return '0000-00-00 00:00:00'; // Retorna valor padrão caso a data seja inválida ou vazia
}

function mover_e_codificar_nome_unico_foto($vetor_foto){

    // detectar se é imagem e não código malicioso
    $vetor_tipo = explode("/", $vetor_foto['type']);
    //$tipo = $vetor_tipo[0]; 
    //$extensao = $vetor_tipo[1]; 

    $tipo = $vetor_tipo[0] ?? ''; // Caso não exista, ele atribui vazio
    $extensao = $vetor_tipo[1] ?? ''; // Caso não exista, ele atribui vazio (Nessa versão, se ele não mandar nada, ele já coloca zero 26-05-2025)
    // nesse caso ele vai dar falso

    // Detectar erro e tamanho (do vetor de informações da imagem)
    if ((!$vetor_foto['error']) and ($vetor_foto['size'] <= 1000000) and ($tipo == "image")){

        // Modificar nome do arquivo e torna-lo único
        $nome_arquivo = date('Ymdhms').".$extensao";        

        // Mover para o diretório
        move_uploaded_file($vetor_foto['tmp_name'], "img_usuario/".$nome_arquivo); 

        return $nome_arquivo; 
    } else {
      return 0;
    }
}

// Função somente com jpg
// function mover_e_codificar_nome_unico_foto($vetor_foto){
//     if ((!$vetor_foto['error']) and ($vetor_foto['size'] <= 1000000)){

//         $nome_arquivo = date('Ymdhms').".jpg";        

//         move_uploaded_file($vetor_foto['tmp_name'], "img_usuario/".$nome_arquivo); 

//         return $nome_arquivo; 
//     } else {
//       return 0;
//     }
// }

// <div class="form-group">
// <label for="fotoPerfil">Foto de Perfil</label>
// <input type="file" name="fotoPerfil" class="form-control" accept=".jpg">  
// </div>

// Código fornecido pelo chat

// function mover_e_codificar_nome_unico_foto($vetor_foto) {
//     if ($vetor_foto['error'] === 0 && $vetor_foto['size'] <= 1000000) {
//         $extensao = pathinfo($vetor_foto['name'], PATHINFO_EXTENSION);
//         $nome_arquivo = uniqid('img_', true) . '.' . $extensao;

//         $caminho_destino = __DIR__ . '/img_usuario/' . $nome_arquivo;

//         if (move_uploaded_file($vetor_foto['tmp_name'], $caminho_destino)) {
//             return $nome_arquivo;
//         } else {
//             error_log("Erro ao mover o arquivo para $caminho_destino");
//             return null;
//         }
//     } else {
//         error_log("Erro no upload: " . $vetor_foto['error']);
//         return null;
//     }
// }