<!DOCTYPE html>
<?php
session_start();
include_once './includes/classes/Conexao.php';
include_once './includes/classes/CadastroUser.php';
include_once './includes/classes/Login.php';
include_once './includes/classes/Paginas.php';
include_once './includes/classes/Produtos.php';
if (isset($_GET['Sair'])) {
    $sair = new Sair();
}
if(isset($_SESSION['codigoUser'])){
	$sessao = new Sair();
	$sessao->sessao();
}
if (isset($_POST['cadastrar'])) {
    $nomeCadastro = filter_input(INPUT_POST, 'nomeCadastro');
    $emailCadastro = filter_input(INPUT_POST, 'emailCadastro');
    if ($emailCadastro) {
        $senhaCadastro = filter_input(INPUT_POST, 'senhaCadastro');
        $telefoneCadastro = filter_input(INPUT_POST, 'telefoneCadastro');
        $cidadeCadastro = filter_input(INPUT_POST, 'cidadeUser');
        $estadoCadastro = filter_input(INPUT_POST, 'estadoUser');
        $bairroCadastro = filter_input(INPUT_POST, 'bairroUser');
        $ruaCadastro = filter_input(INPUT_POST, 'ruaCadastro');
        $numeroCasaCadastro = filter_input(INPUT_POST, 'numCasaUser');
        if ((isset($nomeCadastro)) && (isset($emailCadastro)) && (isset($senhaCadastro))) {
            $cadastro = new CadastroUser($nomeCadastro, $emailCadastro, $senhaCadastro, $telefoneCadastro, $estadoCadastro, $cidadeCadastro, $bairroCadastro, $ruaCadastro, $numeroCasaCadastro);
        }
    } else {
        $_SESSION['EmailInvalido'] = "NoValid";
    }
}

