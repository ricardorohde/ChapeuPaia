<?php
session_start();
include_once '../classes/Conexao.php';
include_once '../classes/Login.php';
include_once '../classes/Administracoes.php';
include_once '../classes/CadastroUser.php';
include_once '../classes/Paginas.php';
include_once '../classes/Produtos.php';

if ((!isset($_SESSION['codigoUser'])) || ($_SESSION['nivelUser'] != 3)) {
    header("Location: ../../");
}
if (isset($_GET['Sair'])) {
    $sair = new Sair();
    $sair->logout("admin");
}
if (isset($_GET['usuarios'])) {
    $usuarios = new AdministrarUsuarios();
    if ((isset($_GET['excluirId'])) && isset($_SESSION['count']) == 0) {
        $codigo = $_GET['excluirId'];
        $usuarios->ExcluirUsuario($codigo);
    }
    if (isset($_GET['bloquear'])) {
        $codigo = $_GET['bloquear'];
        $usuarios->BloquearUsuario($codigo);
    }
    if (isset($_GET['desbloquear'])) {
        $codigo = $_GET['desbloquear'];
        $usuarios->DesbloquearUsuario($codigo);
        unset($_GET['desbloquear']);
    }

    if (isset($_POST['Alterar'])) {
        $codigo = $_POST['codigo'];
        $nome = filter_input(INPUT_POST, 'nameAlterar', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'emailAlterar', FILTER_SANITIZE_EMAIL);
        $pontos = filter_input(INPUT_POST, 'pontosAlterar');
        $newTelefone = filter_input(INPUT_POST, 'telefoneAlterar');
        $nivel = filter_input(INPUT_POST, 'nivelAlterar', FILTER_SANITIZE_STRING);
        $cidadeAltera = filter_input(INPUT_POST, 'cidadeAlterar');
        $estadoAlterar = filter_input(INPUT_POST, 'estadoAlterar');
        $bairroAlterar = filter_input(INPUT_POST, 'bairroAlterar');
        $ruaAlterar = filter_input(INPUT_POST, 'ruaAlterar');
        $numeroCasaAlterar = filter_input(INPUT_POST, 'numeroAlterar');
        $updateUsuario = new AlterarUsuario($codigo, $nome, $email, $pontos, $newTelefone, $nivel, $estadoAlterar, $cidadeAltera, $bairroAlterar, $ruaAlterar, $numeroCasaAlterar);
    }
    if (isset($_POST['Cadastrar'])) {
        $nomeCadastro = filter_input(INPUT_POST, 'nomeCadastro');
        $emailCadastro = filter_input(INPUT_POST, 'emailCadastro', FILTER_VALIDATE_EMAIL);
        if ($emailCadastro) {
            $senhaCadastro = filter_input(INPUT_POST, 'senhaCadastro');
            $telefoneCadastro = filter_input(INPUT_POST, 'telefoneCadastro');
            $cidadeCadastro = filter_input(INPUT_POST, 'cidadeCadastro');
            $estadoCadastro = filter_input(INPUT_POST, 'estadoCadastro');
            $bairroCadastro = filter_input(INPUT_POST, 'bairroCadastro');
            $ruaCadastro = filter_input(INPUT_POST, 'ruaAlterar');
            $numeroCasaCadastro = filter_input(INPUT_POST, 'numeroCasaAlterar');
            $nivelCadastro = filter_input(INPUT_POST, 'nivelCadastro');
            $pontosCadastro = filter_input(INPUT_POST, 'pontosCadastro');
            if ((isset($nomeCadastro)) && (isset($emailCadastro)) && (isset($senhaCadastro))) {
                $cadastro = new CadastroUserAdm($nomeCadastro, $emailCadastro, $senhaCadastro, $telefoneCadastro, $estadoCadastro, $cidadeCadastro, $bairroCadastro, $ruaCadastro, $numeroCasaCadastro, $pontosCadastro, $nivelCadastro);
            }
        }
    }
}

