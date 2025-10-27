<?php
session_start();

// Verifica se o usuário está logado
if (isset($_SESSION['login'])) {
    $user = $_SESSION['login'];
    // Verifica se o usuário tem o perfil de "administrador"
    if ($_SESSION['perfil'] != '1') {

        // Se não for admin, redireciona para uma página de acesso restrito ou outra página de sua escolha
        header("location: ../ListaDeCadastros/listagem_cadastros.php?msg=Você não tem permissão para acessar esta página.");
    }
}


// Código de validar a sessão somente logados

// <?php
// session_start();
// if (isset($_SESSION['login'])) {
//     $user = $_SESSION['login'];
// } else {
//     session_destroy();
//     header("location: ../index_tela_login.php?msg=Acesso-negado!");
// }
