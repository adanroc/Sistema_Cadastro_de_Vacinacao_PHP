<?php
session_start();

include '../conexao.php';
include '../validar.php';
include '../filtro_administrador.php';

// Buscar todos os usuários (sem lógica de pseudo apagar)s
// $buscar_usuarios = "SELECT * FROM ListaDeUsuarios";

// Buscar usuários que não estão apagados (apagadoPseudo = 0)
$buscar_usuarios = "SELECT * FROM ListaDeUsuarios WHERE apagadoFalso = '0'";

$query_usuarios = mysqli_query($connx, $buscar_usuarios);
if (!$query_usuarios) {
    die("Erro na consulta ao banco de dados: " . mysqli_error($connx));
}

// session_start();

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
    <link rel="stylesheet" href="listagem_usuarios_estilo.css"> <!--Estilo personalizado (deve vir após o Bootstrap para sobrescrever as regras)-->
    <link rel="stylesheet" href="listagem_usuarios_tabela_estilo.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-2.1.8/datatables.min.css"> <!-- DataTables -->
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
        <h2 class="titulo-cadastro">Lista de Usuários</h2>
        <hr class="linha-abaixo-titulo">
        <br>
        <nav class="navbar navbar-light bg-light">
            <form class="form-inline d-flex justify-content-start w-100">
                <a class="btn btn-outline-primary mr-3" href="cadastrar_view.php" role="button" title="Adicionar Novo Usuario">Adicionar Usuario</a>
                <!-- <a class="btn btn-outline-success my-2 my-sm-0 mr-3" href="cadastrar_view.php" role="button" title="Gerar Relatório em PDF">Relatório</a> -->
                <!-- <a class="btn btn-outline-danger mr-3" href="../logout.php" role="button" title="Fazer Logout do Sistema">Sair</a> -->
                <input class="form-control mr-sm-3 ml-auto" type="search" id="FiltroGeral" placeholder="Pesquisa rápida..." aria-label="Search" title="Pesquisa Rápida por Toda a Tabela...">
                <!-- <form>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Exemplo de input de arquivo</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                </form> -->
            </form>
            <!-- <form method="POST" action="importar_dados_excel.php" enctype="multipart/form-data">
                <label>Arquivo:</label>
                <input type="file" name="arquivo_excel" id="arquivo_excel" accept="text/csv">
                <br><br>
                <input type="submit" value="Enviar">
            </form> -->
        </nav>
    </div>
    <div class="container-fluid">
        <div class="tabela-ListaDeUsuarios-container">
            <table class="table table-striped table-hover table-bordered table-sm" id="TabelaListaDeUsuarios">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Foto Perfil</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Login</th>
                        <th scope="col">Email</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Setor</th>
                        <th scope="col">Unidade</th>
                        <th scope="col">Município</th>
                        <th scope="col">Total Cadastros</th>
                        <th scope="col">Perfil</th>
                        <th scope="col">Ação</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                    if (mysqli_num_rows($query_usuarios) > 0) {
                        $id_contador = 0; // Inicializa o contador
                        $fotoPerfilPadrao = 'default.jpg';
                        while ($receber_usuarios = mysqli_fetch_array($query_usuarios)) {
                            $id_contador++;
                            $idUsuario = $receber_usuarios['idUsuario'];
                            $nome = $receber_usuarios['nome'];
                            $login = $receber_usuarios['login'];
                            $email = $receber_usuarios['email'];
                            $cargo = $receber_usuarios['cargo'];
                            $setor = $receber_usuarios['setor'];
                            $unidade = $receber_usuarios['unidade'];
                            $municipio = $receber_usuarios['municipio'];
                            $perfil = $receber_usuarios['perfil'];
                            $fotoPerfil = $receber_usuarios['fotoPerfil'];
                            // if(!$fotoPerfil == null) {
                            //   $mostrar_foto = "<img src='img/$fotoPerfil' class='listar_foto'>";      
                            // } else {
                            //     $mostrar_foto = '';
                            // }
                            // <td>$mostrar_foto</td>

                            $fotoPerfilPadrao = "default.jpg" // Nome da foto no diretório
                    ?>
                            <tr>
                                <td><?php echo $id_contador; ?></td>
                                <!-- <td><?php echo $id; ?></td> -->
                                 <!-- Desse jeito, se não tiver foto, ele vai colocar um icone de uma imagem quebrada -->
                                <!-- <td><img src='img_usuario/<?php echo $fotoPerfil ?>' class='listar_foto'></td>  -->

                                <!-- Nesse caso usa uma foto padrão para não ficar feio sem foto ou com o icone quebrado -->
                                <td><img src='img_usuario/<?php echo $fotoPerfil ? $fotoPerfil : $fotoPerfilPadrao; ?>' class='listar_foto'></td>
                                <!-- <td><img src='img_usuario/<?php echo $fotoPerfil ?? $fotoPerfilPadrao; ?>' class='listar_foto'></td> -->
                                <!-- <td><img src='img_usuario/<?php echo $fotoPerfil ?? ''; ?>' class='listar_foto'></td> -->

                                <!-- Operador ?
                                <td><img src='img_usuario/<?php echo $fotoPerfil ? $fotoPerfil : $fotoPerfilPadrao; ?>' class='listar_foto'></td>
                                “Se $fotoPerfil tiver valor (não for false, null, 0, string vazia, etc.), use-o; senão, use $fotoPerfilPadrao.” -->

                                <!-- Operador ??
                                <td><img src='img_usuario/<?php echo $fotoPerfil ?? $fotoPerfilPadrao; ?>' class='listar_foto'></td>
                                Sim, o seu código está funcional e sintaticamente correto, mas ele pode ser simplificado com o operador de coalescência nula (??), que é mais moderno e legível em PHP 7+.
                                O operador ?? verifica somente se a variável é null ou não definida, sem considerar valores falsy como 0 ou string vazia, o que evita surpresas em algumas situações.
                                Se quiser garantir que o valor não seja vazio, use ternário + !empty():
                                <td><img src='img_usuario/<?php echo !empty($fotoPerfil) ? $fotoPerfil : $fotoPerfilPadrao; ?>' class='listar_foto'></td> -->


                                
                                <!-- Operador coalescencia ??
                                Usando operador de coalescência nula (??) — Recomendado (PHP 7+):
                                “Se $fotoPerfil estiver definido e não for null, use-o; caso contrário, use $fotoPerfilPadrao.”
                                <td><img src='img_usuario/<?php echo $fotoPerfil ?? $fotoPerfilPadrao; ?>' class='listar_foto'></td> -->
                                
                                <!-- Operdor ternário ? :
                                Usando operador ternário (?:) — Alternativa mais antiga:
                                <td><img src='img_usuario/<?php echo $fotoPerfil ? $fotoPerfil : $fotoPerfilPadrao; ?>' class='listar_foto'></td>
                                Aqui, você está testando se $fotoPerfil é “truthy” (não vazio, não 0, não null etc.). -->

                                 <!-- <td><img src='img_usuario/<?php echo $fotoPerfil ? $fotoPerfil : 'default.jpg'; ?>' class='listar_foto'></td>  -->
                                  <!-- <td><img src='img_usuario/<?php echo $fotoPerfil ? $fotoPerfil : $fotoPerfilPadrao; ?>' class='listar_foto'></td>  -->
                                <td><?php echo $nome; ?></td>
                                <td><?php echo $login; ?></td>
                                <td><?php echo $email; ?></td>
                                <td><?php echo $cargo; ?></td>
                                <td><?php echo $setor; ?></td>
                                <td><?php echo $unidade; ?></td>
                                <td><?php echo $municipio; ?></td>
                                <td>100</td>
                                <td>
                                    <!-- <?php echo $perfil; ?> -->
                                    <?php
                                    // Array associativo para mapear os valores do ENUM aos nomes correspondentes
                                    $nomesPerfis = [
                                        '1' => 'Administrador',
                                        '2' => 'Padrão',
                                        '3' => 'Externo'
                                    ];
                                    // Verifica se o valor do perfil existe no array, senão exibe "Desconhecido"
                                    $perfilExibido = isset($nomesPerfis[$perfil]) ? $nomesPerfis[$perfil] : 'Desconhecido';
                                    echo $perfilExibido;
                                    ?>
                                </td>
                                <td>
                                    <a href="editar_view.php?idUsuario=<?php echo $idUsuario; ?>" class="btn btn-outline-warning btn-sm" title="Editar Usuário">Editar</a>
                                    <!-- <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#apagar_confirmacao_modal" title="Apagar Usuário">Apagar</a> -->
                                    <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#x<?php echo $receber_usuarios['idUsuario']; ?>" title="Apagar Usuário">Apagar</a>
                                    <a href="#" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#y<?php echo $receber_usuarios['idUsuario']; ?>" title="Resetar Senha do Usuário">Resetar Senha</a>
                                </td>
                            </tr>

                            <!-- Modal - Confirmação de Exclusão -->

                            <!-- Button trigger modal -->
                            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
    </button> -->
                            <div class="modal fade" id="x<?php echo $receber_usuarios['idUsuario']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Confirmação de Exclusão</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Deseja Realmente APAGAR o usuário ?</strong></p>
                                            <!-- <p><strong>Id: </strong><?php echo $idUsuario; ?></p> -->
                                            <p><strong>Id: </strong><?php echo $id_contador; ?></p>
                                            <p><strong>Nome: </strong><?php echo $nome; ?></p>
                                            <p><strong>Login: </strong><?php echo $login; ?></p>
                                            <p><strong>Email: </strong><?php echo $email; ?></p>
                                            <p><strong>Cargo: </strong><?php echo $cargo; ?></p>
                                            <p><strong>Setor: </strong><?php echo $setor; ?></p>
                                            <p><strong>Unidade: </strong><?php echo $unidade; ?></p>
                                            <p><strong>Municipio: </strong><?php echo $municipio; ?></p>
                                            <p><strong>Total Cadastros: </strong>100</p>
                                            <p><strong>Perfil: </strong><?php echo $perfilExibido; ?></p>
                                            <!-- <p><strong>Perfil: </strong><?php echo $perfil; ?></p> -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <!-- <a class="btn btn-danger" href="apagar.php?id=<?php echo $idUsuario; ?>">Confirmar</a> -->
                                            <form action="apagarFalso.php" method="post">
                                                <input type="hidden" name="idUsuario" value="<?php echo $idUsuario; ?>">
                                                <input type="submit" class="btn btn-danger" value="Confirmar">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="y<?php echo $receber_usuarios['idUsuario']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Confirmação para Resetar Senha</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Deseja Relamente RESETAR a Senha do Usuário ?</strong></p>
                                            <!-- <p><strong>Id: </strong><?php echo $idUsuario; ?></p> -->
                                            <p><strong>Id: </strong><?php echo $id_contador; ?></p>
                                            <p><strong>Nome: </strong><?php echo $nome; ?></p>
                                            <p><strong>Login: </strong><?php echo $login; ?></p>
                                            <p><strong>Email: </strong><?php echo $email; ?></p>
                                            <p><strong>Cargo: </strong><?php echo $cargo; ?></p>
                                            <p><strong>Setor: </strong><?php echo $setor; ?></p>
                                            <p><strong>Unidade: </strong><?php echo $unidade; ?></p>
                                            <p><strong>Municipio: </strong><?php echo $municipio; ?></p>
                                            <p><strong>Perfil: </strong><?php echo $perfilExibido; ?></p>
                                            <!-- <p><strong>Perfil: </strong><?php echo $perfil; ?></p> -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <!-- <a class="btn btn-danger" href="apagarFalso.php?id=<?php echo $idUsuario; ?>">Confirmar</a> -->
                                            <form action="resetarSenha.php" method="post">
                                                <input type="hidden" name="idUsuario" value="<?php echo $idUsuario; ?>">
                                                <input type="submit" class="btn btn-danger" value="Confirmar">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='10' style='text-align:center;'>Nenhum usuário encontrado!</td></tr>";
                    }
                    ?>
                </tbody>
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
                    <p>Deseja realmente apagar o usuário ?</p>
                    <p><strong>Id: </strong><?php echo $id; ?></p>
                    <p><strong>Nome: </strong><?php echo $nome; ?></p>
                    <p><strong>Matrícula: </strong><?php echo $login; ?></p>
                    <p><strong>Setor: </strong><?php echo $email; ?></p>
                    <p><strong>Cargo: </strong><?php echo $perfil; ?></p>
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
    <script src="listagem_usuarios_script.js"></script>

    <?php include '../rodape_compartilhado.php' ?>

</body>

</html>