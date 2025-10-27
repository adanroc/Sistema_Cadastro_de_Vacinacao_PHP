<!-- <head>
    <link rel="stylesheet" href="cabecalho_compartilhado_estilo.css">
</head> -->

<?php

// Iniciar a sessão no início do arquivo PHP
session_start();

// Obtém o protocolo correto (http ou https)
$protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
// Obtém o IP/domínio + porta do servidor
$servidor = $_SERVER['HTTP_HOST'];
// Obtém o diretório base do sistema
$basePath = "/SisSASS";

// Define a URL base do sistema
$baseURL = "$protocolo://$servidor$basePath";

// Caminho para a lista de usuários (somente para admins)
//$listaUsuariosPath = "$baseURL/ListaDeUsuarios/listagem_usuarios.php";


// Verificando se o usuário tem o perfil de Admin
if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == 'padrao') {
    $listaUsuariosPath = "listagem_cadastros.php";
} elseif (isset($_SESSION['perfil']) && $_SESSION['perfil'] == 'administrador') {
    $listaCadastroPath = "../ListaDeCadastros/listagem_cadastros.php";
}
?>

<!-- <header id="container-cabecalho-login">
    <div class="conteudo-cabecalho-login">
        <div class="imagem-cabecalho-login">
            <img src="Logo-Hemopa-Para.png" alt="Logo Hemopa/PA" id="logo-imagem-hemopa-pa">
        </div>
        <div class="texto-cabecalho-login">
            SisSASS | Sistema de Atendimento a Saúde do Servidor
        </div>
    </div>
</header> -->

<!-- <head> -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> <!-- FontAwesome (caso precise de ícones) -->
<!-- </head> -->

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> <!-- FontAwesome (caso precise de ícones) -->
</head>

