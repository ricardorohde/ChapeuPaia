<?php
session_start();

include_once '../classes/cozinha.php';
include_once '../classes/Login.php';
$sessao = new Sair();
$sessao->sessao();
if(isset($_POST['btnConfirmPedido'])){
    $codigo = filter_input(INPUT_POST, 'pedidoConfirm', FILTER_SANITIZE_NUMBER_INT);
    $cozinha = new cozinha();
    $cozinha->confirm($codigo);
    
}
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Cozinha</title>

        <script src="../node_modules/jquery/dist/jquery.js"></script>
        <link rel="stylesheet" type="text/css" href="../node_modules/bootstrap/compiler/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="../img/icons/logo2.png" type="image/x-icon" />

        <link href="../assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="../assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <link type="text/css" href="../assets/css/argon-dashboard.css" rel="stylesheet">


    </head>
    <body>
        <section class="container-fluid" id="BoxGeral">
            <header class="container-fluid" id="BoxInicialAdmin">
                <nav class="navbar navbar-expand-md navbar-dark fixed-top MenuAdd" id="Menu">
                    <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="sidenav-collapse-main">

                        <!-- Collapse header -->
                        <div class="navbar-collapse-header d-md-none">
                            <div class="row row-center">
                                <div class="col-12 collapse-close float-right">
                                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                                        <span></span>
                                        <span></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation -->

                        <ul class="navbar-nav" id="abrindoNav">

                            <li class="nav-item ">
                                <a class=" nav-link active" href="cozinha.php">
                                    Atualizar
                                </a>
                            </li>



                        </ul>
                    </div>
                    <?php
                    if (isset($_SESSION['codigoUser'])) {
                        echo '<a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="media align-items-center">
                                  <span class="rounded-circle">
                                    <img src="../img/perfils/';

                        if ($_SESSION['fotoUser'] == "") {
                            echo 'userDefaut.png';
                        } else if ($_SESSION['fotoUser'] != "userDefaut.png") {
                            echo $_SESSION['pasta'] . '/' . $_SESSION['fotoUser'];
                        } else {
                            echo 'userDefaut.png';
                        }
                        echo '" class="imgPerfil"/>
                                  </span>
                                  
                                </div>
                              </a>
                              <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right dropdown-menu-md-left mr-2 ml-2">
                                <div class=" dropdown-header noti-title">
                                  <h6 class="text-overflow m-0">Bem vindo!</h6>
                                </div>
                                <a data-toggle="modal" data-target="#infoPerfil" class="dropdown-item">
                                  <i class="ni ni-single-02"></i>
                                  <span>Meu Perfil</span>
                                </a>
                               
                                
                                <div class="dropdown-divider"></div>
                                <a href="admin.php?Sair" class="dropdown-item">
                                  <i class="ni ni-user-run"></i>
                                  <span>Sair</span>
                                </a>
                              </div>';
                    }
                    ?>
                </nav>

            </header>
            <article class="BxCozinha row m-0 row-center">
                <div class=" m-0 row col-12 inBxCozinha mt-5">
                    <div id="BoxPedidos" class="col-12">
                        <p class="TextPedidos">Pedidos</p>
                        <div id="BoxMinPedidos" class="col-12 row row-center p-0">
                            <div class="row col-12 row-center p-0 m-0">
                                <div class="col-12 p-0">
                                    <div class="card shadow p-0 m-0">
                                        <div class="card-header border-0">
                                            <h3 class="mb-0">Lista de Pedidos</h3>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table align-items-center table-flush">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col">Quantidade de Itens</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Hora</th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $busca = new cozinha();
                                                    $busca->getAllPedidos();
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <?php
                            if (isset($_GET['idDel'])) {
                                if ($_GET['idDel'] > 0) {
                                    $id = $_GET['idDel'];
                                    $busca->DelPedidos($id);
                                }
                            }
                            if (isset($_GET['confirmPeid']) && isset($_GET['user'])) {
                                $id = $_GET['confirmPeid'];
                                $busca->Confirm($id, $_GET['user']);
                            }
                            ?>
                        </div>

                    </div>
                </div>
            </article>
        </section>
        <aside class="modal fade" id="infoPerfil" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header mb-0">
                        <h5 class="modal-title">Perfil</h5>
                        <h5 class="modal-title">Cozinha</h5>
                    </div>

                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-12 col-sm-12 mr-0 m-0 mt-0 mb-2" id="BoxUploadImage">
                                    <div class="m-0" id="UploadImage">
                                        <input type="file" id="InputUploader" disabled="disabled"/>
                                        <label for="InputUploader" class="align-content-center " id="LabelUpload"> 

                                            <?php
                                            echo '<img src="../img/perfils/';
                                            if ($_SESSION['fotoUser'] == "") {
                                                echo 'userDefaut.png';
                                            } else if ($_SESSION['fotoUser'] != "userDefaut.png") {
                                                echo $_SESSION['pasta'] . '/' . $_SESSION['fotoUser'];
                                            } else {
                                                echo 'userDefaut.png';
                                            }
                                            echo '" class="img-fluid"/>  ';
                                            ?>

                                        </label>
                                        <div class="BallStausPerfil"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12" id="BoxInfoPerfil">
                                    <div class="row container-fluid">
                                        <div class="col-12 col-lg-12">
                                            <p class="mb-2">Nome<font color="red">*</font></p>
                                            <input class="" type="text" id="InputName" name="nomePerfil" placeholder="Nome" value="<?php echo $_SESSION['nomeUser']; ?>" disabled="disabled"/>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <p class="mt-3 mt-lg-2 mb-1">Email<font color="red">*</font></p>
                                            <input class="" type="text" id="InputName" name="emailPerfil" placeholder="Email" value="<?php echo $_SESSION['emailUser']; ?>" disabled="disabled"/>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <p class="mt-3 mt-lg-2 mb-1">Senha<font color="red">*</font></p>

                                            <input class="SenhaPerfil" type="password" id="InputSenha" name="senhaPerfil" placeholder="Senha" value="<?php echo $_SESSION['senhaUser']; ?>" disabled="dosabled"/>
                                            <button type="button" id="BtnViewHidden" disabled="disabled"><img class="eyePerfil" src="../img/icons/hide.png" id="view"/></button>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <p class="mt-3 mt-lg-2 mb-1">Número de Contato<font color="red">*</font></p>
                                            <input class="InputTel" type="text" disabled=""  id="InputName" name="telefonePerfil" placeholder="(18)98194-9411" onKeyPress="mascara('## #####-####', this);" maxlength="13" value="<?php echo $_SESSION['telefoneUser']; ?>"/>
                                        </div>

                                        <div id="localizacao" class="collapsed row col-12 mt-2 m-0 p-0">
                                            <div class="col-4 col-lg-4">
                                                <p class="mt-3 mt-lg-2 mb-1">Estado</p>
                                                <select name="estadoUser" id="InputEstado" disabled="">
                                                    <option value="SP" selected="">SP</option>
                                                </select>
                                            </div>
                                            <div class="col-8 col-lg-8" >
                                                <p class="mt-3 mt-lg-2 mb-1 ">Cidade</p>
                                                <select name="cidadeUser" id="InputCidade" disabled="">
                                                    <option value="Teodoro Sampaio" selected="">Teodoro Sampaio</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-lg-12" >
                                                <p class="mt-3 mt-lg-2 mb-1 ">Bairro</p>
                                                <input type="text" name="bairroUser" id="InputBairro" disabled="" value="<?php echo $_SESSION['bairroUser']; ?>"/>
                                            </div>
                                            <div class="col-8 col-lg-8" >
                                                <p class="mt-3 mt-lg-2 mb-1 ">Rua</p>
                                                <input type="text" name="ruaCadastro" id="InputBairro" disabled="" value="<?php echo $_SESSION['ruaUser']; ?>"/>
                                            </div>
                                            <div class="col-4 col-lg-4 mr-0" >
                                                <p class="mt-3 mt-lg-2 mb-1">Nº</p>
                                                <input type="text"  name="numCasaUser" maxlength="4" id="InputNumero" disabled="" value="<?php echo $_SESSION['numeroCasaUser']; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">                            
                        <button class="btn btn-danger" data-dismiss="modal" id="Cancel">Cancelar</button>
                        <a href="../paginas/perfilEdit.php" class="hrefIndex">
                            <button class="btn btn-success" id="Edit">Editar</button>
                        </a>
                    </div>

                </div>

            </div>
        </aside>
        <div id="Msg">

        </div>
        <div class="row">
            <div class="col-12">
                <form method="POST">
                    <div class="modal fade" id="showItens" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
                        <div class="modal-dialog modal- modal-dialog-centered modal-xl" role="document" id="showItensPedido">


                            <?php
                            ?>

                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
        <script src="../js/CalculoPromo.js"></script>
        <script src="../js/jquery.js"></script>
        <script src="../js/mostraSenha.js"></script>
        <script src="../js/app.js"></script>
        <script src="../js/mask.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="../js/funcoes.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../sweet/sweetalert.min.js" ></script>
        <!--   Optional JS   -->
        <script src="../assets/js/plugins/chart.js/dist/Chart.min.js"></script>
        <script src="../assets/js/plugins/chart.js/dist/Chart.extension.js"></script>
        <!--   Argon JS   -->
        <script src="../assets/js/argon-dashboard.js?v=1.1.0"></script>
        <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
        <script>
                                                $("#showItens").on('show.bs.modal', function(event) {
                                                    var button = $(event.relatedTarget);
                                                    var codigo = button.data('codigo');

                                                    $.ajax({
                                                        url: "../classes/cozinha.php?showItens=" + codigo
                                                    }).done(function(msg) {
                                                        document.getElementById('showItensPedido').innerHTML = msg;
                                                    });
                                                });
        </script>
    </body>
</html>