 <!-- // session_start();
 // Verifica se a variável de sessão de login existe
 // if (isset($_SESSION['login'])) {
 // Se o usuário estiver logado, redireciona para a página index
 // header("Location: ListaDeCadastros/listagem_cadastros.php");
 // } -->

 <!-- session_start();
 if (isset($_SESSION['login'])) { // Se o usuário estiver logado
 $redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'ListaDeCadastros/listagem_cadastros.php';
 header("Location: $redirect_url"); // Redireciona para a página anterior ou a página padrão
 exit();
 } -->

 <!DOCTYPE html>
 <html lang="en">

 <head>
     <link rel="shortcut icon" href="icone-hemopa.ico" type="image/x-icon">
     <title>SisSASS</title>

     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
     
     <!-- <style> CSS no arquivo -->
     <link rel="stylesheet" href="tela_login_estilo.css"><!-- Link para o arquivo CSS -->
 </head>

 <body>
     <?php
        if (isset($_GET['mensagem']) && isset($_GET['tipo'])) {
            $mensagem = $_GET['mensagem'];
            $tipo = $_GET['tipo'];
            mensagem($mensagem, $tipo);
        }
        ?>
     <header id="container-cabecalho-login">
         <div class="conteudo-cabecalho-login">
             <div class="imagem-cabecalho-login">
                 <img src="Logo-Hemopa-Para.png" alt="Logo Hemopa/PA" id="logo-imagem-hemopa-pa">
             </div>
             <div class="texto-cabecalho-login">
                 SisSASS | Sistema de Atendimento a Saúde do Servidor
             </div>
         </div>
     </header>

     <div class="container-login">
         <div class="container-titulo-login">
             <div>SisSASS</div>
         </div>
         <!-- <hr style="width: 100%; border: 0.5px solid #2980B9; margin: 10px 0;"> -->
         <hr class="linha-abaixo-titulo">
         <br><br><!-- Quebrar 2 linhas-->
         <div class="container-campos-login">

         <!-- Formulário sem botão de mostrar senha -->
          <!-- Só fica personalizado corretamente se comentar o bootstrap -->
             <form action="index_tela_login.php" method="POST">
                 <label for="login">Login</label>
                 <input type="text" class="form-control" name="login" id="login" placeholder="Digite seu Login..." required>
                 <br><br>
                 <label for="senha">Senha</label>
                 <input type="password" class="form-control" name="senha" id="senha" placeholder="Digite sua Senha..." required>
                 <br><br> 

                 <!-- // <button type="submit" class="btn btn-primary btn-block">Acessar</button>  -->
                 <button type="submit" class="btn">Acessar</button> 
             </form>

             <?php
                // if (isset($_POST['login'])) {
                //     $login = $_POST['login'];
                //     $senha = $_POST['senha'];

                //     if (($login == "admin") and ($senha == "admin")) {
                //         session_start();
                //         $_SESSION['login'] = "Robson";
                //         header("location: listagem.php");
                //     } else {
                //         echo "Login e/ou Senha Inválido(s)";
                //     }
                // }


                if (isset($_POST['login'])) {
                    $login = $_POST['login'];
                    $senha = md5($_POST['senha']);

                    include 'conexao.php';

                    $recebendo_usuario = "SELECT * FROM ListaDeUsuarios WHERE login = '$login' and senha = '$senha' and apagadoFalso = '0'";

                    if ($resultado = mysqli_query($connx, $recebendo_usuario)) {
                        $num_registros = mysqli_num_rows($resultado);
                        if ($num_registros == 1) {
                            $linha = mysqli_fetch_assoc($resultado);
                            if (($login == $linha['login']) and ($senha == $linha['senha'])) {
                                session_start();
                                $_SESSION['idUsuario'] = $linha['idUsuario'];
                                $_SESSION['nome'] = $linha['nome'];
                                $_SESSION['login'] = $linha['login'];
                                $_SESSION['cargo'] = $linha['cargo'];
                                $_SESSION['setor'] = $linha['setor'];
                                $_SESSION['unidade'] = $linha['unidade'];
                                $_SESSION['municipio'] = $linha['municipio'];
                                $_SESSION['email'] = $linha['email'];
                                $_SESSION['perfil'] = $linha['perfil'];

                                header("Location: ListaDeCadastros/listagem_cadastros.php");
                            } else {
                                echo "<p class='mensagem-erro'>Login e/ou Senha Inválido(s)</p>";
                            }
                        } else {
                            echo "<p class='mensagem-erro'>Login e/ou Senha não encontrado(s) ou Inválido(s) x</p>";
                        }
                    } else {
                        echo "<p class='mensagem-erro'>Nenhum resultado do banco de dados</p>";
                    }
                }
                ?>
         </div>
     </div>   
    

 </body>

 </html>