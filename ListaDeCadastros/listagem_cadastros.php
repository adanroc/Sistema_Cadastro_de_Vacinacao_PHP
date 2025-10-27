<?php

session_start();
//print_r($_SESSION);
//echo "Setor: " . $_SESSION['setor'] . "<br>";

include '../conexao.php';
include '../validar.php';

$perfil = $_SESSION['perfil'];
$unidade_usuario = $_SESSION['unidade'];

// Buscar todos os cadastros (sem lógica de pseudo apagar)
// $buscar_cadastros = "SELECT * FROM ListaDeCadastros";

// Buscar cadastros que não estão apagados (apagadoUsuarioPadrao = 0)
//$buscar_cadastros = "SELECT * FROM ListaDeCadastros WHERE apagadoUsuarioPadrao = '0'";

// Verificar o perfil do usuário
if ($perfil == '3') {
    // Se for visitante, mostrar apenas os cadastros próprios da unidade    
    $buscar_cadastros = "
        SELECT * 
        FROM ListaDeCadastros
        WHERE cadastradoPor LIKE '%/$unidade_usuario'
        AND apagadoFalso = '0'  -- Verificar se o cadastro não foi apagado
    ";
} elseif ($perfil == '1') {
    // Se for administrador, mostrar todos os cadastros
    $buscar_cadastros = "SELECT * FROM ListaDeCadastros WHERE apagadoFalso = '0'";
} elseif ($perfil == '2') {
    // Se for padrão, mostrar todos os cadastros
    $buscar_cadastros = "SELECT * FROM ListaDeCadastros WHERE apagadoFalso = '0'";
} else {
    // Caso o perfil não seja reconhecido, não permite acessar os cadastros
    echo "<p class='mensagem-erro'>Perfil não reconhecido. Acesso negado.</p>";
    exit;
}

