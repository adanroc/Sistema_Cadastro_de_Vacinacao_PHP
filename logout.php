<?php

// session_start();
// session_destroy();
// header("location: index.php?msg=Sessão encerrada!");




session_start();

// Impedir botão de voltar do navegador

// Destruir todas as variáveis de sessão (1)
session_unset();

// Impedir o cache da página (2)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

//Resetar valos dos cookies
setcookie("ID", NULL, 1);
setcookie("TOKEN", NULL, 1);
setcookie("SECURE", NULL, 1);

session_destroy();

header("location: index_tela_login.php?msg=Sessão encerrada!");


// Evitar Retorno através de Botão de Voltar do Navegador (JavaScript)
// <script type="text/javascript">
//     // Desabilitar o botão de voltar no navegador
//     history.pushState(null, "", location.href);
//     history.back();
//     history.forward();
// </script>