if (isset($_GET['produtos'])) {
    $tipos = new FuncaoTipo();
    if (isset($_POST['AddTipo'])) {
        if ($_POST['nomeTipo'] != null) {
            $nomeTipo = $_POST['nomeTipo'];
            $tip = new FuncaoTipo();
            $tip->cadastraTipo($nomeTipo);
        }
    }
    if (isset($_POST['saveTipo'])) {

        if ($_POST['updtNameTipo'] != null && $_POST['idUpdate'] > 0) {

            $tipos->updateTipoName($_POST['updtNameTipo'], $_POST['idUpdate']);
        }
    }
    if (isset($_GET['tipoDelId'])) {
        if ($_GET['tipoDelId'] > 0) {
            $id = $_GET['tipoDelId'];
            $tipos->ApagarTipo($id);
        }
    }

    if (isset($_GET['tip_ativo'])) {

        echo '<script>alert("b");</script>';
        $tipos->updateTipo($_GET['tip_ativo'], $_GET['tip_codigo']);
    }
    if (isset($_POST['AddProduto'])) {
        if ($_POST['tipoProduto'] == 0) {
            header("Location:admin.php?produtos");
        } else {
            $produto = new FuncaoProduto();
            if (isset($_FILES['imgPro'])) {
                $extensaoTipo = $_FILES['imgPro']['type'];
                if (($extensaoTipo != "image/jpg") && ($extensaoTipo != "image/jpeg") && ($extensaoTipo != "image/png") && ($extensaoTipo != "")) {
                    $_SESSION['errorExtensao'] = "imgError";
                    $novoNome = "proDefaut.png";
                } else if (($extensaoTipo == "image/jpg") || ($extensaoTipo == "image/jpeg") || ($extensaoTipo == "image/png")) {
                    $extensao = strtolower(substr($_FILES['imgPro']['name'], -4));
                    $novoNome = md5(time()) . $extensao;
                    $pastaMd = md5($_POST['tipoProduto']);
                    $pasta = "../img/produtos/" . $pastaMd . "/";
                    move_uploaded_file($_FILES['imgPro']['tmp_name'], $pasta . $novoNome);
                } else {
                    $novoNome = "proDefaut.png";
                }
            } else {
                $novoNome = "proDefaut.png";
            }if ($_POST['tipoProduto'] > 0) {
                if (($_POST['ValorProduto']) && ($_POST['PontosProduto'] > 0)) {

                    $nome = $_POST['NomeProduto'];
                    $valor = $_POST['ValorProduto'];
                    $pontos = $_POST['PontosProduto'];
                    $tipo = $_POST['tipoProduto'];
                    $checkboxIgr = $_POST['checkbox'];
                    $pontosUsu = $_POST['PontosProdutoUsu'];
                    $virgula = array('.', ',');
                    $espaco = array('', '.');
                    $valorNovo = str_replace($virgula, $espaco, $valor);
                    $produto->cadastraProduto($nome, $valorNovo, $novoNome, $pontos, $pontosUsu, $tipo, $checkboxIgr);
                }
            }
        }
    }
    if (isset($_GET['excluirProduto'])) {
        if ($_GET['excluirProduto'] > 0) {
            $id = $_GET['excluirProduto'];
            $produto = new FuncaoProduto();
            $produto->excluirProduto($id);
        }
    }
    if ((isset($_POST['AtualizarProduto'])) && (isset($_GET['proEdit']))) {
        $produto = new FuncaoProduto();
        $busca = $produto->getInformProduto($_POST['proCodigo']);

        if (isset($_FILES['imgProEdit'])) {
            $extensaoTipo = $_FILES['imgProEdit']['type'];
            if (($extensaoTipo != "image/jpg") && ($extensaoTipo != "image/jpeg") && ($extensaoTipo != "image/png") && ($extensaoTipo != "")) {
                $_SESSION['errorExtensao'] = "imgError";
                $novoNome = $busca['pro_foto'];
            } else if (($extensaoTipo == "image/jpg") || ($extensaoTipo == "image/jpeg") || ($extensaoTipo == "image/png")) {
                if ($busca['pro_foto'] != 'proDefaut.png') {
                    $pasta = md5($busca['tip_codigo']);
                    unlink("../img/produtos/$pasta/" . $busca['pro_foto'] . "");
                }

                $extensao = strtolower(substr($_FILES['imgProEdit']['name'], -4));
                $novoNome = md5(time()) . $extensao;
                $pastaMd = md5($_POST['tipoProdutoEdit']);
                $pasta = "../img/produtos/" . $pastaMd . "/";
                move_uploaded_file($_FILES['imgProEdit']['tmp_name'], $pasta . $novoNome);
            } else {
                $novoNome = $busca['pro_foto'];
                if ($_POST['tipoProdutoEdit'] != $busca['tip_codigo']) {
                    $pasta = md5($busca['tip_codigo']);
                    $pastaAtual = "../img/produtos/$pasta/" . $busca['pro_foto'];
                    $newPasta = md5($_POST['tipoProdutoEdit']);
                    $pastaDestino = "../img/produtos/$newPasta/" . $busca['pro_foto'];
                    copy($pastaAtual, $pastaDestino);
                    unlink("../img/produtos/$pasta/" . $busca['pro_foto']);
                }
            }
        } else {
            $novoNome = $busca['pro_foto'];
        }if ($_POST['tipoProdutoEdit'] > 0) {

            if (($_POST['valorProdutoEdit']) && ($_POST['pontosProdutoEdit'] > 0)) {
                $nome = $_POST['nomeProdutoEdit'];
                $valor = $_POST['valorProdutoEdit'];
                $pontos = $_POST['pontosProdutoEdit'];
                $tipo = $_POST['tipoProdutoEdit'];
                $pontosUsu = $_POST['pontosProdutoUsuEdit'];
                if ($_POST['checkboxEdit']) {
                    $checkboxIgr = @$_POST['checkboxEdit'];
                } else {
                    $checkboxIgr = @$_POST['checkbox'];
                }
                $virgula = array('.', ',');
                $espaco = array('', '.');
                $valorNovo = str_replace($virgula, $espaco, $valor);
                $codigo = $_POST['proCodigo'];
                $produto->updateProduto($codigo, $nome, $novoNome, $valorNovo, $pontos, $pontosUsu, $tipo, $checkboxIgr);
            }
        }
    }
}
if (isset($_GET['ingredientes'])) {
    $ingrediente = new Ingredientes();
    if (isset($_POST['ApagarIgr'])) {
        if ($_POST['igrApagar'] != null) {
            $chk = $_POST['igrApagar'];
            $ingrediente->deletaIngrediente($chk);
        } else {
            $_SESSION['msgNaDel'] = "N";
            header("Location:admin.php?ingredientes");
        }
    }
    if (isset($_POST['CadastroIngrediente'])) {
        $nome = $_POST['nomeIngrediente'];
        $valor = $_POST['valorIngrediente'];

        if (($nome != null) && ($valor != null)) {
            $ingrediente->CadastraIngredientes($nome, $valor);
        } else {
            $_SESSION['msgFaltacampos'] = "<p class='mt-3 text-center text-danger'>Preencha todos os Campos!</p>";
        }
    }
    if (isset($_POST['editIgr'])) {
        $id = $_POST['IdAlt'];
        $nome = $_POST['nomeAlt'];
        $valor = $_POST['valAlt'];
        $virgula = array('.', ',');
        $espaco = array('', '.');
        $valorNovo = str_replace($virgula, $espaco, $valor);
        if (($id > 0) && ($nome != null) && ($valorNovo > 0)) {
            $ingrediente->updateIngrediente($id, $nome, $valorNovo);
        }
    }
}
if (isset($_GET['promocoes'])) {
    $promocao = new FuncaoPromocao();
    if (isset($_POST['cadastraPromocao'])) {
        $tipo = $promocao->getTip('Promoções');
        if ($tipo > 0) {
            if (isset($_FILES['imgPromo'])) {
                $extensaoTipo = $_FILES['imgPromo']['type'];

                if (($extensaoTipo != "image/jpg") && ($extensaoTipo != "image/jpeg") && ($extensaoTipo != "image/png") && ($extensaoTipo != "")) {
                    $_SESSION['errorExtensao'] = "imgError";
                    $novoNome = "proDefaut.png";
                } else if (($extensaoTipo == "image/jpg") || ($extensaoTipo == "image/jpeg") || ($extensaoTipo == "image/png")) {
                    $extensao = strtolower(substr($_FILES['imgPromo']['name'], -4));
                    $novoNome = md5(time()) . $extensao;
                    $pastaMd = md5($tipo);
                    $pasta = "../img/produtos/" . $pastaMd . "/";
                    move_uploaded_file($_FILES['imgPromo']['tmp_name'], $pasta . $novoNome);
                } else {
                    $novoNome = "proDefaut.png";
                }
            } else {
                $novoNome = "proDefaut.png";
            }
            if (($_POST['ValorPromocao']) && ($_POST['PontosPromocaoPro'] > 0) && ($_POST['PontosPromocaoUsu'] > 0)) {
                $nome = filter_input(INPUT_POST, 'NomePromocao', FILTER_SANITIZE_STRING);
                $valor = filter_input(INPUT_POST, 'ValorPromocao');
                $pontos = filter_input(INPUT_POST, 'PontosPromocaoPro', FILTER_SANITIZE_NUMBER_INT);
                $virgula = array('.', ',');
                $espaco = array('', '.');
                $valorNovo = str_replace($virgula, $espaco, $valor);
                $pontosUsu = filter_input(INPUT_POST, 'PontosPromocaoUsu', FILTER_SANITIZE_NUMBER_INT);

                $promocao->cadastraPromocao($nome, $valorNovo, $novoNome, $pontos, $pontosUsu, $tipo);
            }
        }
    }
    if (isset($_GET['excluirPromocao'])) {
        if ($_GET['excluirPromocao'] > 0) {

            if ($cod = filter_input(INPUT_GET, 'excluirPromocao', FILTER_SANITIZE_NUMBER_INT)) {
                $promocao->delPromocao($cod);
            }
        }
    }
    if (isset($_POST['SavePromocao'])) {
        if (($_POST['proCodigoEdit'] > 0)) {
            $busca = $promocao->informPromo($_POST['proCodigoEdit']);
            if ($busca != 1) {
                if (isset($_FILES['imgPromocaoEdit'])) {
                    $extensaoTipo = $_FILES['imgPromocaoEdit']['type'];
                    if (($extensaoTipo != "image/jpg") && ($extensaoTipo != "image/jpeg") && ($extensaoTipo != "image/png") && ($extensaoTipo != "")) {

                        $novoNome = $busca['pro_foto'];
                    } elseif (($extensaoTipo == "image/jpg") || ($extensaoTipo == "image/jpeg") || ($extensaoTipo == "image/png")) {
                        $pastaMd = md5($busca['tip_codigo']);
                        if ($busca['pro_foto'] != 'proDefaut.png') {

                            unlink("../img/produtos/$pasta/" . $busca['pro_foto'] . "");
                        }

                        $extensao = strtolower(substr($_FILES['imgPromocaoEdit']['name'], -4));
                        $novoNome = md5(time()) . $extensao;
                        $pasta = "../img/produtos/" . $pastaMd . "/";
                        move_uploaded_file($_FILES['imgPromocaoEdit']['tmp_name'], $pasta . $novoNome);
                    } else {
                        $novoNome = $busca['pro_foto'];
                    }
                } else {
                    $novoNome = $busca['pro_foto'];
                }
                if (($_POST['ValorPromocaoEdit']) && ($_POST['PontosPromocaoEdit'] > 0) && ($_POST['PontosPromocaoUsuEdit'] > 0)) {
                    $nome = filter_input(INPUT_POST, 'NomePromocaoEdit', FILTER_SANITIZE_STRING);
                    $valor = filter_input(INPUT_POST, 'ValorPromocaoEdit');
                    $pontos = filter_input(INPUT_POST, 'PontosPromocaoEdit', FILTER_SANITIZE_NUMBER_INT);
                    $pontosUsu = filter_input(INPUT_POST, 'PontosPromocaoUsuEdit', FILTER_SANITIZE_NUMBER_INT);
                    $virgula = array('.', ',');
                    $espaco = array('', '.');
                    $valorNovo = str_replace($virgula, $espaco, $valor);
                    $codigo = filter_input(INPUT_POST, 'proCodigoEdit', FILTER_SANITIZE_NUMBER_INT);
                    $tipo = $busca['tip_codigo'];

                    $promocao->UpdatePromocao($codigo, $nome, $valorNovo, $novoNome, $pontos, $pontosUsu, $tipo);
                }
            }
        }
    }
}
if (isset($_GET['pedidos'])) {
    if (isset($_POST['saveLocationPedido'])) {
        $codigo = filter_input(INPUT_POST, 'codigoPedido', FILTER_SANITIZE_NUMBER_INT);
        $bairro = $_POST['bairroPedido'];
        $rua = $_POST['ruaPedido'];
        $numero = $_POST['nmCasaPedido'];
        $pedido = new Pedidos();
        $pedido->updatePedido($codigo, $bairro, $rua, $numero);
    }
}
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Administração</title>

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
                                <a class=" nav-link active" href="admin.php">
                                    Home
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="../..">
                                    Site
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
            <?php
            $paginas = new Paginas();
            if (!isset($_GET['dashboard']) && !isset($_GET['pedidos']) && !isset($_GET['produtos']) && !isset($_GET['usuarios']) && !isset($_GET['ingredientes']) && !isset($_GET['promocoes']) && !isset($_GET['historico'])) {
                $paginas->dashboard();
            } else {
                if (isset($_GET['dashboard'])) {
                    $paginas->dashboard();
                } else if (isset($_GET['pedidos'])) {
                    $paginas->administrarPedidos();
                } else if (isset($_GET['usuarios'])) {
                    $paginas->administrarUsuarios();
                } else if (isset($_GET['produtos'])) {
                    if (isset($_GET['proEdit']) && isset($_GET['id'])) {
                        $paginas->editProduto();
                    } else {
                        $paginas->administrarProdutos();
                    }
                } else if (isset($_GET['ingredientes'])) {
                    $paginas->administrarIngredientes();
                } else if (isset($_GET['promocoes'])) {
                    $paginas->AdministrarPromocao();
                } else if (isset($_GET['historico'])) {
                    $paginas->administrarHistorico();
                }
            }
            ?>
            <aside class="modal fade" id="infoPerfil" tabindex="-1" role="dialog" >
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header mb-0">
                            <h5 class="modal-title">Perfil</h5>
                            <h5 class="modal-title">Administrador</h5>
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
        </section> 
        <div id="Msg">

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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <!--   Optional JS   -->
        <script src="../assets/js/plugins/chart.js/dist/Chart.min.js"></script>
        <script src="../assets/js/plugins/chart.js/dist/Chart.extension.js"></script>
        <!--   Argon JS   -->
        <script src="../assets/js/argon-dashboard.js?v=1.1.0"></script>
        <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>


        <script type="text/javascript">
                                                    $('#modalEditUser').on('show.bs.modal', function(event) {
                                                        var button = $(event.relatedTarget);
                                                        var recipient = button.data('whatever');
                                                        var recipientnome = button.data('whatevernome');
                                                        var recipientfoto = button.data('whateverfoto');
                                                        var recipientemail = button.data('whateveremail');
                                                        var recipientpontos = button.data('whateverpontos');
                                                        var recipienttelefone = button.data('whatevertelefone');
                                                        var recipientbairro = button.data('whateverbairro');
                                                        var recipientrua = button.data('whateverrua');
                                                        var recipientnumeroCasa = button.data('whatevercasa');
                                                        var modal = $(this);
                                                        modal.find('.recipiente-codigo').val(recipient);
                                                        modal.find('.recipiente-nome').val(recipientnome);
                                                        modal.find('.recipiente-foto').val(recipientfoto);
                                                        modal.find('.recipiente-email').val(recipientemail);
                                                        modal.find('.recipiente-pontos').val(recipientpontos);
                                                        modal.find('.recipiente-telefone').val(recipienttelefone);
                                                        modal.find('.recipiente-bairro').val(recipientbairro);
                                                        modal.find('.recipiente-rua').val(recipientrua);
                                                        modal.find('.recipiente-numeroCasa').val(recipientnumeroCasa);

                                                    });
                                                    $('#modalEditIngre').on('show.bs.modal', function(event) {
                                                        var button = $(event.relatedTarget);
                                                        var igrcodigo = button.data('whatevercodigo');
                                                        var igrnome = button.data('whatevernome');
                                                        var igrvalor = button.data('whatevervalor');
                                                        var modal = $(this);
                                                        modal.find('.igr-codigo').val(igrcodigo);
                                                        modal.find('.igr-nome').val(igrnome);
                                                        modal.find('.igr-valor').val(igrvalor);


                                                    });
                                                    $("#modalEditPromocao").on('show.bs.modal', function(event) {
                                                        var button = $(event.relatedTarget);
                                                        var codigo = button.data('codigo');

                                                        $.ajax({
                                                            url: "../classes/setPromocao.php?idPromocao=" + codigo
                                                        }).done(function(msg) {
                                                            document.getElementById('Msg').innerHTML = msg;
                                                        });
                                                    });
                                                    $("#modalEditPedido").on('show.bs.modal', function(event) {
                                                        var button = $(event.relatedTarget);
                                                        var codigo = button.data('codigo');

                                                        $.ajax({
                                                            url: "../classes/setPromocao.php?editPedido=" + codigo
                                                        }).done(function(msg) {
                                                            document.getElementById('editPedidoModal').innerHTML = msg;
                                                        });
                                                    });
                                                    $("#modalEditTipo").on('show.bs.modal', function(event) {
                                                        var button = $(event.relatedTarget);
                                                        var codigo = button.data('codigo');

                                                        $.ajax({
                                                            url: "../classes/setPromocao.php?editTipo=" + codigo
                                                        }).done(function(msg) {
                                                            document.getElementById('boxEditTipo').innerHTML = msg;
                                                        });
                                                    });
                                                    $("#showItens").on('show.bs.modal', function(event) {
                                                        var button = $(event.relatedTarget);
                                                        var codigo = button.data('codigo');

                                                        $.ajax({
                                                            url: "../classes/setPromocao.php?showItens=" + codigo
                                                        }).done(function(msg) {
                                                            document.getElementById('showItensPedido').innerHTML = msg;
                                                        });
                                                    });
                                                    function delItenFromPedido(produto, pedido) {
                                                        var resposta = confirm("Deseja Apagar esse item?");
                                                        if (resposta == true)
                                                        {
                                                            $.ajax({
                                                                url: "../classes/setPromocao.php?excluirItem=" + produto + "&pedido=" + pedido
                                                            }).done(function(msg) {
                                                                document.getElementById('Msg').innerHTML = msg;
                                                            });

                                                        }
                                                    }
                                                    function confirmacaoFinalizaPedido(pedido) {
                                                        var resposta = confirm("Deseja Finalizar esse Pedido?");
                                                        if (resposta == true)
                                                        {
                                                            $.ajax({
                                                                url: "../classes/setPromocao.php?finalizaId=" + pedido
                                                            }).done(function(msg) {
                                                                document.getElementById('Msg').innerHTML = msg;
                                                            });

                                                        }
                                                    }
                                                   


        </script>
        <script src="../js/FunctionProduto.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    </body>  
</html>