$query_cadastros = mysqli_query($connx, $buscar_cadastros);
if (!$query_cadastros) {
    die("Erro na consulta ao banco de dados: " . mysqli_error($connx));
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> <!-- Estilos do Bootstrap -->
    <link rel="stylesheet" href="listagem_cadastros_estilo.css"> <!--Estilo personalizado (deve vir após o Bootstrap para sobrescrever as regras)-->
    <link rel="stylesheet" href="listagem_cadastros_tabela_estilo.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-2.1.8/datatables.min.css"> <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> <!-- FontAwesome (caso precise de ícones) -->

</head>

<body>

<?php include '../cabecalho_compartilhado.php' ?>

    <?php // ********************* Feedback ao Usuário da ação *********************    

    // Receber mensagem via Get - variável status - Método 02
    if (isset($_GET['status'])):
        if($_GET['status'] == "sucesso"):
            echo "<script>Materialize.toast('Enviado com sucesso!', 4000);</script>";
        else:
            echo "<script>Materialize.toast('Erro ao enviar', 4000);</script>";
        endif;
    endif;
    // O Materialize.toast()é a versão antiga (0.100.2) do Materialize.
    // Na versão mais recente ( 1.0.0 ), o comando mudou para:
    // M.toast({html: 'Enviado com sucesso!', displayLength: 4000});
    // <!-- Importando Materialize CSS -->
    // <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    // <!-- Importando Materialize JavaScript -->
    // <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    // Teste do botão
    // <button onclick="Materialize.toast('Olá, esse é um toast!', 4000)" class="btn">Mostrar Toast</button>


    // Receber mensagem via Get - Método 01 Padrão
    if (isset($_GET['mensagem']) && isset($_GET['tipo'])) {
        $mensagem = $_GET['mensagem'];
        $tipo = $_GET['tipo'];
        mensagem($mensagem, $tipo);
    }
    
    // Receber mensagem via sessão
    
    // Método 01
    // if (isset($_SESSION['msg']))
    // if (!empty($_SESSION['msg'])) 
    // if (isset($_SESSION['msg'])){
    //     echo $_SESSION['msg']; // Imprime oque está dentro da variável global 
    //     unset($_SESSION['msg']); // Destrói oque estiver dentro dessa variável global
    // }
    
    // Método 02
    if (isset($_SESSION['mensagem']) && isset($_SESSION['tipo'])) {
        // Recebe 
        $mensagem = $_SESSION['mensagem'];
        $tipo = $_SESSION['tipo'];
    
        // Exibe
        mensagem($mensagem, $tipo);
        
        // Limpa a mensagem
        // Limpa a mensagem para não reaparecer no reload
        unset($_SESSION['mensagem']);
        unset($_SESSION['tipo']);
    }

    ?>    

    <div class="container-fluid">   

        <br>
        <h2 class="titulo-cadastro">Lista de Vacinação dos Servidores</h2>
        <hr class="linha-abaixo-titulo">
        <br>
        <nav class="navbar navbar-light bg-light">
            <form class="form-inline d-flex justify-content-start w-100">
                <a class="btn btn-outline-primary mr-3" href="cadastrar_view.php" role="button" title="Adicionar Novo Cadastro">Adicionar Cadastro</a>
                <a class="btn btn-outline-secondary my-2 my-sm-0 mr-3" href="relatorio_pdf_tcpdf_tabela_html.php"  target="_blank" role="button" title="Gerar Relatório em PDF">Report/Invoice Relatório PDF</a>

                <input class="form-control mr-sm-3 ml-auto" type="search" id="FiltroGeral" placeholder="Pesquisa rápida..." aria-label="Search" title="Pesquisa Rápida por Toda a Tabela...">                
            </form>
        </nav>
    </div>

    <div class="container-fluid">
        <div class="tabela-ListaDeCadastros-container">
            <table class="table table-striped table-hover table-bordered table-sm table-responsive" id="TabelaListaDeCadastros">
                <thead class="table-header">
                    <tr>
                        <!-- <th colspan="2" scope="col"></th>
                        <th colspan="2" scope="col">Servidor Ativo</th> -->
                        <!-- <th colspan="4" scope="col">Servidor Ativo</th> -->
                        <th colspan="5" scope="col">Servidor Ativo</th>
                        <th colspan="6" scope="col"></th>
                        <th colspan="4" scope="col">Hepatite B (HB)</th>
                        <th colspan="2" scope="col">Anti-HBS</th>
                        <th colspan="4" scope="col">Difteria e Tétano (DT)</th>
                        <th colspan="2" scope="col">Tríplice Viral</th>
                        <th colspan="5" scope="col">Covid-19</th>
                        <th colspan="1" scope="col">Febre Amarela</th>
                        <th colspan="1" scope="col">Influenza</th>
                        <!-- <th colspan="1" scope="col"></th> -->
                    </tr>
                    <tr>
                        <th scope="col">Ação</th>
                        <th scope="col">#</th>
                        <th scope="col">Cadastrado por</th>
                        <th scope="col">Matricula</th>
                        <th scope="col">Nome</th>
                        
                        <th scope="col">DT Nascimento</th>
                        <th scope="col">Setor</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Unidade</th>
                        <th scope="col">Município</th>
                        <th scope="col">Status de Vacinação</th>

                        <th scope="col">1ªDose</th>
                        <th scope="col">2ªDose</th>
                        <th scope="col">3ªDose</th>
                        <th scope="col">Reforço</th>

                        <th scope="col">Exame</th>
                        <th scope="col">Resultado</th>

                        <th scope="col">1ªDose</th>
                        <th scope="col">2ªDose</th>
                        <th scope="col">3ªDose</th>
                        <th scope="col">Reforço</th>

                        <th scope="col">1ªDose</th>
                        <th scope="col">2ªDose</th>

                        <th scope="col">1ªDose</th>
                        <th scope="col">2ªDose</th>
                        <th scope="col">3ªDose</th>
                        <th scope="col">1ªReforço</th>
                        <th scope="col">2ªReforço</th>

                        <th scope="col">Dose Única</th>

                        <th scope="col">Dose Anual</th>

                        <!-- <th scope="col">Total de Vacinas por Servidor</th> -->

                    </tr>
                </thead>

                <tbody class="table-group-divider">
                    <?php
                    if (mysqli_num_rows($query_cadastros) > 0) {
                        $totalDose1HepatiteB = 0;
                        $totalDose2HepatiteB = 0;
                        $totalDose3HepatiteB = 0;
                        $totalReforcoHepatiteB = 0;
                        $totalExameAntiHBS = 0;
                        $totalResultadoAntiHBS = 0;
                        $totalDose1DifteriaTetano = 0;
                        $totalDose2DifteriaTetano = 0;
                        $totalDose3DifteriaTetano = 0;
                        $totalReforcoDifteriaTetano = 0;
                        $totalDose1TripliceViral = 0;
                        $totalDose2TripliceViral = 0;
                        $totalDose1Covid = 0;
                        $totalDose2Covid = 0;
                        $totalDose3Covid = 0;
                        $totalReforco1Covid = 0;
                        $totalReforco2Covid = 0;
                        $totalDoseUnicaFebreAmarela = 0;
                        $totalDoseAnualInfluenza = 0;
                        $totalHepatiteB = 0;
                        $totalAntiHBS = 0;
                        $totalDifteriaTetano = 0;
                        $totalTripliceViral = 0;
                        $totalCovid = 0;
                        $totalFebreAmarela = 0;
                        $totalInfluenza = 0;
                        $id_contador = 0;

                        while ($receber_cadastros = mysqli_fetch_array($query_cadastros)) {
                            $id_contador++;
                            $idServidor = $receber_cadastros['idServidor'];
                            $nome = $receber_cadastros['nome'];
                            $numMatricula = $receber_cadastros['numMatricula'];

                            $IdUsuarioCadastrou = $receber_cadastros['IdUsuarioCadastrou'];
                            // 🔍 Buscar o nome e a unidade do usuário que cadastrou
                            $sql_usuario = "SELECT nome, unidade FROM ListaDeUsuarios WHERE idUsuario = '$IdUsuarioCadastrou'";
                            $result_usuario = mysqli_query($connx, $sql_usuario);

                            if ($row_usuario = mysqli_fetch_assoc($result_usuario)) {
                                $usuario_cadastrou = $row_usuario['nome'] . " / " . $row_usuario['unidade'];
                            } else {
                                $usuario_cadastrou = "Usuário não encontrado";
                            }

                            $dataNascimento = $receber_cadastros['dataNascimento'];
                            $setor = $receber_cadastros['setor'];
                            $cargo = $receber_cadastros['cargo'];
                            $unidade = $receber_cadastros['unidade'];
                            $municipio = $receber_cadastros['municipio'];
                            $dataDose1HepatiteB = $receber_cadastros['dataDose1HepatiteB'];
                            $dataDose2HepatiteB = $receber_cadastros['dataDose2HepatiteB'];
                            $dataDose3HepatiteB = $receber_cadastros['dataDose3HepatiteB'];
                            $dataDoseReforcoHepatiteB = $receber_cadastros['dataDoseReforcoHepatiteB'];
                            $dataExameAntiHBS = $receber_cadastros['dataExameAntiHBS'];
                            $resultadoExameAntiHBS = $receber_cadastros['resultadoExameAntiHBS'];
                            $dataDose1DifteriaTetano = $receber_cadastros['dataDose1DifteriaTetano'];
                            $dataDose2DifteriaTetano = $receber_cadastros['dataDose2DifteriaTetano'];
                            $dataDose3DifteriaTetano = $receber_cadastros['dataDose3DifteriaTetano'];
                            $dataDoseReforcoDifteriaTetano = $receber_cadastros['dataDoseReforcoDifteriaTetano'];
                            $dataDose1TripliceViral = $receber_cadastros['dataDose1TripliceViral'];
                            $dataDose2TripliceViral = $receber_cadastros['dataDose2TripliceViral'];
                            $dataDose1Covid = $receber_cadastros['dataDose1Covid'];
                            $dataDose2Covid = $receber_cadastros['dataDose2Covid'];
                            $dataDose3Covid = $receber_cadastros['dataDose3Covid'];
                            $dataDoseReforco1Covid = $receber_cadastros['dataDoseReforco1Covid'];
                            $dataDoseReforco2Covid = $receber_cadastros['dataDoseReforco2Covid'];
                            $dataDoseUnicaFebreAmarela = $receber_cadastros['dataDoseUnicaFebreAmarela'];
                            $dataDoseAnualInfluenza = $receber_cadastros['dataDoseAnualInfluenza'];

                            // Calcular total de vacinas por servidor
                            $totalVacinasPorServidor = 0;
                            // Hepatite B
                            if ($receber_cadastros['dataDose1HepatiteB'] != '' && $receber_cadastros['dataDose1HepatiteB'] != '0000-00-00') $totalVacinasPorServidor++;
                            if ($receber_cadastros['dataDose2HepatiteB'] != '' && $receber_cadastros['dataDose2HepatiteB'] != '0000-00-00') $totalVacinasPorServidor++;
                            if ($receber_cadastros['dataDose3HepatiteB'] != '' && $receber_cadastros['dataDose3HepatiteB'] != '0000-00-00') $totalVacinasPorServidor++;
                            if ($receber_cadastros['dataDoseReforcoHepatiteB'] != '' && $receber_cadastros['dataDoseReforcoHepatiteB'] != '0000-00-00') $totalVacinasPorServidor++;
                            // Exame AntiHBS
                            //if ($receber_cadastros['dataExameAntiHBS'] != '' && $receber_cadastros['dataExameAntiHBS'] != '0000-00-00') $totalVacinasPorServidor++;
                            if (($receber_cadastros['dataExameAntiHBS'] != '' && $receber_cadastros['dataExameAntiHBS'] != '0000-00-00') ||
                                ($receber_cadastros['resultadoExameAntiHBS'] != '')
                            ) {
                                $totalVacinasPorServidor++;
                            }

                            // Difteria e Tétano
                            if ($receber_cadastros['dataDose1DifteriaTetano'] != '' && $receber_cadastros['dataDose1DifteriaTetano'] != '0000-00-00') $totalVacinasPorServidor++;
                            if ($receber_cadastros['dataDose2DifteriaTetano'] != '' && $receber_cadastros['dataDose2DifteriaTetano'] != '0000-00-00') $totalVacinasPorServidor++;
                            if ($receber_cadastros['dataDose3DifteriaTetano'] != '' && $receber_cadastros['dataDose3DifteriaTetano'] != '0000-00-00') $totalVacinasPorServidor++;
                            if ($receber_cadastros['dataDoseReforcoDifteriaTetano'] != '' && $receber_cadastros['dataDoseReforcoDifteriaTetano'] != '0000-00-00') $totalVacinasPorServidor++;
                            // Tríplice Viral
                            if ($receber_cadastros['dataDose1TripliceViral'] != '' && $receber_cadastros['dataDose1TripliceViral'] != '0000-00-00') $totalVacinasPorServidor++;
                            if ($receber_cadastros['dataDose2TripliceViral'] != '' && $receber_cadastros['dataDose2TripliceViral'] != '0000-00-00') $totalVacinasPorServidor++;
                            // Covid
                            if ($receber_cadastros['dataDose1Covid'] != '' && $receber_cadastros['dataDose1Covid'] != '0000-00-00') $totalVacinasPorServidor++;
                            if ($receber_cadastros['dataDose2Covid'] != '' && $receber_cadastros['dataDose2Covid'] != '0000-00-00') $totalVacinasPorServidor++;
                            if ($receber_cadastros['dataDose3Covid'] != '' && $receber_cadastros['dataDose3Covid'] != '0000-00-00') $totalVacinasPorServidor++;
                            if ($receber_cadastros['dataDoseReforco1Covid'] != '' && $receber_cadastros['dataDoseReforco1Covid'] != '0000-00-00') $totalVacinasPorServidor++;
                            if ($receber_cadastros['dataDoseReforco2Covid'] != '' && $receber_cadastros['dataDoseReforco2Covid'] != '0000-00-00') $totalVacinasPorServidor++;
                            // Febre Amarela
                            if ($receber_cadastros['dataDoseUnicaFebreAmarela'] != '' && $receber_cadastros['dataDoseUnicaFebreAmarela'] != '0000-00-00') $totalVacinasPorServidor++;
                            //  Influenza
                            if ($receber_cadastros['dataDoseAnualInfluenza'] != '' && $receber_cadastros['dataDoseAnualInfluenza'] != '0000-00-00') $totalVacinasPorServidor++;

                            // Calcular total por dose 
                            // Hepatite B
                            if ($receber_cadastros['dataDose1HepatiteB'] != '' && $receber_cadastros['dataDose1HepatiteB'] != '0000-00-00') $totalDose1HepatiteB++;
                            if ($receber_cadastros['dataDose2HepatiteB'] != '' && $receber_cadastros['dataDose2HepatiteB'] != '0000-00-00') $totalDose2HepatiteB++;
                            if ($receber_cadastros['dataDose3HepatiteB'] != '' && $receber_cadastros['dataDose3HepatiteB'] != '0000-00-00') $totalDose3HepatiteB++;
                            if ($receber_cadastros['dataDoseReforcoHepatiteB'] != '' && $receber_cadastros['dataDoseReforcoHepatiteB'] != '0000-00-00') $totalReforcoHepatiteB++;
                            // Exame AntiHBS
                            if ($receber_cadastros['dataExameAntiHBS'] != '' && $receber_cadastros['dataExameAntiHBS'] != '0000-00-00') $totalExameAntiHBS++;
                            if ($receber_cadastros['resultadoExameAntiHBS'] != '' && $receber_cadastros['resultadoExameAntiHBS'] != '0000-00-00') $totalResultadoAntiHBS++;
                            if (($receber_cadastros['dataExameAntiHBS'] != '' && $receber_cadastros['dataExameAntiHBS'] != '0000-00-00') ||
                                ($receber_cadastros['resultadoExameAntiHBS'] != '')
                            ) {
                                $totalAntiHBS++;
                            }
                            // Difteria e Tétano
                            if ($receber_cadastros['dataDose1DifteriaTetano'] != '' && $receber_cadastros['dataDose1DifteriaTetano'] != '0000-00-00') $totalDose1DifteriaTetano++;
                            if ($receber_cadastros['dataDose2DifteriaTetano'] != '' && $receber_cadastros['dataDose2DifteriaTetano'] != '0000-00-00') $totalDose2DifteriaTetano++;
                            if ($receber_cadastros['dataDose3DifteriaTetano'] != '' && $receber_cadastros['dataDose3DifteriaTetano'] != '0000-00-00') $totalDose3DifteriaTetano++;
                            if ($receber_cadastros['dataDoseReforcoDifteriaTetano'] != '' && $receber_cadastros['dataDoseReforcoDifteriaTetano'] != '0000-00-00') $totalReforcoDifteriaTetano++;
                            // Tríplice Viral
                            if ($receber_cadastros['dataDose1TripliceViral'] != '' && $receber_cadastros['dataDose1TripliceViral'] != '0000-00-00') $totalDose1TripliceViral++;
                            if ($receber_cadastros['dataDose2TripliceViral'] != '' && $receber_cadastros['dataDose2TripliceViral'] != '0000-00-00') $totalDose2TripliceViral++;
                            // Covid
                            if ($receber_cadastros['dataDose1Covid'] != '' && $receber_cadastros['dataDose1Covid'] != '0000-00-00') $totalDose1Covid++;
                            if ($receber_cadastros['dataDose2Covid'] != '' && $receber_cadastros['dataDose2Covid'] != '0000-00-00') $totalDose2Covid++;
                            if ($receber_cadastros['dataDose3Covid'] != '' && $receber_cadastros['dataDose3Covid'] != '0000-00-00') $totalDose3Covid++;
                            if ($receber_cadastros['dataDoseReforco1Covid'] != '' && $receber_cadastros['dataDoseReforco1Covid'] != '0000-00-00') $totalReforco1Covid++;
                            if ($receber_cadastros['dataDoseReforco2Covid'] != '' && $receber_cadastros['dataDoseReforco2Covid'] != '0000-00-00') $totalReforco2Covid++;
                            // Febre Amarela
                            if ($receber_cadastros['dataDoseUnicaFebreAmarela'] != '' && $receber_cadastros['dataDoseUnicaFebreAmarela'] != '0000-00-00') $totalDoseUnicaFebreAmarela++;
                            //  Influenza
                            if ($receber_cadastros['dataDoseAnualInfluenza'] != '' && $receber_cadastros['dataDoseAnualInfluenza'] != '0000-00-00') $totalDoseAnualInfluenza++;

                            // Calcular os totais gerais por vacina
                            $totalHepatiteB = $totalDose1HepatiteB + $totalDose2HepatiteB + $totalDose3HepatiteB + $totalReforcoHepatiteB;
                            // $totalAntiHBS = $totalExameAntiHBS;
                            $totalDifteriaTetano = $totalDose1DifteriaTetano + $totalDose2DifteriaTetano + $totalDose3DifteriaTetano + $totalReforcoDifteriaTetano;
                            $totalTripliceViral = $totalDose1TripliceViral + $totalDose2TripliceViral;
                            $totalCovid = $totalDose1Covid + $totalDose2Covid + $totalDose3Covid + $totalReforco1Covid + $totalReforco2Covid;
                            $totalFebreAmarela = $totalDoseUnicaFebreAmarela;
                            $totalInfluenza = $totalDoseAnualInfluenza;

                            $totalGeral = $totalHepatiteB + $totalAntiHBS + $totalDifteriaTetano + $totalTripliceViral + $totalCovid + $totalFebreAmarela + $totalInfluenza;

                            // Calcular o a quantidade de doses e inserir automaticamente o status de vacinaçao Enum no banco
                            // statusVacinacao
                    ?>
                            <tr>
                                <td>
                                    <!-- <a href="editar_view.php?id=<?php echo $idServidor; ?>" class="btn btn-outline-warning btn-sm" title="Editar cadastro">Editar</a> -->
                                    <!-- <a href="editar_view.php?id=<?php echo $idServidor; ?>" class="btn btn-outline-warning btn-sm" title="Editar cadastro">
                                        <i class="bi bi-pencil-fill" style="color: black; margin-right: 5px;"></i>
                                    </a> -->
                                    <a href="editar_view.php?idServidor=<?php echo $idServidor; ?>" title="Editar cadastro">
                                        <!-- <a href="editar_view.php?id=<?php echo $idServidor; ?>&id_contador=<?php echo $id_contador; ?>" title="Editar cadastro"> -->
                                        <i class="bi bi-pencil-fill" style="color: black; margin-right: 5px;"></i>
                                    </a>
                                    <!-- <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#apagar_confirmacao_modal" title="Apagar cadastro">Apagar</a> -->
                                    <!-- <a href="#" data-toggle="modal" data-target="#apagar_confirmacao_modal" title="Apagar cadastro">
                                        <i class="bi bi-trash3" style="color: black;"></i>
                                    </a> -->
                                    <a href="#" data-toggle="modal" data-target="#x<?php echo $receber_cadastros['idServidor']; ?>" title="Apagar cadastro">
                                        <i class="bi bi-trash3" style="color: black;"></i>
                                    </a>

                                    <!-- Botão Copiar - com borda -->
                                    <!-- Classe não utilizada -->
                                    <!-- <button class="btn btn-outline-secondary btn-sm copiar-usuario" --> 
                                    <!-- <button data-id="<?php echo $idServidor; ?>" title="Copiar linha para a área de transferência">
                                    <i class="bi bi-clipboard"></i>
                                    </button> -->
                                    
                                    <!-- Botão Copiar - Sem a borda do clip -->
                                    <!-- <a data-id="<?php echo $idServidor; ?>" title="Copiar linha para a área de transferência">
                                        <i id="copiar" class="bi bi-copy"></i></i>
                                    </a> -->

                                    <!-- Mensagem de cópia -->
                                    <!-- <span class="copiado-mensagem" id="copiado-<?php echo $idServidor; ?>" 
                                        style="display: none; color: green; font-weight: bold; margin-left: 5px;">
                                        Copiado!
                                    </span> -->

                                    <!-- Botão Copiar - somente com ícone -->
                                    <i class="bi bi-copy" id="copiar"  title="Copiar dados do servidor para a área de transferência" style="cursor: pointer; color: #000000; font-size: 1.2rem;"></i>
                                    <!-- <span id="feedback" style="display: none;">Copiado!</span> -->
                                    <!-- <span id="feedback" style="display: none; background: black; color: white; padding: 5px 10px; border-radius: 5px; position: absolute; font-size: 14px; white-space: nowrap; transition: opacity 0.3s ease-in-out;">Copiado!</span> -->
                                    <!-- <span id="feedback" style="display: none; background: black; color: white; padding: 5px 10px; border-radius: 5px; position: absolute; font-size: 14px;">Copiado!</span> -->


                                </td>
                                <td><?php echo $id_contador; ?></td> <!-- id do laço  -->
                                <!-- <td><?php echo $idServidor; ?></td> id do banco (chave primária) -->
                                <td>
                                    <?php 
                                        // echo $IdUsuarioCadastrou;
                                        echo $usuario_cadastrou;
                                     ?>
                                </td>
                                <td><?php echo $numMatricula; ?></td>
                                <td><?php echo $nome; ?></td>                                
                                
                                <td><?php echo data2brasil($dataNascimento); ?></td>
                                <td><?php echo $setor; ?></td>
                                <td><?php echo $cargo; ?></td>
                                <td><?php echo $unidade; ?></td>
                                <td><?php echo $municipio; ?></td>
                                <td>          
                                    Status Vacinação                        
                                </td>
                                <td><?php echo data2brasil($dataDose1HepatiteB); ?></td>
                                <td><?php echo data2brasil($dataDose2HepatiteB); ?></td>
                                <td><?php echo data2brasil($dataDose3HepatiteB); ?></td>
                                <td><?php echo data2brasil($dataDoseReforcoHepatiteB); ?></td>

                                <td><?php echo data2brasil($dataExameAntiHBS); ?></td>
                                <td><?php echo $resultadoExameAntiHBS ? $resultadoExameAntiHBS : ''; ?></td>

                                <td><?php echo data2brasil($dataDose1DifteriaTetano); ?></td>
                                <td><?php echo data2brasil($dataDose2DifteriaTetano); ?></td>
                                <td><?php echo data2brasil($dataDose3DifteriaTetano); ?></td>
                                <td><?php echo data2brasil($dataDoseReforcoDifteriaTetano); ?></td>

                                <td><?php echo data2brasil($dataDose1TripliceViral); ?></td>
                                <td><?php echo data2brasil($dataDose2TripliceViral); ?></td>

                                <td><?php echo data2brasil($dataDose1Covid); ?></td>
                                <td><?php echo data2brasil($dataDose2Covid); ?></td>
                                <td><?php echo data2brasil($dataDose3Covid); ?></td>
                                <td><?php echo data2brasil($dataDoseReforco1Covid); ?></td>
                                <td><?php echo data2brasil($dataDoseReforco2Covid); ?></td>

                                <td><?php echo data2brasil($dataDoseUnicaFebreAmarela); ?></td>

                                <td><?php echo data2brasil($dataDoseAnualInfluenza); ?></td>

                                <!-- <td><?php echo $totalVacinasPorServidor; ?></td> -->
                            </tr>

                            <!-- Modal - Confirmação de Exclusão -->

                            <!-- Button trigger modal -->
                            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Launch demo modal
                            </button> -->

                            <div class="modal fade" id="x<?php echo $receber_cadastros['idServidor']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Confirmação de Exclusão</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Deseja realmente apagar o cadastro ?</strong></p>
                                            <!-- <p><strong>Id: </strong><?php echo $idServidor; ?></p> -->
                                            <p><strong>Nome: </strong><?php echo $nome; ?></p>
                                            <p><strong>Matrícula: </strong><?php echo $numMatricula; ?></p>
                                            <p><strong>Cadastrado por: </strong> <?php echo $usuario_cadastrou ?></p>
                                            <p><strong>Data de Nascimento: </strong><?php echo data2brasil($dataNascimento); ?></p>
                                            <p><strong>Setor: </strong><?php echo $setor; ?></p>
                                            <p><strong>Cargo: </strong><?php echo $cargo; ?></p>
                                            <p><strong>Unidade: </strong><?php echo $unidade; ?></p>
                                            <p><strong>Município: </strong><?php echo $municipio; ?></p>
                                            <p>Status de Vacinação</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <!-- <a class="btn btn-danger" href="apagar.php?id=<?php echo $idServidor; ?>">Confirmar</a> -->
                                            <form action="apagarFalso.php" method="post">
                                                <input type="hidden" name="idServidor" value="<?php echo $idServidor; ?>">
                                                <input type="submit" class="btn btn-danger" value="Confirmar">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='26' style='text-align:center;'>Nenhum cadastro encontrado!</td></tr>";
                    }
                    ?>
                    <!-- <td id="mensagem" colspan="1" style="text-align:center;">Nenhum cadastro encontrado!</td> -->

<!-- <script>
    // Seleciona a tabela
    const tabela = document.getElementById("minhaTabela");

    // Obtém a quantidade de colunas com base no cabeçalho (<thead>)
    const totalColunas = tabela.querySelector("thead tr").children.length;

    // Atualiza o colspan da mensagem no rodapé (<tfoot>)
    document.getElementById("mensagem").colSpan = totalColunas;
</script> -->
<!-- <script>
    // Seleciona a tabela
    const tabela = document.getElementById("TabelaListaDeCadastros");

    // Seleciona a segunda linha do cabeçalho (<thead>)
    const segundaLinha = tabela.querySelector("thead tr:nth-child(2)");

    // Conta quantas colunas (<th>) existem na segunda linha
    let totalColunasSegundaLinha = segundaLinha.children.length;

    // Exibe no console (para testar)
    console.log("Total de colunas na segunda linha:", totalColunasSegundaLinha);

    // Exemplo: Aplicando o valor a um elemento HTML
    document.getElementById("mensagem").setAttribute("colspan", totalColunasSegundaLinha);
</script> -->
                </tbody>
                <tfoot>
                    <tr>
                        <!-- <td colspan="2" scope="col"></td>
                        <th colspan="2" scope="col">Total por Vacinas</th> -->
                        <!-- <th colspan="4" rowspan="2">Total por Vacinas</th> -->
                        <th colspan="5" rowspan="2">Total por Vacinas</th>
                        <td colspan="6" scope="col"></td>
                        <td scope="col"><?php echo $totalDose1HepatiteB; ?></td>
                        <td scope="col"><?php echo $totalDose2HepatiteB; ?></td>
                        <td scope="col"><?php echo $totalDose3HepatiteB; ?></td>
                        <td scope="col"><?php echo $totalReforcoHepatiteB; ?></td>
                        <td scope="col"><?php echo $totalExameAntiHBS; ?></td>
                        <td scope="col"><?php echo $totalResultadoAntiHBS; ?></td>
                        <td scope="col"><?php echo $totalDose1DifteriaTetano; ?></td>
                        <td scope="col"><?php echo $totalDose2DifteriaTetano; ?></td>
                        <td scope="col"><?php echo $totalDose3DifteriaTetano; ?></td>
                        <td scope="col"><?php echo $totalReforcoDifteriaTetano; ?></td>
                        <td scope="col"><?php echo $totalDose1TripliceViral; ?></td>
                        <td scope="col"><?php echo $totalDose2TripliceViral; ?></td>
                        <td scope="col"><?php echo $totalDose1Covid; ?></td>
                        <td scope="col"><?php echo $totalDose2Covid; ?></td>
                        <td scope="col"><?php echo $totalDose3Covid; ?></td>
                        <td scope="col"><?php echo $totalReforco1Covid; ?></td>
                        <td scope="col"><?php echo $totalReforco2Covid; ?></td>
                        <td scope="col"><?php echo $totalDoseUnicaFebreAmarela; ?></td>
                        <td scope="col"><?php echo $totalDoseAnualInfluenza; ?></td>
                        <!-- <td colspan="1" scope="col"></td> -->
                    </tr>
                    <tr>
                        <!-- <td colspan="2" scope="col"></td>
                        <td colspan="2" scope="col"></td> -->
                        <td colspan="6" scope="col"></td>
                        <td colspan="4" scope="col"><?php echo $totalHepatiteB; ?></td>
                        <td colspan="2" scope="col"><?php echo $totalAntiHBS; ?></td>
                        <td colspan="4" scope="col"><?php echo $totalDifteriaTetano; ?></td>
                        <td colspan="2" scope="col"><?php echo $totalTripliceViral; ?></td>
                        <td colspan="5" scope="col"><?php echo $totalCovid; ?></td>
                        <td colspan="1" scope="col"><?php echo $totalFebreAmarela; ?></td>
                        <td colspan="1" scope="col"><?php echo $totalInfluenza; ?></td>
                        <!-- <td colspan="1" scope="col"></td> -->
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- Modal - Confirmação de Exclusão -->

    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
    </button> -->

    <!-- <div class="modal fade" id="apagar_confirmacao_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmação de Exclusão</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente apagar o cadastro ?</p>
                    <p><strong>Id: </strong><?php echo $id; ?></p>
                    <p><strong>Nome: </strong><?php echo $nome; ?></p>
                    <p><strong>Matrícula: </strong><?php echo $numMatricula; ?></p>
                    <p><strong>Data de Nascimento: </strong><?php echo ($dataNascimento != '') ? date('d/m/Y', strtotime($dataNascimento)) : ''; ?></p>
                    <p><strong>Setor: </strong><?php echo $setor; ?></p>
                    <p><strong>Cargo: </strong><?php echo $cargo; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button> -->
    <!-- <a class="btn btn-danger" href="apagar.php?id=<?php echo $id; ?>">Confirmar</a> -->
    <!-- <form action="apagar.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" class="btn btn-danger" value="Confirmar">
                    </form>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.1.8/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="listagem_cadastros_script.js"></script>

    <?php include '../rodape_compartilhado.php' ?>

</body>

</html>