if (isset($_POST['logar'])) {
    if ((isset($_POST['emailLogin'])) && (isset($_POST['senhaLogin']))) {
        $email = filter_input(INPUT_POST, 'emailLogin');
        $senha = filter_input(INPUT_POST, 'senhaLogin', FILTER_SANITIZE_STRING);
        $login = new Login($email, $senha);
    }
}
if(isset($_POST['completarPedido'])){
    $forma = filter_input(INPUT_POST, 'pagamento', FILTER_SANITIZE_NUMBER_INT);
    if($forma >= 0){
        include_once './includes/classes/cliente.php';
        $finaliza = new cliente();
        if($forma == 0){
            $pagamento = "Dinheiro";
        }
		if($forma == 1){
            $pagamento = "Cartão";
        }
		if($forma == 2){
            $pagamento = "Pontos";
        }
        
        $finaliza->finalizaPedido($pagamento);
        
    }
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Chapéu de Paia</title>
        <link rel="stylesheet" type="text/css" href="includes/node_modules/bootstrap/compiler/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="includes/css/style.css"/>
        <link rel="stylesheet" type="text/css" href="includes/css/style-produtos.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <link rel="shortcut icon" href="includes/img/icons/logo2.png" type="image/x-icon" />
        <script src = " https://unpkg.com/sweetalert/dist/sweetalert.min.js " ></script> 
        <link rel="stylesheet" href="includes/slick/slick/slick.css" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="includes/slick/slick/slick-theme.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <link href="includes/assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="includes/assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <link type="text/css" href="includes/assets/css/argon-dashboard.css" rel="stylesheet">
    </head>
    <body>
        <section id="boxPrincipal" class="container-fluid m-0 p-0 border">
            <header class="container-fluid border m-0 p-0 row row-center">
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
                                <a class=" nav-link active" href="index.php">
                                    Home
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="produtos.php">
                                    Cardápio
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php#BoxPromocoes">Promoções</a>
                            </li>
                            <?php
                            if (!isset($_SESSION['codigoUser'])) {
                                echo '<li class = "nav-item">
                                    <a class="nav-link " href="#" data-toggle="modal" data-target="#cadastrar">Cadastrar</a>
                                </li>';
                                echo ' 
                                <li class = "nav-item">
                                <li><a class="nav-link " href="#" data-toggle="modal" data-target="#login">Login</a>
                                </li>';
                            }
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Sobre</a>
                            </li> 
                            <?php
                            if ((isset($_SESSION['nivelUser'])) && ($_SESSION['nivelUser'] == 3)) {
                                echo ' 
                                <li class = "nav-item">
                                <li><a class = "nav-link" href = "includes/paginas/admin.php">Administrar</a>
                                </li>';
                            }
                            ?>



                        </ul>
                    </div>
                    <?php
                    if (isset($_SESSION['codigoUser'])) {
                        echo '<a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="media align-items-center">
                                  <span class="rounded-circle">
                                    <img src="./includes/img/perfils/';

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
                               <a class="dropdown-item" href="produtos.php?cart">
                                  <i class="ni ni-cart"></i>
                                  <span>Carrinho</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="index.php?Sair" class="dropdown-item">
                                  <i class="ni ni-user-run"></i>
                                  <span>Sair</span>
                                </a>
                              </div>';
                    } else {
                        ?>
                        <div id="BoxPerfil" class="mb-2">
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if (isset($_SESSION['codigoUser'])) {
                        echo '<input type="checkbox" id="clickCart"/>
                            <label id="BoxCarrinho" class="" for="clickCart" onclick="itensCarrinho(0);" >
                                <img src="includes/img/icons/carrinho-branco.png"/>
                                <div id="BoxItens">
                                   <input id="Itens" value="0" disabled/> 
                                </div>
                                
                            </label>
                            <input type="checkbox" id="clickNotification"/>
                            <label id="BoxNotification" class="" for="clickNotification" onclick="notification(0);" >
                                <img src="includes/img/icons/notification.png"/>
                                <div id="BoxItens">
                                   <input id="Mensages" value="0" disabled/> 
                                </div>
                                
                            </label>
                            ';
                    }
                    ?>

                </nav>
            </header>
            <article class="container-fluid row row-center border p-0 pb-4 m-0 pt-7" id="BoxGetProdutos">
                <?php
                if (isset($_GET['cart']) && isset($_SESSION['codigoUser'])) {
                    include_once './includes/classes/cliente.php';
                    $a = new cliente();
                    $a->getItensCartSelected();
                } else {
                    $a = new Produtos();
                    ?>
                    <div class="col-12 BxFilter row row-center">
                        <div class="col-10 col-sm-9 col-md-8 col-lg-6 float-md-right ">
                            <div class="d-flex justify-content-center h-100">
                                <div class="searchbar">
                                    <input class="search_input" type="text" id="inptBsc" name="" placeholder="Buscar Produto...">
                                    <a href="#" onclick="buscaJs();" class="search_icon"><i class="fas fa-search "></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-sm-4 col-md-4 col-lg-6 float-md-left p-0 d-md-block d-none">
                            <div class="row col-12 col-md-12 col-lg-6 float-left float-md-right p-0 row-center">
                                <a class="col-12 row row-center m-0 p-0 linkFilter" data-toggle="collapse" data-target="#filterOptions" href="#"><div class="col-12 col-md-12 col-lg-8 inBxFilter"><p class="textFilter m-0">FILTRAR</p></div></a>
                            </div>
                        </div>
                        <div class="col-2 col-sm-3 d-block d-md-none p-0">
                            <button class="btn row m-0 mt-2 btn-icon btn-2" data-toggle="collapse" data-target="#filterOptions" type="button" style="background: firebrick;">
                                <span class="btn-inner--icon"><i class="ni ni-bullet-list-67" style="color: white;"></i></span>

                            </button>
                        </div>


                    </div>
                    <div class="col-12 row row-center collapse pb-4 " id="filterOptions">
                        <div class="col-6 col-md-4 row m-0">
                            <p class="col-12 linkCarac">Tipo</p>
                            <hr class="col-11 m-0 p-0 mt-0 ">
                            <a href="produtos.php" class="ml-2 col-12 linkF">Todos</a>
                            <?php
                            //SELECT pp.ppp_codigo, pro.pro_nome, sum(pp.ppp_qtd) quantidade from produtos pro, pedidos_produtos pp WHERE pp.pro_codigo = pro.pro_codigo group by pp.ppp_codigo order by quantidade DESC;

                            $a->getAllTipToFilter();
                            ?>
                        </div>
                        <div class="col-6 col-md-4 row m-0">
                            <p class="col-12 linkCarac">Preços</p>
                            <hr class="col-11 m-0 p-0 mt-0"> 
                            <a href="produtos.php?filter=0&menor" class="ml-2 col-12 linkF">Menor Preço</a>
                            <a href="produtos.php?filter=0&maior" class="ml-2 col-12 linkF">Maior Preço</a>
                            <a href="produtos.php?filter=0&comprados" class="ml-2 col-12 linkF">Mais Comprados</a>
                        </div>
                        <hr class="col-11 m-0 mt-5 mb-3 ">
                    </div>
                    <div class="col-12 row m-0 row-center">
                        <?php
                        if (isset($_GET['filterName'])) {
                            $a->filterProduto($_GET['filterName']);
                            ?>
                            <div class="col-12 h-30"></div>
                            <?php
                        } else if (isset($_GET['filter'])) {
                            if ($_GET['filter'] == 0) {
                                if (isset($_GET['menor'])) {
                                    $query = "SELECT * FROM produtos ORDER BY pro_valor";
                                    $a->FilteredByPrice($query);
                                } else if (isset($_GET['maior'])) {
                                    $query = "SELECT * FROM produtos ORDER BY pro_valor DESC";
                                    $a->FilteredByPrice($query);
                                } else if (isset($_GET['comprados'])) {
                                    $query = "SELECT pro.*, SUM(pp.ppp_qtd) AS quantidade FROM pedidos_produtos pp, pedidos ped, produtos pro WHERE pp.pro_codigo = pro.pro_codigo AND pp.pp_codigo = ped.pp_codigo AND ped.ped_confirmUsu = 1 GROUP BY pp.pro_codigo ORDER BY quantidade DESC";
                                    $a->FilteredByMoreBought($query);
                                }
                            } else {
                                $a->getAllProdutosFiltered($_GET['filter']);
                            }
                        } else {
                            $a->getAllProdutos();
                        }
                    }
                    ?>
                </div>




            </article>
        </section>
        <?php
        $pages = new Paginas();
        $pages->GetModal();
        ?>
        <div class="BxDadosCarrinho row row-center" id="bxDadosCarrinho">

        </div>
        <div id="Msg">

        </div>
        <div class="BxDadosNotification row row-center" id="bxDadosNotification">

        </div>
        <div id="bgDark">
            <div id="loader">
                <i class="fa fa-cog fa-spin fa-5x fa-fw MyLoad"></i>
            </div>
        </div>
        <script src="./includes/node_modules/jquery/dist/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="./includes/node_modules/bootstrap/dist/js/bootstrap.js"></script>
        <script src="includes/js/app.js"></script>
        <script src="includes/slick/slick/jquery-migrate.js"></script>
        <script src="includes/slick/slick/slick.js"></script>
        <script src="includes/js/funcoes.js"></script>
        <script src="includes/js/mask.js"></script>
        <script>
                                        //código usando jQuery
                                        $(document).ready(function() {
                                            $('#bgDark').hide();
                                        });
                                        document.addEventListener("DOMContentLoaded", function(event) {
                                            var estilo = document.getElementById('bgDark');
                                            estilo.style.display = "none";
                                        });
        </script>

        <?php
        if (isset($_SESSION['codigoUser'])) {
            ?>
            <script src="includes/js/cliente.js"></script>
            <?php
        }
        ?>
        <script src="includes/js/searchItens.js"></script>
    </body>
</html>
