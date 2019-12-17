<?php
session_start();
include_once './includes/classes/Conexao.php';
include_once './includes/classes/CadastroUser.php';
include_once './includes/classes/Login.php';
include_once './includes/classes/Paginas.php';
include_once './includes/classes/Produtos.php';
include_once './includes/classes/Comentario.php';
if (isset($_GET['Sair'])) {
    $sair = new Sair();
    $sair->logout('index');
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
if (isset($_POST['sendComent'])) {
    $nome = $_POST['comentario'];
    $comentario = new Comentario();
    $comentario->cadastra($nome);
}
?>
<!DOCTYPE html>
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
        <link href="includes/assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="includes/assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <link type="text/css" href="includes/assets/css/argon-dashboard.css" rel="stylesheet">
    </head>
    <body>

        <section class="container-fluid" id="BoxGeral">
            <header class="container-fluid" id="BoxInicial">
                <nav class="navbar navbar-expand-md navbar-dark fixed-top " id="Menu">
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

                <aside class="container-fluid row m-0 row-center" id="BoxTittleLogo">
                    <div class="col-12" id="BoxLogo">
                        <img src="includes/img/icons/Chapéu11.png" />
                    </div>    
                </aside>
            </header>

            <article id="BoxArticle" class="">
                <div id="BoxSobre" class="row m-0">
                    <div id="BoxTextSobre" class="col-12 col-sm-12 col-md-5">
                        <p id="textAboutTitle" class="text">Sobre Nós</p>
                        <p class="textAbout text-justify">
                            A lanchonete Chapéu de Paia é uma lanchonete com sistema delivery
                            onde busca atender os pedidos em pouco tempo e alta qualidade!
                        </p>

                    </div>
                    <div id="BoxImageSobre" class="mt-0 col-sm-12 col-md-7">
                        <div id="ImgAlign1"></div>
                        <div id="ImgAlign2"></div>
                    </div>
                </div> 
                <div id="BoxInfos" class="row m-0">
                    <div class="col-12 "><hr/></div>
                    <div class="col-6 col-md-4 col-lg-4 TimeHover m-0 anime">

                        <div class="col-12 m-auto text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve" width="512px" height="512px" class="MySvgTime"><g><g>
                            <path d="M31.634,37.989c1.041-0.081,1.99-0.612,2.606-1.459l9.363-12.944c0.287-0.397,0.244-0.945-0.104-1.293   c-0.348-0.347-0.896-0.39-1.293-0.104L29.26,31.555c-0.844,0.614-1.375,1.563-1.456,2.604s0.296,2.06,1.033,2.797   C29.508,37.628,30.413,38,31.354,38C31.447,38,31.54,37.996,31.634,37.989z M29.798,34.315c0.035-0.457,0.269-0.874,0.637-1.142   l7.897-5.713l-5.711,7.895c-0.27,0.371-0.687,0.604-1.144,0.64c-0.455,0.03-0.902-0.128-1.227-0.453   C29.928,35.219,29.762,34.771,29.798,34.315z" data-original="#000000" class="active-path" data-old_color="#999595" fill="#979393"/>
                            <path d="M54.034,19.564c-0.01-0.021-0.01-0.043-0.021-0.064c-0.012-0.02-0.031-0.031-0.044-0.05   c-1.011-1.734-2.207-3.347-3.565-4.809l2.148-2.147l1.414,1.414l4.242-4.243l-4.242-4.242l-4.243,4.242l1.415,1.415l-2.148,2.147   c-1.462-1.358-3.074-2.555-4.809-3.566c-0.019-0.013-0.03-0.032-0.05-0.044c-0.021-0.012-0.043-0.011-0.064-0.022   c-3.093-1.782-6.568-2.969-10.273-3.404V5h1.5c1.379,0,2.5-1.121,2.5-2.5S36.672,0,35.293,0h-9c-1.379,0-2.5,1.121-2.5,2.5   s1.121,2.5,2.5,2.5h1.5v1.156c-1.08,0.115-2.158,0.291-3.224,0.535c-0.538,0.123-0.875,0.66-0.751,1.198   c0.123,0.538,0.66,0.876,1.198,0.751c0.92-0.211,1.849-0.37,2.78-0.477l1.073-0.083c0.328-0.025,0.63-0.043,0.924-0.057V10   c0,0.553,0.447,1,1,1s1-0.447,1-1V8.03c3.761,0.173,7.305,1.183,10.456,2.845l-0.986,1.707c-0.276,0.479-0.112,1.09,0.366,1.366   c0.157,0.091,0.329,0.134,0.499,0.134c0.346,0,0.682-0.179,0.867-0.5l0.983-1.703c3.129,1.985,5.787,4.643,7.772,7.772   l-1.703,0.983C49.57,20.91,49.406,21.521,49.683,22c0.186,0.321,0.521,0.5,0.867,0.5c0.17,0,0.342-0.043,0.499-0.134l1.707-0.986   c1.685,3.196,2.698,6.798,2.849,10.619H53.63c-0.553,0-1,0.447-1,1s0.447,1,1,1h1.975c-0.151,3.821-1.164,7.423-2.849,10.619   l-1.707-0.986c-0.478-0.276-1.09-0.114-1.366,0.366c-0.276,0.479-0.112,1.09,0.366,1.366l1.703,0.983   c-1.985,3.129-4.643,5.787-7.772,7.772l-0.983-1.703c-0.277-0.48-0.89-0.643-1.366-0.366c-0.479,0.276-0.643,0.888-0.366,1.366   l0.986,1.707c-3.151,1.662-6.695,2.672-10.456,2.845V56c0-0.553-0.447-1-1-1s-1,0.447-1,1v1.976   c-1.597-0.055-3.199-0.255-4.776-0.617c-0.538-0.129-1.075,0.213-1.198,0.751c-0.124,0.538,0.213,1.075,0.751,1.198   C26.568,59.768,28.607,60,30.63,60c0.049,0,0.096-0.003,0.145-0.004c0.007,0,0.012,0.004,0.018,0.004   c0.008,0,0.015-0.005,0.023-0.005c4.807-0.033,9.317-1.331,13.219-3.573c0.031-0.014,0.064-0.021,0.094-0.039   c0.02-0.012,0.031-0.031,0.05-0.044c4.039-2.354,7.414-5.725,9.773-9.761c0.019-0.027,0.043-0.048,0.06-0.078   c0.012-0.021,0.011-0.043,0.021-0.064C56.317,42.476,57.63,37.89,57.63,33S56.317,23.524,54.034,19.564z M53.965,8.251l1.414,1.414   l-1.414,1.415L52.55,9.665L53.965,8.251z M29.793,6.021V3h-3.5c-0.275,0-0.5-0.225-0.5-0.5s0.225-0.5,0.5-0.5h9   c0.275,0,0.5,0.225,0.5,0.5S35.568,3,35.293,3h-3.5v3.021C31.445,6.007,31.113,6,30.793,6c-0.028,0-0.06,0.002-0.088,0.002   C30.68,6.002,30.655,6,30.63,6c-0.164,0-0.328,0.011-0.492,0.014C30.022,6.017,29.913,6.016,29.793,6.021z" data-original="#000000" class="active-path" data-old_color="#999595" fill="#979393"/>
                            <path d="M21.793,14h-5c-0.553,0-1,0.447-1,1s0.447,1,1,1h5c0.553,0,1-0.447,1-1S22.346,14,21.793,14z" data-original="#000000" class="active-path" data-old_color="#999595" fill="#979393"/>
                            <path d="M21.793,21h-10c-0.553,0-1,0.447-1,1s0.447,1,1,1h10c0.553,0,1-0.447,1-1S22.346,21,21.793,21z" data-original="#000000" class="active-path" data-old_color="#999595" fill="#979393"/>
                            <path d="M21.793,28h-15c-0.553,0-1,0.447-1,1s0.447,1,1,1h15c0.553,0,1-0.447,1-1S22.346,28,21.793,28z" data-original="#000000" class="active-path" data-old_color="#999595" fill="#979393"/>
                            <path d="M21.793,35h-19c-0.553,0-1,0.447-1,1s0.447,1,1,1h19c0.553,0,1-0.447,1-1S22.346,35,21.793,35z" data-original="#000000" class="active-path" data-old_color="#999595" fill="#979393"/>
                            <path d="M21.793,42h-13c-0.553,0-1,0.447-1,1s0.447,1,1,1h13c0.553,0,1-0.447,1-1S22.346,42,21.793,42z" data-original="#000000" class="active-path" data-old_color="#999595" fill="#979393"/>
                            <path d="M21.793,49h-7c-0.553,0-1,0.447-1,1s0.447,1,1,1h7c0.553,0,1-0.447,1-1S22.346,49,21.793,49z" data-original="#000000" class="active-path" data-old_color="#999595" fill="#979393"/>
                            </g></g> </svg>
                        </div>

                        <div class="col-12 mt-1 text-center">
                            Min 40min
                        </div>
                    </div>

                    <div class="col-6 col-md-4 col-lg-4 TimeHover m-0 anime">

                        <div class="col-12 m-auto text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 128 128" width="512px" height="512px" class="MySvgPrice"><g><title class="active-path" style="fill:#979393" data-old_color="#000000">DISCOUNT</title>
                            <path d="M84.412,45.225l-15-7.833a1.25,1.25,0,0,0-1.157,2.217l14.329,7.482v51.62H45.416V64.833a1.25,1.25,0,1,0-2.5,0V99.961a1.25,1.25,0,0,0,1.25,1.25H83.833a1.25,1.25,0,0,0,1.25-1.25V46.333A1.251,1.251,0,0,0,84.412,45.225Z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#979393"/>
                            <path d="M44.166,61.417a1.25,1.25,0,0,0,1.25-1.25v-.5a1.25,1.25,0,1,0-2.5,0v.5A1.25,1.25,0,0,0,44.166,61.417Z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#979393"/><path d="M44.166,55.417a1.25,1.25,0,0,0,1.25-1.25V47.091L59.473,39.75H62.75v2.423a3.725,3.725,0,1,0,2.5,0V28.039a1.25,1.25,0,0,0-2.5,0V37.25H59.166a1.255,1.255,0,0,0-.579.142l-15,7.833a1.251,1.251,0,0,0-.671,1.108v7.834A1.25,1.25,0,0,0,44.166,55.417ZM64,46.892a1.225,1.225,0,1,1,1.225-1.225A1.227,1.227,0,0,1,64,46.892Z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#979393"/>
                            <path d="M60.579,68.948a4.839,4.839,0,1,0-3.417,1.413A4.838,4.838,0,0,0,60.579,68.948Zm-5.067-5.067a2.333,2.333,0,1,1,0,3.3A2.326,2.326,0,0,1,55.511,63.881Z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#979393"/>
                            <path d="M67.421,75.791a4.833,4.833,0,1,0,6.835,0A4.838,4.838,0,0,0,67.421,75.791Zm5.067,5.067a2.333,2.333,0,1,1,0-3.3A2.335,2.335,0,0,1,72.489,80.858Z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#979393"/>
                            <path d="M70.486,64.116,55.747,78.856a1.25,1.25,0,1,0,1.768,1.767L72.253,65.884a1.25,1.25,0,1,0-1.768-1.768Z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#979393"/></g> 
                            </svg>
                        </div>

                        <div class="col-12 mt-1 text-center">
                            Ótimos Preços
                        </div>
                    </div>

                    <div class="col-12 col-md-4 col-lg-4 TimeHover m-0 anime">

                        <div class="col-12 m-auto text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve" width="512px" height="512px" class="MySvgTime"><g><g>
                            <path d="M31.634,37.989c1.041-0.081,1.99-0.612,2.606-1.459l9.363-12.944c0.287-0.397,0.244-0.945-0.104-1.293   c-0.348-0.347-0.896-0.39-1.293-0.104L29.26,31.555c-0.844,0.614-1.375,1.563-1.456,2.604s0.296,2.06,1.033,2.797   C29.508,37.628,30.413,38,31.354,38C31.447,38,31.54,37.996,31.634,37.989z M29.798,34.315c0.035-0.457,0.269-0.874,0.637-1.142   l7.897-5.713l-5.711,7.895c-0.27,0.371-0.687,0.604-1.144,0.64c-0.455,0.03-0.902-0.128-1.227-0.453   C29.928,35.219,29.762,34.771,29.798,34.315z" data-original="#000000" class="active-path" data-old_color="#999595" fill="#979393"/>
                            <path d="M54.034,19.564c-0.01-0.021-0.01-0.043-0.021-0.064c-0.012-0.02-0.031-0.031-0.044-0.05   c-1.011-1.734-2.207-3.347-3.565-4.809l2.148-2.147l1.414,1.414l4.242-4.243l-4.242-4.242l-4.243,4.242l1.415,1.415l-2.148,2.147   c-1.462-1.358-3.074-2.555-4.809-3.566c-0.019-0.013-0.03-0.032-0.05-0.044c-0.021-0.012-0.043-0.011-0.064-0.022   c-3.093-1.782-6.568-2.969-10.273-3.404V5h1.5c1.379,0,2.5-1.121,2.5-2.5S36.672,0,35.293,0h-9c-1.379,0-2.5,1.121-2.5,2.5   s1.121,2.5,2.5,2.5h1.5v1.156c-1.08,0.115-2.158,0.291-3.224,0.535c-0.538,0.123-0.875,0.66-0.751,1.198   c0.123,0.538,0.66,0.876,1.198,0.751c0.92-0.211,1.849-0.37,2.78-0.477l1.073-0.083c0.328-0.025,0.63-0.043,0.924-0.057V10   c0,0.553,0.447,1,1,1s1-0.447,1-1V8.03c3.761,0.173,7.305,1.183,10.456,2.845l-0.986,1.707c-0.276,0.479-0.112,1.09,0.366,1.366   c0.157,0.091,0.329,0.134,0.499,0.134c0.346,0,0.682-0.179,0.867-0.5l0.983-1.703c3.129,1.985,5.787,4.643,7.772,7.772   l-1.703,0.983C49.57,20.91,49.406,21.521,49.683,22c0.186,0.321,0.521,0.5,0.867,0.5c0.17,0,0.342-0.043,0.499-0.134l1.707-0.986   c1.685,3.196,2.698,6.798,2.849,10.619H53.63c-0.553,0-1,0.447-1,1s0.447,1,1,1h1.975c-0.151,3.821-1.164,7.423-2.849,10.619   l-1.707-0.986c-0.478-0.276-1.09-0.114-1.366,0.366c-0.276,0.479-0.112,1.09,0.366,1.366l1.703,0.983   c-1.985,3.129-4.643,5.787-7.772,7.772l-0.983-1.703c-0.277-0.48-0.89-0.643-1.366-0.366c-0.479,0.276-0.643,0.888-0.366,1.366   l0.986,1.707c-3.151,1.662-6.695,2.672-10.456,2.845V56c0-0.553-0.447-1-1-1s-1,0.447-1,1v1.976   c-1.597-0.055-3.199-0.255-4.776-0.617c-0.538-0.129-1.075,0.213-1.198,0.751c-0.124,0.538,0.213,1.075,0.751,1.198   C26.568,59.768,28.607,60,30.63,60c0.049,0,0.096-0.003,0.145-0.004c0.007,0,0.012,0.004,0.018,0.004   c0.008,0,0.015-0.005,0.023-0.005c4.807-0.033,9.317-1.331,13.219-3.573c0.031-0.014,0.064-0.021,0.094-0.039   c0.02-0.012,0.031-0.031,0.05-0.044c4.039-2.354,7.414-5.725,9.773-9.761c0.019-0.027,0.043-0.048,0.06-0.078   c0.012-0.021,0.011-0.043,0.021-0.064C56.317,42.476,57.63,37.89,57.63,33S56.317,23.524,54.034,19.564z M53.965,8.251l1.414,1.414   l-1.414,1.415L52.55,9.665L53.965,8.251z M29.793,6.021V3h-3.5c-0.275,0-0.5-0.225-0.5-0.5s0.225-0.5,0.5-0.5h9   c0.275,0,0.5,0.225,0.5,0.5S35.568,3,35.293,3h-3.5v3.021C31.445,6.007,31.113,6,30.793,6c-0.028,0-0.06,0.002-0.088,0.002   C30.68,6.002,30.655,6,30.63,6c-0.164,0-0.328,0.011-0.492,0.014C30.022,6.017,29.913,6.016,29.793,6.021z" data-original="#000000" class="active-path" data-old_color="#999595" fill="#979393"/>
                            <path d="M21.793,14h-5c-0.553,0-1,0.447-1,1s0.447,1,1,1h5c0.553,0,1-0.447,1-1S22.346,14,21.793,14z" data-original="#000000" class="active-path" data-old_color="#999595" fill="#979393"/>
                            <path d="M21.793,21h-10c-0.553,0-1,0.447-1,1s0.447,1,1,1h10c0.553,0,1-0.447,1-1S22.346,21,21.793,21z" data-original="#000000" class="active-path" data-old_color="#999595" fill="#979393"/>
                            <path d="M21.793,28h-15c-0.553,0-1,0.447-1,1s0.447,1,1,1h15c0.553,0,1-0.447,1-1S22.346,28,21.793,28z" data-original="#000000" class="active-path" data-old_color="#999595" fill="#979393"/>
                            <path d="M21.793,35h-19c-0.553,0-1,0.447-1,1s0.447,1,1,1h19c0.553,0,1-0.447,1-1S22.346,35,21.793,35z" data-original="#000000" class="active-path" data-old_color="#999595" fill="#979393"/>
                            <path d="M21.793,42h-13c-0.553,0-1,0.447-1,1s0.447,1,1,1h13c0.553,0,1-0.447,1-1S22.346,42,21.793,42z" data-original="#000000" class="active-path" data-old_color="#999595" fill="#979393"/>
                            <path d="M21.793,49h-7c-0.553,0-1,0.447-1,1s0.447,1,1,1h7c0.553,0,1-0.447,1-1S22.346,49,21.793,49z" data-original="#000000" class="active-path" data-old_color="#999595" fill="#979393"/>
                            </g></g> </svg>
                        </div>

                        <div class="col-12 mt-1 text-center mb-3">
                            Máximo 1:30 hrs
                        </div>
                    </div>
                </div>
                <div class="container-fluid" id="BoxPromocoes">

                    <div class="row BxCard" >
                        <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
                            <div class="MultiCarousel-inner">
                                <?php
                                $get = new Produtos();
                                $get->GetPromocao();
                                ?>

                            </div>
                            <button class="btn btn-primary leftLst" id="btn-np"><</button>
                            <button class="btn btn-primary rightLst" id="btn-np">></button>
                        </div>
                    </div>

                </div>

            </article>
            <?php
            $pages = new Paginas();
            $pages->GetModal();
            ?>
            <footer style="" id="footer" class=" mt-4 mb-4">
                <div class="HiddenDiv row m-0">
                    <?php
                    $comentario = new Comentario();
                    $comentario->getAllComents();
                    ?>

                </div>
                <?php
                if (isset($_SESSION['codigoUser'])) {
                    echo ' 
                    <div class = "BoxaddComent row m-0 mt-2">
                        <div class = "bxButtonAdd float-right">
                            <button type="button" data-toggle="modal" data-target="#addComent">
                                Adicionar comentário
                            </button>
                        </div>
                    </div>
                    
                    <div class="modal fade" id="addComent" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
                        
                        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                            <div class="modal-content">
                            <form method="POST">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="modal-title-default">Adicionar Comentario</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    
                                        <div class="row m-0 border">
                                            <textarea name="comentario" class="form-control form-control-alternative" rows="3" placeholder="Escreva aqui seu comentario" maxlength="200"></textarea>
                                        </div>
                                    
                                        
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" name="sendComent" class="btn btn-primary">Enviar Comentario</button>
                                    <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Cancelar</button> 
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>';
                }
                ?>
                <div class="row mt-4 m-0">
                    <div class="col-12 col-md" style="position: relative;">
                        <img src="includes/img/icons/logo2.png" class="d-none d-md-block" style="width:80px; height: 60px;position:absolute;top:20%; left:90%;transform:translate(-50%, -50%);"/>
                    </div>
                    <div class="col-6 col-md">
                        <h5>Informaçoes</h5>
                        <ul class="list-unstyled text-small">
                            <li><a class="text-muted" href="#BoxSobre">Sobre Nós</a></li>
                            <li><a class="text-muted" href="produtos.php">Produtos</a></li>
                            <li><a class="text-muted" href="#BoxPromoções">Promoções</a></li>
                            <li><a class="text-muted" href="#HiddenDiv">Comentários</a></li>
                            
                        </ul>
                        
                    </div>
                    <div class="col-6 col-md">
                        <h5>Bibliotecas e Extensões</h5>
                        <ul class="list-unstyled text-small">
                            <li><a class="text-muted" href="https://getbootstrap.com.br/docs/4.1/getting-started/introduction/">Bootstrap 4</a></li>
                            <li><a class="text-muted" href="https://jquery.com/">Jquery</a></li>
                            <li><a class="text-muted" href="https://demos.creative-tim.com/argon-dashboard/docs/getting-started/overview.html">Argon.js</a></li>
                            <li><a class="text-muted" href="https://kenwheeler.github.io/slick/">Slick.js</a></li>
                            <li><a class="text-muted" href="https://sweetalert2.github.io/">Sweet Alert</a></li>
                        </ul>
                        
                    </div>
                    <p class="col-12 textCopyright text-center mt-4 mb-3">Copyright © 2019 | Gabriel Neves, Caio Vinicius, Hellen Camille, Jennifer M., Daniele Martins</p>
                    
                </div>
            </footer>
        </section> 
        <div class="BxDadosCarrinho row row-center" id="bxDadosCarrinho">

        </div>
        <div class="BxDadosNotification row row-center" id="bxDadosNotification">

        </div>
        <div id="Msg">

        </div>
        <div id="bgDark">
            <div id="loader">
                <i class="fa fa-cog fa-spin fa-5x fa-fw MyLoad"></i>
            </div>
        </div>

        <?php
        if (isset($_SESSION['comentarioEnviado'])) {
            print "<script >
                                    swal(Comentário enviado!', 'Obrigado!', 'success');
                            </script>";
            unset($_SESSION['comentarioEnviado']);
        }
        ?>

        <script src="./includes/node_modules/jquery/dist/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="./includes/node_modules/bootstrap/dist/js/bootstrap.js"></script>
        <script src="./includes/js/jquery.js"></script>
        <script src="./includes/js/mostraSenha.js"></script>
        <script src="./includes/js/app.js"></script>
        <script src="./includes/js/swiper.min.js" ></script>
        <script src="./includes/js/CalculoPromo.js"></script>
        <script src="includes/js/forcaSenha.js"></script>
        <script src="includes/js/funcoes.js"></script>
        <script src="includes/js/mask.js"></script>
        <script src="includes/assets/js/argon-dashboard.js?v=1.1.0"></script>
        <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
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

    </body>
</html>