<header id="CabecalhoLogado">

    <nav class="navbar navbar-expand-sm navbar-toggleable-sm navbar-light bg-white custom-navbar border-bottom box-shadow mb-3">
        <div class="container-fluid">
            <div class="imagem-cabecalho-login">
                <img src="<?php echo $baseURL; ?>/Logo-Hemopa-Para.png" alt="Logo Hemopa/PA" id="logo-imagem-hemopa-pa-cabecalho-compartilhado">
            </div>
            <!-- <a class="navbar-brand" href="listagem_cadastros.php" placeholder="Página Inicial (Home)">Olá, <?php echo $_SESSION['nome']; ?></a> -->
            <!-- <a class="navbar-brand" href="<?php echo $listaCadastroPath; ?>" placeholder="Página Inicial (Home)">Olá, <?php echo $_SESSION['nome']; ?></a> -->
            <a class="navbar-brand" href="<?php echo $baseURL; ?>/ListaDeCadastros/listagem_cadastros.php" placeholder="Página Inicial (Home)">Olá, <?php echo $_SESSION['nome']; ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".navbar-collapse" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse d-sm-inline-flex justify-content-between">
                <!-- Itens à esquerda -->
                <ul class="navbar-nav flex-grow-1">
                    <li class="nav-item">
                        <!-- <a class="nav-link text-dark" href="listagem_cadastros.php" placeholder="Lista de Vacinação dos Servidores"><i class="bi bi-people icon-spacing"></i>Lista de Cadastros</a> -->
                        <!-- <a class="nav-link text-dark" href=<?php echo $listaCadastroPath; ?> placeholder="Lista de Vacinação dos Servidores"><i class="bi bi-people icon-spacing"></i>Lista de Cadastros</a> -->
                        <a class="nav-link text-dark" href="<?php echo $baseURL; ?>/ListaDeCadastros/listagem_cadastros.php" placeholder="Lista de Vacinação dos Servidores"><i class="bi bi-people icon-spacing"></i>Lista de Cadastros</a>
                    </li>
                    <?php
                    // Verificando se o usuário tem o perfil de Admin
                    if ($_SESSION['perfil'] == '1') {
                    ?>
                        <li class="nav-item">
                            <!-- <a class="nav-link text-dark" href="../ListaDeUsuarios/listagem_usuarios.php" placeholder="Lista de Usuários"><i class="bi bi-person-badge icon-spacing"></i>Lista de Usuários</a> -->
                            <a class="nav-link text-dark" href="<?php echo $baseURL; ?>/ListaDeUsuarios/listagem_usuarios.php" placeholder="Lista de Usuários"><i class="bi bi-person-badge icon-spacing"></i>Lista de Usuários</a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
                <!-- Itens à direita -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="<?php echo $baseURL; ?>/meu_perfil_view.php?idUsuario=<?php echo $_SESSION['idUsuario']; ?>" placeholder="Veja seu Perfil de Usuário">
                            <i class="bi bi-person-circle icon-spacing"></i>Meu Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <!-- <a class="nav-link text-dark" href="../alterar_senha_view.php?idUsuario=<?php echo $_SESSION['idUsuario']; ?>" placeholder="Alterar Sua Senha"><i class="bi bi-lock icon-spacing"></i>Alterar Senha</a> -->
                        <!-- <a class="nav-link text-dark" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/alterar_senha_view.php?idUsuario=<?php echo $_SESSION['idUsuario']; ?>" placeholder="Alterar Sua Senha"><i class="bi bi-lock icon-spacing"></i>Alterar Senha</a> -->
                        <a class="nav-link text-dark" href="<?php echo $baseURL; ?>/alterar_senha_view.php?idUsuario=<?php echo $_SESSION['idUsuario']; ?>" placeholder="Alterar Sua Senha"><i class="bi bi-lock icon-spacing"></i>Alterar Senha</a>
                    </li>

                    <li class="nav-item">
                        <!-- <a class="nav-link text-dark" href="../logout.php" placeholder="Deslogar do sistema (Encerrar sua Sessão)"><i class="bi bi-box-arrow-right icon-spacing"></i>Sair</a> -->
                        <!-- <a class="nav-link text-dark" href="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/logout.php" placeholder="Deslogar do sistema (Encerrar sua Sessão)"><i class="bi bi-box-arrow-right icon-spacing"></i>Sair</a> -->
                        <a class="nav-link text-dark" href="<?php echo $baseURL; ?>/logout.php" placeholder="Deslogar do sistema (Encerrar sua Sessão)"><i class="bi bi-box-arrow-right icon-spacing"></i>Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<style>
    /* -------------- Cabeçalho -------------- */

    #CabecalhoLogado {
        font-size: 16px;
        position: fixed;
        top: 0;
        left: 0;
        height: 50px;
        /* Define uma altura fixa para o cabeçalho */
        padding: 0;
        /* Remove qualquer padding extra */
        width: 100%;
        z-index: 1050;
        /* Um valor maior que o do rodapé */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    }

    #CabecalhoLogado .navbar-brand {
        /* font-family: "Nome da sua fonte", sans-serif; */
        font-size: 16px;
        /* Ajuste o tamanho da fonte conforme necessário */
        /* font-weight: bold;  Altere o peso da fonte se necessário */
    }


    /* Alterar altura do cabeçalho */
    #CabecalhoLogado .navbar {
        padding-top: 0px;
        /* Reduz o padding superior do cabeçalho */
        padding-bottom: 0px;
        /* Reduz o padding inferior do cabeçalho */
        height: 100%;
        /* Garante que a navbar ocupe toda a altura do cabeçalho */
        padding-left: 0px;
        padding-right: 0px;
    }

    /* Alterar a cor branca da classe do bootstrap do cabeçalho */
    #CabecalhoLogado .navbar-light.bg-white {
        background-color: #1E3A5F !important;
        /* Um azul mais escuro */
    }

    #CabecalhoLogado .custom-navbar .nav-link,
    #CabecalhoLogado .custom-navbar .navbar-brand {
        color: #ffffff !important;
        /* Torna o texto branco */
    }

    #CabecalhoLogado .navbar-nav .nav-item:last-child {
        margin-right: 5px !important;
        /* Remove o excesso de margem à direita no item final */
    }


    /* -------------- Imagem Cabeçalho -------------- */
    .imagem-cabecalho-login {
        display: flex;
        align-items: center;
        /* Alinha a imagem verticalmente */
        margin-left: 5px;
        /* Espaço entre a imagem e o texto */
    }

    #logo-imagem-hemopa-pa-cabecalho-compartilhado {
        width: 210px !important;
        /* Ajuste o tamanho da imagem */
        height: 55px !important;
    }

    /*-------Espaçamento entre o ìcone e o Texto do nome do cabeçalho-------*/

    .icon-spacing {
        margin-right: 5px;
        /* Ajuste o valor conforme necessário */
    }
</style>