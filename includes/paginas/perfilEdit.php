<?php
session_start();
include_once '../classes/Conexao.php';
include_once '../classes/UpdatePerfil.php';
include_once '../classes/Login.php';
$sessao = new Sair();
$sessao->sessao();
if (!isset($_SESSION['codigoUser'])) {
    header("Location: ../../");
}
if (isset($_POST['Altera'])) {
    $nome = filter_input(INPUT_POST, 'nomePerfil');
    $email = filter_input(INPUT_POST, 'emailPerfil');
    $senha = filter_input(INPUT_POST, 'senhaPerfil');
    $telefone = filter_input(INPUT_POST, 'telefonePerfil');
    $cidadeAltera = filter_input(INPUT_POST, 'cidadeUser');
    $estadoAlterar = filter_input(INPUT_POST, 'estadoUser');
    $bairroAlterar = filter_input(INPUT_POST, 'bairroUser');
    $ruaAlterar = filter_input(INPUT_POST, 'ruaCadastro');
    $numeroCasaAlterar = filter_input(INPUT_POST, 'numCasaUser');
    if (isset($_FILES['ImagemPerfil'])) {
        $extensaoTipo = $_FILES['ImagemPerfil']['type'];
        if (($extensaoTipo != "image/jpg") && ($extensaoTipo != "image/jpeg") && ($extensaoTipo != "image/png") && ($extensaoTipo != "")) {
            $_SESSION['extensaoinvalida'] = "Não pode ser utilizado esse tipo de extensão. Apenas jpg/jpeg e pngs";
            if ($_SESSION['fotoUser'] != "userDefaut.png") {
                
            } else {
                $_SESSION['fotoUser'] = "userDefaut.png";
            }
        } else {
            $extensao = strtolower(substr($_FILES['ImagemPerfil']['name'], -4));
            $novoNome = md5(time()) . $extensao;
            $pastaUser = md5($_SESSION['codigoUser']);
            $pasta = "../img/perfils/$pastaUser/";
            move_uploaded_file($_FILES['ImagemPerfil']['tmp_name'], $pasta . $novoNome);
            $altera = new UpdatePerfil($nome, $email, $senha, $telefone, $cidadeAltera, $estadoAlterar, $bairroAlterar, $ruaAlterar, $numeroCasaAlterar, $novoNome, $extensao, $pasta, $extensaoTipo);
        }
    } else if ($_SESSION['fotoUser'] == "") {
        $extensao = ".png";
        $extensaoTipo = "image/png";
        $novoNome = "userDefaut";
        $pasta = "../img/perfils/";
        $altera = new UpdatePerfil($nome, $email, $senha, $telefone, $cidadeAltera, $estadoAlterar, $bairroAlterar, $ruaAlterar, $numeroCasaAlterar, $novoNome, $extensao, $pasta, $extensaoTipo);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Chapéu de Paia</title>
        <link rel="stylesheet" type="text/css" href="../node_modules/bootstrap/compiler/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <link rel="shortcut icon" href="../img/icons/logo2.png" type="image/x-icon" />
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    </head>
    <body>
        <section class="container-fluid" id="BoxGeral">
            <header class="container-fluid" id="BoxInicial">

                <aside class="" id="infoPerfilEdit" tabindex="-1" role="dialog" >
                    <div class="modal-dialog modal-lg mt-3 mb-0" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Perfil</h5>
                            </div>
                            <form enctype="multipart/form-data" method="POST">
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-12 col-sm-12 mr-0 m-0 mt-0 mb-2" id="BoxUploadImage">
                                            <div class="m-0" id="UploadImage">
                                                <input type="file" id="InputUploader"  accept=".jpg, .jpeg" name="ImagemPerfil" onchange="previewImagem();"/>
                                                <label for="InputUploader" class="align-content-center " id="LabelUpload" > 

                                                    <?php
                                                    echo '<img src="../img/perfils/';
                                                    if ($_SESSION['fotoUser'] == "") {
                                                        echo 'userDefaut.png';
                                                    } else if ($_SESSION['fotoUser'] != "userDefaut.png") {
                                                        echo $_SESSION['pasta'] . '/' . $_SESSION['fotoUser'];
                                                    } else {
                                                        echo 'userDefaut.png';
                                                    }
                                                    echo '" class="img-fluid" id="BoxImg"/>  ';
                                                    ?>

                                                </label>
                                                <label for="InputUploader" class="BallStausPerfilAdd">
                                                    <div class="text MorePhoto">+</div>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-12 col-sm-12" id="BoxInfoPerfil">
                                        <div class="row container-fluid">
                                            <div class="col-12 col-lg-12">
                                                <p class="mb-2">Nome<font color="red">*</font></p>
                                                <input class="" type="text" id="InputName" name="nomePerfil" placeholder="Nome" value="<?php echo $_SESSION['nomeUser']; ?>"/>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <p class="mt-3 mt-lg-2 mb-1">Email<font color="red">*</font></p>
                                                <input class="" type="text" id="InputName" name="emailPerfil" placeholder="Email" value="<?php echo $_SESSION['emailUser']; ?>"/>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <p class="mt-3 mt-lg-2 mb-1">Senha<font color="red">*</font></p>

                                                <input class="SenhaPerfil" type="password" id="InputSenha" name="senhaPerfil" placeholder="Senha" value="<?php echo $_SESSION['senhaUser']; ?>"/>
                                                <button type="button" id="BtnViewHidden"><img class="eyePerfil" src="../img/icons/hide.png" id="view"/></button>
                                            </div>
                                            <div class="forcaSenhaBox col-12 mt-2 mb-2" id="forca"></div>
                                            <div class="col-12 col-lg-6">
                                                <p class="mt-3 mt-lg-2 mb-1">Número de Contato<font color="red">*</font></p>
                                                <input class="InputTel" type="text"  id="InputName" name="telefonePerfil" placeholder="(18)98194-9411" onKeyPress="mascara('## #####-####', this);" maxlength="13" value="<?php echo $_SESSION['telefoneUser']; ?>"/>
                                            </div>

                                            <div id="localizacao" class="collapsed row col-12 mt-2 m-0 p-0">
                                                <div class="col-4 col-lg-4">
                                                    <p class="mt-3 mt-lg-2 mb-1">Estado</p>
                                                    <select name="estadoUser" id="InputEstado">
                                                        <option value="SP" selected="">SP</option>
                                                    </select>
                                                </div>
                                                <div class="col-8 col-lg-8" >
                                                    <p class="mt-3 mt-lg-2 mb-1 ">Cidade</p>
                                                    <select name="cidadeUser" id="InputCidade">
                                                        <option value="Teodoro Sampaio" selected="">Teodoro Sampaio</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-lg-12" >
                                                    <p class="mt-3 mt-lg-2 mb-1 ">Bairro</p>
                                                    <input type="text" placeholder="Estação" name="bairroUser" id="InputBairro" value="<?php echo $_SESSION['bairroUser']; ?>"/>
                                                </div>
                                                <div class="col-8 col-lg-8" >
                                                    <p class="mt-3 mt-lg-2 mb-1 ">Rua</p>
                                                    <input type="text" placeholder="Ex:Avenida João Paes" name="ruaCadastro" id="InputBairro" value="<?php echo $_SESSION['ruaUser']; ?>"/>
                                                </div>
                                                <div class="col-4 col-lg-4 mr-0" >
                                                    <p class="mt-3 mt-lg-2 mb-1">Nº</p>
                                                    <input type="text" placeholder="1920" name="numCasaUser" maxlength="4" id="InputNumero" onkeypress="validaNumber(event)" value="<?php echo $_SESSION['numeroCasaUser']; ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">                            
                                    <a href="
                                    <?php
                                    if ($_SESSION['nivelUser'] == 3) {
                                        echo "admin.php";
                                    } else if ($_SESSION['nivelUser'] == 2) {
                                        echo "cozinha.php";
                                    } else if ($_SESSION['nivelUser'] == 1) {
                                        echo "entregas.php";
                                    } else if ($_SESSION['nivelUser'] == 0) {
                                        echo "../../";
                                    }
                                    ?>
                                       ">
                                        <input type="button" class="btn btn-danger" id="Cancel" value="Cancelar"/>
                                    </a>
                                    <input class="btn btn-success" id="Edit" type="submit" name="Altera" Value="Salvar"/>

                                </div>
                            </form>
                        </div>
                    </div>
                </aside>

                <?php
                if (isset($_SESSION['extensaoinvalida'])) {
                    print "<script>
                        swal({
                                                    title: 'Este tipo de arquivo não é permitido!',
                                                    animation: false,
                                                    customClass: {
                                                        popup: 'animated tada'
                                                    }
                                                    });</script>";
                    unset($_SESSION['extensaoinvalida']);
                }
                ?>
            </header>

        </section> 
        <script src="../node_modules/jquery/dist/jquery.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
        <script src="../js/app.js"></script>
        <script src="../js/jquery.js"></script>
        <script src="../js/mostraSenha.js"></script>
        <script src="../js/forcaSenha.js"></script>
        <script src="../js/mask.js"></script>
        <script src="../js/funcoes.js"></script>
    </body>
</html>
