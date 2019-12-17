<?php

class Paginas extends Conexao {

    public function dashboard() {
        ?>
        <article id="BoxManager"class="mb-3">
            <div class="container-fluid row " id="MinBoxManager">
                <div class="col-12 col-sm-6 col-md-6 col-md-6 col-lg-4" id="ManagerBoxItens">

                    <div id="ItensBox">
                        <a href="admin.php?usuarios">
                            <div class="col-12" id="BoxItenImg">
                                <img src="../img/icons/manager_users.png" id="ItenImg"/>

                            </div>
                            <div class="col-12 text text-center mt-2" id="BoxItenInfo">
                                <p id="ItenInfo">Gerenciar Usuários</p>
                            </div>
                        </a>
                    </div>

                </div>

                <div class="col-12 col-sm-6 col-md-6 col-md-6 col-lg-4" id="ManagerBoxItens">
                    <div id="ItensBox">
                        <a href="admin.php?produtos">
                            <div class="col-12" id="BoxItenImg">
                                <img src="../img/icons/manager_snacks.png" id="ItenImg"/>
                            </div>
                            <div class="col-12 text text-center mt-2" id="BoxItenInfo">
                                <p id="ItenInfo">Gerenciar Produtos</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-md-6 col-lg-4" id="ManagerBoxItens">

                    <div id="ItensBox">
                        <a href="admin.php?pedidos">
                            <div class="col-12" id="BoxItenImg">
                                <img src="../img/icons/manager_pedidos.png" id="ItenImg"/>

                            </div>
                            <div class="col-12 text text-center mt-2" id="BoxItenInfo">
                                <p id="ItenInfo">Gerenciar Pedidos</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-md-6 col-lg-4 " id="ManagerBoxItens">
                    <div id="ItensBox" class="">
                        <a href="admin.php?ingredientes">
                            <div class="col-12" id="BoxItenImg">
                                <img src="../img/icons/manager_ingredientes.png" id="ItenImg"/>

                            </div>
                            <div class="col-12 text text-center mt-2" id="BoxItenInfo">
                                <p id="ItenInfo">Gerenciar Ingredientes</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-md-6 col-lg-4" id="ManagerBoxItens">
                    <div id="ItensBox" class="">
                        <a href="admin.php?promocoes">
                            <div class="col-12" id="BoxItenImg">
                                <img src="../img/icons/manager_promotions.png" id="ItenImg"/>

                            </div>
                            <div class="col-12 text text-center mt-2" id="BoxItenInfo">
                                <p id="ItenInfo">Gerenciar Promoções</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-md-6 col-lg-4" id="ManagerBoxItens">
                    <div id="ItensBox" class="">
                        <a href="admin.php?historico">
                            <div class="col-12" id="BoxItenImg">
                                <img src="../img/icons/manager_historic.png" id="ItenImg"/>

                            </div>
                            <div class="col-12 text text-center mt-2" id="BoxItenInfo">
                                <p id="ItenInfo">Histórico</p>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </article>   
        <?php
    }

    public function administrarUsuarios() {
        ?>

        <article id="BoxManagerTable" class="">
            <form method="POST" name="Busca">
                <div class="container-fluid m-0 row bg-none">

                    <div class="col-12 col-sm-12 col-lg-9 mb-5 bg-none">
                        <p class="mt-3 mt-lg-2 mb-1">Buscar usuario pelo Nome<font color="red">*</font></p>

                        <input class="bg-none" type="text" id="InputSearch" name="NameBusca" placeholder="Nome do Usuário" />
                        <button type="button" id="BtnSearch" name="ExecBusca"><img class="eyePerfil" src="../img/icons/search_preto.png" id="view"/></button>
                        <button class="ml-md-5 ml-sm-2 ml-2" type="submit" name="BuscaAll" alt="Buscar todos os usuários" id="SearchAll">
                            <img src="../img/icons/refresh.png" />
                        </button>
                        <button class="ml-md-5 ml-sm-1 ml-2" type="button"  id="AddUser" data-toggle="modal" data-target="#modalCreateUser">
                            <img src="../img/icons/add-more.png" />
                        </button>
                    </div>

                </div>
            </form>

            <div class="container-fluid row pl-2 pr-2" id="MinBoxManager" style="overflow-x: auto;">

                <?php
                if (isset($_GET['usuarios'])) {
                    $usuarios = new AdministrarUsuarios();
                    if ((!isset($_POST['ExecBusca'])) || ((isset($_POST['BuscaAll'])))) {
                        $usuarios->BuscaTodosUsuarios();
                    } else if (isset($_POST['ExecBusca'])) {

                        $nome = filter_input(INPUT_POST, 'NameBusca', FILTER_SANITIZE_STRING);
                        $usuarios->BuscaUmUsuario($nome);
                    }
                }
                if (isset($_SESSION['usuExis'])) {
                    if ($_SESSION['usuExis'] == 'true') {


                        unset($_SESSION['usuExis']);
                    }
                }
                ?>
            </div>
        </article>

        <aside class="modal fade" id="modalEditUser" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg mt-0 mb-0" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Perfil</h5>

                    </div>
                    <form method="POST">
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-12 col-sm-12" id="BoxInfoPerfil">
                                    <div class="row container-fluid">
                                        <div class="col-12 col-lg-12">
                                            <p class="mb-2">Nome<font color="red">*</font></p>
                                            <input class="recipiente-nome" type="text" id="InputName" name="nameAlterar" placeholder="Nome" value=""/>
                                        </div>
                                        <div class="col-12 col-lg-9">
                                            <p class="mt-3 mt-lg-2 mb-1">Email<font color="red">*</font></p>
                                            <input class="recipiente-email" type="text" id="InputName" name="emailAlterar" placeholder="Email" />
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <p class="mt-3 mt-lg-2 mb-1">Pontos do Usuário<font color="red">*</font></p>

                                            <input class="recipiente-pontos" type="text" id="InputName" name="pontosAlterar" placeholder="1000"/>

                                        </div>
                                        <div class="col-6 col-lg-6">
                                            <p class="mt-3 mt-lg-2 mb-1">Número de Contato<font color="red">*</font></p>
                                            <input class="recipiente-telefone" type="text"  id="InputName" name="telefoneAlterar" placeholder="(18)98194-9411" onKeyPress="mascara('## #####-####', this);" maxlength="13" />
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <p class="mt-3 mt-lg-2 mb-1">Nivel de Acesso<font color="red">*</font></p>
                                            <select class="recipiente-nivel" id="InputName" name="nivelAlterar">                                                    
                                                <option value="0">0 - Usuário</option>
                                                <option value="1">1 - Cozinha</option>
                                                <option value="2">2 - Entregador</option>
                                                <option value="3">3 - Administrador</option>
                                            </select>
                                        </div>
                                        <div class="col-4 col-lg-4">
                                            <p class="mt-3 mt-lg-2 mb-1">Estado</p>
                                            <select name="estadoUser" id="InputEstado">
                                                <option value="SP" selected="">SP</option>
                                            </select>
                                        </div>
                                        <div class="col-8 col-lg-8" >
                                            <p class="mt-3 mt-lg-2 mb-1 ">Cidade</p>
                                            <select name="cidadeAlterar" id="InputCidade">
                                                <option value="Teodoro Sampaio" selected="">Teodoro Sampaio</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-lg-12" >
                                            <p class="mt-3 mt-lg-2 mb-1 ">Bairro</p>
                                            <input class="recipiente-bairro" type="text"  name="bairroAlterar" id="InputBairro"/>
                                        </div>
                                        <div class="col-8 col-lg-8" >
                                            <p class="mt-3 mt-lg-2 mb-1 ">Rua</p>
                                            <input class="recipiente-rua" type="text"  name="ruaAlterar" id="InputBairro" />
                                        </div>
                                        <div class="col-4 col-lg-4 mr-0" >
                                            <p class="mt-3 mt-lg-2 mb-1">Nº</p>
                                            <input class="recipiente-numeroCasa" type="text"   name="numeroAlterar" maxlength="4" id="InputNumero"/>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">      
                            <input type="hidden" class="recipiente-codigo" name="codigo"/>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" id="Cancel" value="Cancelar" />
                            <input class="btn btn-success" id="Edit" type="submit" name="Alterar" Value="Salvar"/>
                        </div>
                    </form>
                </div>

            </div>
        </aside>
        <aside class="modal fade" id="modalCreateUser" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg mt-0 mb-0" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cadastro</h5>

                    </div>
                    <form method="POST">
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-12 col-sm-12" id="BoxInfoPerfil">
                                    <div class="row container-fluid">
                                        <div class="col-12 col-lg-12">
                                            <p class="mb-2">Nome<font color="red">*</font></p>
                                            <input  type="text" id="InputName" name="nomeCadastro" placeholder="Nome" value=""/>
                                        </div>
                                        <div class="col-12 col-lg-12">
                                            <p class="mt-3 mt-lg-2 mb-1">Email<font color="red">*</font></p>
                                            <input  type="text" id="InputName" name="emailCadastro" placeholder="Email" />
                                        </div>
                                        <div class="col-12 col-lg-9">

                                            <p class="mt-3 mt-lg-2 mb-1">Senha<font color="red">*</font></p>
                                            <input class="SenhaCadastroAdm" type="password" id="InputSenhaCadastro" name="senhaCadastro" placeholder="Senha" required=""/>
                                            <button type="button" id="BtnViewHiddenAdm"><img class="eyeCadastroAdm" src="../img/icons/hide.png" id="view"/></button>

                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <p class="mt-3 mt-lg-2 mb-1">Pontos do Usuário<font color="red">*</font></p>

                                            <input  type="text" id="InputName" name="pontosCadastro" placeholder="1000"/>

                                        </div>
                                        <div class="col-6 col-lg-6">
                                            <p class="mt-3 mt-lg-2 mb-1">Número de Contato<font color="red">*</font></p>
                                            <input  type="text"  id="InputName" name="telefoneCadastro" placeholder="(18)98194-9411" onKeyPress="mascara('## #####-####', this);" maxlength="13" />
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <p class="mt-3 mt-lg-2 mb-1">Nivel de Acesso<font color="red">*</font></p>
                                            <select  id="InputName" name="nivelCadastro" class="">                                                    
                                                <option value="0">Usuário</option>
                                                <option value="1">Cozinha</option>
                                                <option value="3">Administrador</option>
                                            </select>
                                        </div>
                                        <div class="col-12 mt-3" id="BoxBtnCollapse">
                                            <label for="BtnCollapseLocalization" id="LabelCollapse">
                                                <p>Inserir informações de localização</p>
                                            </label>
                                            <input type="checkbox" id="BtnCollapseLocalization" data-toggle="collapse" data-target="#localizacao" class="m-0" />
                                        </div>
                                        <div id="localizacao" class="collapse row col-12 mt-2 m-0 p-0">
                                            <div class="col-4 col-lg-4">
                                                <p class="mt-3 mt-lg-2 mb-1">Estado</p>
                                                <select name="estadoCadastro" id="InputEstado">
                                                    <option value="sp" selected="">SP</option>
                                                </select>
                                            </div>
                                            <div class="col-8 col-lg-8" >
                                                <p class="mt-3 mt-lg-2 mb-1 ">Cidade</p>
                                                <select name="cidadeCadastro" id="InputCidade">
                                                    <option value="Teodoro Sampaio" selected="">Teodoro Sampaio</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-lg-12" >
                                                <p class="mt-3 mt-lg-2 mb-1 ">Bairro</p>
                                                <input type="text" placeholder="Estação" name="bairroCadastro" id="InputBairro"/>
                                            </div>
                                            <div class="col-8 col-lg-8" >
                                                <p class="mt-3 mt-lg-2 mb-1 ">Rua</p>
                                                <input type="text" placeholder="Avenida João Paes" name="ruaAlterar" id="InputBairro"/>
                                            </div>
                                            <div class="col-4 col-lg-4 mr-0" >
                                                <p class="mt-3 mt-lg-2 mb-1">Nº</p>
                                                <input type="text" placeholder="1920" name="numeroCasaAlterar" maxlength="4" id="InputNumero" />
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">      
                            <input type="button" class="btn btn-danger" data-dismiss="modal" id="Cancel" value="Cancelar" />
                            <input class="btn btn-success" id="Edit" type="submit" name="Cadastrar" Value="Cadastrar"/>
                        </div>
                    </form>
                </div>

            </div>
        </aside>


        <?php
    }

    public function administrarPedidos() {
        ?>

        <article id="BoxManagerPedidos" class="row p-0 p-md-5">
            <div id="BoxPedidos" class="col-12">
                <p class="TextPedidos">Pedidos</p>
                <div id="BoxMinPedidos" class="border col-12 row row-center p-0">
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
                                                <th scope="col">Usuário</th>
                                                <th scope="col">Localização</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Pagamento</th>
                                                <th scope="col">Valor</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $busca = new Pedidos();
                                            $busca->BucaPedidos();
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

        </article> 

        <div class="row">
            <div class="col-md-4">

                <div class="modal fade" id="modalEditPedido" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document" id="editPedidoModal">
                        <?php
                        include_once '../classes/setPromocao.php';
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">

                <div class="modal fade" id="showItens" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document" id="showItensPedido">


                        <?php
                        include_once '../classes/setPromocao.php';
                        ?>

                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function administrarProdutos() {
        ?>
        <article id="BoxManagerPedidos" class="row row-center p-0 p-sm-2 p-md-3 p-lg-5">
            <div id="BoxPedidos" class="col-12 col-md-12 col-lg-7 p-2 ">
                <p class="TextProdutos">Produtos</p>
                <div id="BoxMinProdutos" class="border col-12 p-0">
                    <div class="col-12 row pt-2 pl-2 pb-2 m-0 border" id="BoxProdutos">
                        <div class="col-7 col-lg-8"><b>Lista de Produtos</b></div>
                        <input type="checkbox" class="" id="Filter" data-toggle="collapse" data-target="#FilterOption"/>
                        <label for="Filter" class="col-3 col-lg-2" title="Filtrar">
                            <span class="FilterClass"></span>
                        </label>
                        <div class="col-2 col-lg-2">
                            <button class="ml-md-5 ml-sm-1 ml-2 Add" type="button" data-toggle="modal" data-target="#modalNewProduto" title="Adicionar Produto">
                                <img src="../img/icons/add-more.png" />
                            </button>
                        </div>
                        <div class="col-12 row collapse pt-3" id="FilterOption">
                            <p class="col-12">Fitrar por:</p>
                            <?php
                            $filter = new FuncaoProduto();
                            $filter->FilterGet();
                            ?>
                        </div>
                    </div>
                    <div class="col-12 row pt-2 pl-1 pb-1 m-0">
                        <div class="col-12">
                            <?php
                            $produto = new FuncaoProduto();
                            if (isset($_GET['filterTipo'])) {
                                if ($_GET['filterTipo'] > 0) {
                                    $id = $_GET['filterTipo'];
                                    $produto->FilterSet($id);
                                }
                            } else {
                                $produto->BuscaAllProdutos();
                            }
                            ?>

                        </div>

                    </div>
                </div>

            </div>
            <div id="BoxAddPedidos" class="col-12 col-md-12 col-lg-5 p-2">
                <p class="TextProdutos">Adicionar Tipos</p>
                <div id="BoxMinAddTipo" class="border col-12 pl-0 pr-0">
                    <div class="col-12 row pt-2 pl-2 pb-2 m-0 border">
                        <div class="col-9 "><b>Lista de Tipos</b></div>
                        <div class="col-3 ">
                            <button class="ml-md-5 ml-sm-1 ml-2 Add" type="button" data-toggle="modal" data-target="#modalNewIngrediente" title="Adicionar Tipo">
                                <img src="../img/icons/add-more.png" />
                            </button>
                        </div>
                    </div>
                    <div class="col-12 row pt-2 pl-1 pb-1 m-0">
                        <div class="col-12 custom-control custom-switch">
                            <?php
                            $tipos = new FuncaoTipo();
                            $tipos->BuscaAllTipos();
                            ?>

                        </div>

                    </div>

                </div>
            </div>
            <div class="modal fade" id="modalEditTipo" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
                <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                    <div class="modal-content">
                        <form class="" method="POST" id="boxEditTipo">
                            <?php
                                                        include_once '../classes/setPromocao.php';
                            ?>
                        </form>
                    </div>
                </div>
            </div>
            <aside class="modal fade" id="modalNewIngrediente" tabindex="-1" role="dialog" >
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header mb-0">
                            <h5 class="modal-title">Adicionar Tipos</h5>
                        </div>
                        <form method="POST" >
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-12 col-sm-12 mr-0 m-0 mt-0 mb-2">

                                    </div>
                                    <div class="col-12 col-sm-12" id="BoxInfoPerfil">
                                        <div class="row container-fluid">

                                            <div class="col-12 col-lg-12">
                                                <p class="mb-2">Nome do tipo<font color="red">*</font></p>
                                                <input class="" type="text" id="InputName" name="nomeTipo" placeholder="Ex: Bebidas" />
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">                            
                                <button class="btn btn-danger" data-dismiss="modal" id="Cancel">Cancelar</button>
                                <input class="btn btn-success" id="Edit" value="Salvar" type="submit" name="AddTipo"/>

                            </div>
                        </form>
                    </div>

                </div>
            </aside>
            <aside class="modal fade" id="modalNewProduto" tabindex="-1" role="dialog" >
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header mb-0">
                            <h5 class="modal-title">Adicionar Produto</h5>
                        </div>
                        <form method="POST" enctype="multipart/form-data" >
                            <div class="modal-body" style="overflow-y: visible;">

                                <div class="row">
                                    <div class="col-12 col-sm-12 mr-0 m-0 mt-0 mb-2">

                                    </div>
                                    <div class="col-12 col-sm-12" id="BoxInfoPerfil">
                                        <div class="container-fluid">

                                            <div class="row p-2">
                                                <div class="col-5" id="BoxImgProduto">
                                                    <div class="col-12 mt-0 ml-2 mr-2" id="BoxUploadImgPro" title="Adicionar Imagem" name="ImgProduto">
                                                        <input name="imgPro" type="file" id="InputUploadImgPro" onchange="previewImagemProduto();"/> 
                                                        <label for="InputUploadImgPro">
                                                            <img src="../img/produtos/proDefaut.png" class="imgDefautProduto"/>
                                                        </label>
                                                        <div>
                                                            <label for="InputUploadImgPro">
                                                                <img src="../img/icons/photo-camera.png" class="imgPhoto"/>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-7">
                                                    <p class="mb-2">Selecione o Tipo<font color="red">*</font></p>
                                                    <select name="tipoProduto" id="SelectTipo" required="">
                                                        <option value="0" selected="">Selecione...</option>
                                                        <?php
                                                        $produto->geraSelectTipo();
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-lg-9 mt-3">
                                                    <p class="mb-1">Nome do produto<font color="red">*</font></p>
                                                    <input type="text" id="InputNameProduto" name="NomeProduto" placeholder="ex: X-Tudo" required=""/>
                                                </div>
                                                <div class="col-12 col-lg-3 mt-3">
                                                    <p class="mb-1">Valor<font color="red">*</font></p>
                                                    <input type="text" id="InputValorProduto" name="ValorProduto" placeholder="ex:18.9" onkeyup="Formata(this)" required/>
                                                </div>
                                                <div class="col-12 col-lg-6 mt-1">
                                                    <p class="mb-1">Pontos do Produto<font color="red">*</font></p>
                                                    <input type="text" id="InputPontosProduto" name="PontosProduto" placeholder="ex:10" required="" onkeypress="validaNumber(event)"/>
                                                </div>
                                                <div class="col-12 col-lg-6 mt-1">
                                                    <p class="mb-1">Pontos do Usuário<font color="red">*</font></p>
                                                    <input type="text" id="InputPontosProduto" name="PontosProdutoUsu" placeholder="ex:10" required="" onkeypress="validaNumber(event)"/>
                                                </div>

                                                <div class="row col-12 mt-1 ml-1 mr-2"  id="BoxIng">                                                   
                                                    <?php
                                                    $produto->GetAllIngredientes();
                                                    ?>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">                            
                                <button class="btn btn-danger" data-dismiss="modal" id="Cancel">Cancelar</button>
                                <input class="btn btn-success" id="Edit" value="Cadastrar" type="submit" name="AddProduto"/>

                            </div>
                        </form>
                    </div>

                </div>
            </aside>

            <?php
            if (isset($_SESSION['jeepnt'])) {
                if ($_SESSION['jeepnt'] == "jaExist") {
                    echo "<script>"
                    . "Swal.fire({
						  position: 'top-end',
						  icon: 'error',
						  title: 'Aconteceu algum erro!'
						  showConfirmButton: false,
						  timer: 1500
						})</script>";
                } else if ($_SESSION['jeepnt'] == "cadastrado") {
                    echo "<script>"
                    . "Swal.fire({
						  position: 'top-end',
						  icon: 'success',
						  title: 'Seu produto foi cadastrado',
						  showConfirmButton: false,
						  timer: 1500
						})</script>";
                }
                unset($_SESSION['jeepnt']);
            }
            if (isset($_SESSION['errorExtensao'])) {
                if ($_SESSION['errorExtensao'] == "imgError") {
                    echo "<script>"
                    . "swal({
                                        icon: 'error',
                                        title: 'Isto não é uma imagem!',
                                        text: 'Por favor, escolha uma imagem JPG ou JPEG/PNG!',
                                        footer: '',
                                      })</script>";
                    unset($_SESSION['errorExtensao']);
                }
            }
            ?>
        </article>
        <?php
    }

    public function editProduto() {
        $produtos = new FuncaoProduto();
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $id = $_GET['id'];
            $dados = $produtos->AllInformProduto($id);
            if ($dados) {
                $valor = number_format($dados['pro_valor'], 2, ',', '.');
                ?>

                <article class="row p-0 p-md-3 pd-lg-5  container-fluid m-0" id="BoxEdit">
                    <form method="POST" class="m-0 col-12 mt-2 " enctype="multipart/form-data">
                        <input type="hidden" value="<?php echo $dados['pro_codigo']; ?>" name="proCodigo" />
                        <div class="col-12 pb-0 mb-0">
                            <p class="TextTittleEdit mb-5">Edição do produto <b><?php echo $dados['pro_nome']; ?></b></p>
                        </div>
                        <div class="col-12 row mt-0 p-0 m-0 border">
                            <div class="col-lg-3 col-12 mt-3 p-3 m-0" id="BoxImgEditProduto">
                                <div class="row-center" id="BoxUploadImgEditPro" title="Adicionar Imagem">
                                    <input name="imgProEdit" type="file" id="InputUploadImgPro" onchange="previewEditProduto();"/> 
                                    <label for="InputUploadImgPro">
                                        <?php
                                        echo '<img src = "../img/produtos/';
                                        if ($dados['pro_foto'] == 'proDefaut.png') {
                                            echo $dados['pro_foto'];
                                        } else {
                                            $pasta = md5($dados['tip_codigo']);
                                            echo $pasta . '/' . $dados['pro_foto'];
                                        }
                                        echo'" class = "EditProdutoImg"/>';
                                        ?>
                                    </label>
                                    <div>
                                        <label for="InputUploadImgPro">
                                            <img src="../img/icons/photo-camera.png" class="imgPhoto"/>
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-9 col-12 row m-0">
                                <label class="col-12 col-md-6 mt-2">
                                    <p class="text text-namePro">Tipo</p>
                                    <select name="tipoProdutoEdit" id="SelectTipo" required="">
                                        <option value="0" selected="">Selecione...</option>
                                        <?php
                                        $produtos->geraSelectTipoSelected($dados['tip_codigo']);
                                        ?>
                                    </select>
                                </label>
                                <label class="col-12 col-md-6 mt-2">
                                    <p class="text text-namePro">Nome do Produto</p>
                                    <input type="text" placeholder="Nome do Produto" name="nomeProdutoEdit" required id="InputNameProduto" value="<?php echo $dados['pro_nome']; ?>"/>
                                </label>
                                <label class="col-6 col-md-6 mt-2">
                                    <p class="text text-namePro">Valor do Produto (R$)</p>
                                    <input type="text" id="InputValorProduto" name="valorProdutoEdit" required onkeyup="Formata(this)" value="<?php echo $valor; ?>"/>
                                </label>
                                <label class="col-6 col-md-6 mt-2">
                                    <p class="text text-namePro">Pontos do Produto</p>
                                    <input type="text" id="InputValorProduto" name="pontosProdutoEdit" required onkeypress="validaNumber(event)" value="<?php echo $dados['pro_pontos']; ?>"/>
                                </label>
                                <label class="col-6 col-md-6 mt-2">
                                    <p class="text text-namePro">Pontos do Usuário</p>
                                    <input type="text" id="InputValorProduto" name="pontosProdutoUsuEdit" required onkeypress="validaNumber(event)" value="<?php echo $dados['pro_pontosUsu']; ?>"/>
                                </label>
                                <div class="col-12 m-0 mt-2 row mb-3" style="overflow-y: auto;">
                                    <?php
                                    $produtos->GetIngredientesByProduto($id);
                                    ?>
                                </div>

                            </div>
                            <div class="col-12 m-0 row mt-2">
                                <label class="col-0 col-md-6 col-lg-8"></label>
                                <label class="col-6 col-md-3 col-lg-2 ">
                                    <a href="admin.php?produtos">
                                        <button type="button" id="BtnCancel">Cancelar</button>
                                    </a>
                                </label>
                                <label class="col-6 col-md-3 col-lg-2">
                                    <button tyepe="submit" id="BtnSave" name="AtualizarProduto">Salvar</button>
                                </label>
                            </div>
                        </div>
                    </form>
                </article>
                <?php
            } else {
                echo '<div class="row row-center mt-5">'
                . '<label class="col-12">'
                . '<p class="text text-center text-danger">Este Produto não existe!</p>
                    </label>
                    </div>';
            }
        }
    }

    public function administrarIngredientes() {
        ?>

        <article id="BoxManagerPedidos" class="row p-5">
            <div id="BoxPedidos" class="col-12 col-md-12 col-lg-7 p-2">
                <p class="TextProdutos">Ingredientes</p>
                <div id="BoxMinProdutos" class="border col-12 p-0">
                    <div class="col-12 row pt-2 pl-2 pb-2 m-0 border" id="BoxProdutos">
                        <div class="col-7 col-lg-6"><b>Lista de Ingredientes</b></div>
                        <form class="col-5 col-lg-6 p-0" method="POST" name="BuscaUmIgr">
                            <div class="col-12 col-lg-12 p-0" >
                                <input type="text" class="buscaIn float-right" name="igrSearch" placeholder="Ex: Milho"/>
                            </div>
                        </form>
                    </div>
                    <form method="POST" class="col-12">
                        <div class="col-12 pt-2 pl-1 pb-1 m-0">

                            <div class="col-12">

                                <?php
                                $ingredientes = new Ingredientes();
                                if (isset($_POST['igrSearch'])) {
                                    if ($_POST['igrSearch'] != null) {
                                        $nome = $_POST['igrSearch'];
                                        $ingredientes->buscaIngredienteName($nome);
                                    }
                                } else {
                                    $ingredientes->BuscaIngredientes();
                                    if (isset($_SESSION['msgError'])) {
                                        if ($_SESSION['msgError'] == "Error") {
                                            echo "<script>swal({
                                                                    icon: 'error',
                                                                    title: 'Oops...',
                                                                    text: 'Something went wrong!',
                                                                    footer: '<a href>Why do I have this issue?</a>'
                                                                  })</script>";
                                        } else if ($_SESSION['msgError'] == "success") {
                                            echo "<script>"
                                            . "swal({
                                                                position: 'top-end',
                                                                icon: 'success',
                                                                title: 'Seu Ingrediente foi atualizado',
                                                                showConfirmButton: true,
                                                                timer: 1700
                                                              })</script>";
                                        } else if ($_SESSION['msgError'] == "errorUpt") {
                                            echo "<script>"
                                            . "swal({
                                                                icon: 'error',
                                                                title: 'Oops...',
                                                                text: 'Aconteceu algum erro inesperado!',
                                                                footer: ''
                                                              })</script>";
                                        } else if ($_SESSION['msgError'] == "AltDes") {
                                            echo "<script>"
                                            . "swal({
                                                                icon: 'info',
                                                                title: 'Nada modificado',
                                                                text: 'Você não alterou nada!',
                                                                footer: '',
                                                                timer: 2000
                                                              })</script>";
                                        } else {
                                            echo $_SESSION['msgError'];
                                        }
                                        unset($_SESSION['msgError']);
                                    }
                                }
                                ?>

                            </div>


                        </div>
                        <div class="col-12 mt-2 mb-3">
                            <button type="submit" class="mr-3 BtnDelVarios float-right mb-2" name="ApagarIgr">
                                Apagar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="BoxAddPedidos" class="col-12 col-md-12 col-lg-5 p-2">
                <p class="TextProdutos">Adicionar Igredientes</p>
                <div id="BoxMinAddTipo" class="border col-12 pl-0 pr-0">
                    <div class="col-12 pt-2 pl-1 pb-1 m-0">
                        <form method="POST">
                            <div class="col-12 row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <p class="mb-2">Nome<font color="red">*</font></p>
                                    <input type="text" placeholder="Ex: Ovo" name="nomeIngrediente" id="InputIngredienteName" maxlength="40">
                                </div>
                                <div class="col-12 col-md-12 col-lg-7">
                                    <p class="mb-2">Valor<font color="red">*</font></p>
                                    <input type="text" placeholder="2,00" name="valorIngrediente" id="InputValor" onkeyup="Formata(this);"/>
                                </div>
                                <div class="col-12 col-md-12 col-lg-5">
                                    <button class="mt-4 BtnCadastraIngrediente" type="button" id="BtnIgr" name="CadastroIngrediente">Cadastrar</button>
                                </div>
                                <div class="col-12">
                                    <?php
                                    if (isset($_SESSION['msgFaltacampos'])) {
                                        echo $_SESSION['msgFaltacampos'];
                                        unset($_SESSION['msgFaltacampos']);
                                    }
                                    ?>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </article>
        <aside class="modal fade" id="modalEditIngre" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header mb-0">
                        <h5 class="modal-title">Editar Ingrediente</h5>
                        <h5 class="modal-title"><img src="../img/icons/chili.png" style="width: 25px;height: 25px;"/></h5>
                    </div>
                    <form method="POST" >
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-12 col-sm-12 mr-0 m-0 mt-0 mb-2">
                                    <input type="hidden" class="igr-codigo" name="IdAlt"/>
                                </div>
                                <div class="col-12 col-sm-12" id="BoxInfoPerfil">
                                    <div class="row container-fluid">
                                        <div class="col-12 col-lg-12">
                                            <p class="mb-2">Nome</p>
                                            <input type="text" class="igr-nome" id="NameIgr" name="nomeAlt"/>
                                        </div>
                                        <div class="col-12 col-lg-12">
                                            <p class="mb-2">Valor($)</p>
                                            <input type="text" class="igr-valor" id="ValorIgr" name="valAlt" onkeyup="Formata(this)"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">                            
                            <button class="btn btn-danger" data-dismiss="modal" id="Cancel">Cancelar</button>
                            <input class="btn btn-success" id="Edit" value="Salvar" type="submit" name="editIgr"/>

                        </div>
                    </form>
                </div>

            </div>
        </aside>

        <?php
        if (isset($_SESSION['msgNaDel'])) {
            if ($_SESSION['msgNaDel'] == 'N') {
                echo "<script>"
                . "swal({
                                                                icon: 'error',
                                                                title: 'Oops...',
                                                                text: 'Aconteceu algum erro inesperado!',
                                                                footer: ''
                                                              })</script>";

                unset($_SESSION['msgNaDel']);
            }
        }
    }

    function AdministrarPromocao() {
        ?>

        <article class="row BxCard fundoPromo container-fluid m-0" id="BoxManagerPromocoes">
            <p class="TextTittleEdit col-12 col-lg-6 mt-4 ml-3">Adminitração de Promoções</p>

            <div class="MultiCarousel" data-items="1,3,4,5" data-slide="1" id="MultiCarousel"  data-interval="1000">

                <div class="MultiCarousel-inner">
                    <div class="item ">

                        <div class="pad15 row" id="proDefaut" title="Clique no botão de + para adicionar">
                            <div class="BxAddPromocao col-12">
                                <a href="#" data-target="#AddPromocaoModal" data-toggle="modal">
                                    <div class="AddPromocao">

                                    </div>
                                </a>
                            </div>
                            <div class="BoxTextAddPromocao col-12 p-0">
                                <div class="row row-center m-0">
                                    <p class="TittlePro col-12 text-center">Adicionar Promoções</p>

                                </div>
                            </div>
                        </div>

                    </div>
                    <?php
                    $promocoes = new FuncaoPromocao();
                    $promocoes->getAllPromocoes();
                    ?>

                </div>
                <button class="btn btn-primary leftLst" id="btn-np"><</button>
                <button class="btn btn-primary rightLst" id="btn-np">></button>
            </div>
        </article>

        <aside class="modal fade" id="AddPromocaoModal" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cadastrar Promoções</h5>
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="modal-body">

                            <div class="row  row-center">
                                <div class="col-12">
                                    <div class="col-12 col-sm-12 mr-0 m-0 mt-0 mb-2">

                                    </div>
                                    <div class="col-12 col-sm-12" id="BoxInfoPerfil">
                                        <div class="container-fluid">

                                            <div class="row p-2">
                                                <div class="col-5 row m-0 row-center " id="BoxImgProduto">
                                                    <div class="col-12 row-center m-0 imgPromocaoCenter" id="BoxUploadImgPro" title="Adicionar Imagem" name="ImgPromocao">
                                                        <input name="imgPromo" type="file" id="InputUploadImgPro" onchange="previewImagemPromocao();"/> 
                                                        <label for="InputUploadImgPro">
                                                            <img src="../img/produtos/proDefaut.png" class="imgDefautPromocao"/>
                                                        </label>
                                                        <div>
                                                            <label for="InputUploadImgPro" >
                                                                <img src="../img/icons/photo-camera.png" class="imgPhoto"/>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-12 col-lg-9 mt-3">
                                                    <p class="mb-1">Nome da Promoção<font color="red">*</font></p>
                                                    <input type="text" id="InputNameProduto" name="NomePromocao" placeholder="ex: 1 Xmailo + 2 X-Tudo" required=""/>
                                                </div>
                                                <div class="col-12 col-lg-3 mt-3">
                                                    <p class="mb-1">Valor<font color="red">*</font></p>
                                                    <input type="text" id="InputValorProduto" name="ValorPromocao" placeholder="ex:18.9" onkeyup="Formata(this)" required/>
                                                </div>
                                                <div class="col-12 col-lg-6 mt-3">
                                                    <p class="mb-1">Pontos do Produto<font color="red">*</font></p>
                                                    <input type="text" id="InputPontosProduto" name="PontosPromocaoPro" placeholder="ex:100" required="" onkeypress="validaNumber(event)"/>
                                                </div>
                                                <div class="col-12 col-lg-6 mt-3">
                                                    <p class="mb-1">Pontos para Usuário<font color="red">*</font></p>
                                                    <input type="text" id="InputPontosProduto" name="PontosPromocaoUsu" placeholder="ex:10" required="" onkeypress="validaNumber(event)"/>
                                                </div>
                                                <div class="row col-12 mt-1 ml-1 mr-2"  id="BoxIng">                                                   

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">                            
                            <button class="btn btn-danger" data-dismiss="modal" id="Cancel">Cancelar</button>
                            <button type="submit" name="cadastraPromocao" class="btn btn-success" id="Edit">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </aside>
        <aside class="modal fade" id="modalEditPromocao" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-md" role="document" id="Msg">
                <?php
                include_once '../classes/setPromocao.php';
                ?>

            </div>
        </aside>

        <?php
    }

    function administrarHistorico() {
        $historico = new FuncaoPromocao();
        ?>
        <article class="BoxHistorico border">
            <div class="row row-center container-fluid border pt-5">
                <div class="BxItenHistorico row col-12 row-center m-0">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
                        <div class="itensHistorico p-2">
                            <div class="showInformHistorico row row-center bg-light">
                                <div class="col-3 bxImgHistorico">
                                    <img src="../img/icons/receita.png" />
                                </div>
                                <div class="col-9 row row-center">
                                    <div class="col-12">
                                        <p class="float-right textInformHistorico">RECEITA /MÊS</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="float-right InformHistorico">
                                            <?php
                                            $receita = $historico->countReceita();
                                            $valorTotal = ' R$ ' . number_format($receita, 2, ',', '.');
                                            echo $valorTotal;
                                            ?>
                                        </p>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
                        <div class="itensHistorico p-2">
                            <div class="showInformHistorico row row-center bg-light">
                                <div class="col-4 bxImgHistorico">
                                    <img src="../img/icons/vendidos.png" />
                                </div>
                                <div class="col-8 row row-center">
                                    <div class="col-12">
                                        <p class="float-right textInformHistorico">VENDAS /MÊS</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="float-right InformHistorico">
                                            <?php
                                            $vendas = $historico->countVendas();
                                            echo $vendas;
                                            ?>
                                        </p>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
                        <div class="itensHistorico p-2">
                            <div class="showInformHistorico row row-center bg-light">
                                <div class="col-4 bxImgHistorico">
                                    <img src="../img/icons/man-user.png" />
                                </div>
                                <div class="col-8 row row-center">
                                    <div class="col-12">
                                        <p class="float-right textInformHistorico">USUÁRIOS</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="float-right InformHistorico">
                                            <?php
                                            $users = $historico->countUser();
                                            echo $users;
                                            ?>
                                        </p>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
                        <div class="itensHistorico p-2">
                            <div class="showInformHistorico row row-center bg-light">
                                <div class="col-4 bxImgHistorico">
                                    <img src="../img/icons/efficiency.png" />
                                </div>
                                <div class="col-8 row row-center">
                                    <div class="col-12">
                                        <p class="float-right textInformHistorico">PRODUTOS</p>
                                    </div>
                                    <div class="col-12">
                                        <p class="float-right InformHistorico">
                                            <?php
                                            $products = $historico->countProducts();
                                            echo $products;
                                            ?>
                                        </p>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row row-center col-12 ">

                    <div class="col-12 mt-4 ml-2">
                        <div class="row">

                            <div class="col-xl-12">
                                <div class="card shadow">
                                    <div class="card-header bg-transparent">
                                        <div class="row align-items-center">
                                            <div class="col">

                                                <h6 class="text-uppercase text-muted ls-1 mb-1">Vendas</h6>
                                                <h2 class="mb-0">Total de Vendas</h2>
                                            </div>
                                            <div class="col">
                                                <button type="button" class="btnAtualiza float-right" data-toggle="chart" data-target="#chart-orders" data-update='{"data":{"datasets":[{"data":[<?php $historico->getDates(); ?>]}]}}'>
                                                    Atualizar
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="chart">
                                                <!-- Chart wrapper -->
                                                <canvas id="chart-orders" class="chart-canvas" ></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5 mb-5">
                            <div class="col-12 mb-5 mb-xl-0">
                                <div class="card shadow">
                                    <div class="card-header border-0">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h3 class="mb-0">Histórico de Vendas/Mensal</h3>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <!-- Projects table -->
                                        <table class="table align-items-center table-flush">

                                            <?php
                                            $historico->getVendas();
                                            ?>

                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </article>

        <?php
    }

    function GetModal() {
        if (isset($_SESSION['codigoUser'])) {
            ?>

            <!-- /*Parte aonde está os modal do cadastrar e logar*/ -->
            <aside class="modal fade" id="infoPerfil" tabindex="-1" role="dialog" >
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Perfil</h5>
                            <p><font style="color: blue;">Pontos</font><b> <?php echo $_SESSION['pontosUser']; ?></b></p>
                        </div>

                        <div class="modal-body">
                            <form>
                                <div class="row">
                                    <div class="col-12 col-sm-12 mr-0 m-0 mt-0 mb-2" id="BoxUploadImage">
                                        <div class="m-0" id="UploadImage">
                                            <input type="file" id="InputUploader" disabled="disabled"/>
                                            <label for="InputUploader" class="align-content-center " id="LabelUpload"> 

                                                <?php
                                                echo '<img src="includes/img/perfils/';
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
                                    <?php
                                    if (isset($_SESSION['codigoUser'])) {
                                        ?>

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
                                                    <button type="button" id="BtnViewHidden" disabled="disabled"><img class="eyePerfil" src="includes/img/icons/hide.png" id="view"/></button>
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
                                                        <input type="text" placeholder="Estação" disabled="" name="bairroUser" id="InputBairro" value="<?php echo $_SESSION['bairroUser']; ?>"/>
                                                    </div>
                                                    <div class="col-8 col-lg-8" >
                                                        <p class="mt-3 mt-lg-2 mb-1 ">Rua</p>
                                                        <input type="text" placeholder="Avenida João Paes" disabled="" name="ruaCadastro" id="InputBairro" value="<?php echo $_SESSION['ruaUser']; ?>"/>
                                                    </div>
                                                    <div class="col-4 col-lg-4 mr-0" >
                                                        <p class="mt-3 mt-lg-2 mb-1">Nº</p>
                                                        <input type="text" placeholder="1920" name="numCasaUser" disabled="" maxlength="4"  id="InputNumero" value="<?php echo $_SESSION['numeroCasaUser']; ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="modal-footer">                            
                                <button class="btn btn-danger" data-dismiss="modal" id="Cancel">Cancelar</button>
                                <a href="includes/paginas/perfilEdit.php" class="hrefIndex">
                                    <button class="btn btn-success" id="Edit">Editar</button>
                                </a>
                            </div>

                        </div>

                    </div>
                </aside>

                <?php
            }
        } else {
            ?>
            <aside class="modal fade" id="cadastrar" tabindex="-1" role="dialog" >
                <div class="modal-dialog mt-0 pt-4 mb-0 modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Cadastre-se</h5>
                            <button type="button" class="close" data-dismiss="modal" id="MyClose">
                                <span >&Cross;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form method="POST" name="cadastra">
                                <div class="row">
                                    <div class="col-12" id="BoxCadastro">
                                        <div class="row container-fluid">
                                            <div class="col-12 col-lg-12">
                                                <p class="mb-2">Nome<font color="red">*</font></p>
                                                <input class="" type="text" id="InputName" name="nomeCadastro"  placeholder="Nome" required=""/>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <p class="mt-3 mt-lg-2 mb-1">Email<font color="red">*</font></p>
                                                <input class="" type="email" id="InputName" maxlength="200" name="emailCadastro" placeholder="Email" required=""/>
                                            </div>
                                            <div class="col-12 col-lg-6">

                                                <p class="mt-3 mt-lg-2 mb-1">Senha<font color="red">*</font></p>
                                                <input class="SenhaCadastro" type="password" id="InputSenhaCadastro" name="senhaCadastro" placeholder="Senha" required="" onkeyup="ValidarSenhaForca()"/>
                                                <button type="button" id="BtnViewHiddenCadastro"><img class="eyeCadastrar" src="includes/img/icons/hide.png" id="view"/></button>

                                            </div>
                                            <div class="forcaSenhaBox col-12 mt-2 mb-2" id="forca"></div>
                                            <div class="col-12 col-lg-6">
                                                <p class="mt-3 mt-lg-2 mb-1">Número de Contato<font color="red">*</font></p>
                                                <input class="InputTel" type="text"  id="InputName" name="telefoneCadastro" placeholder="(00)00000-0000" onKeyPress="mascara('## #####-####', this);" maxlength="13"/>
                                            </div>
                                            <div id="localizacao" class="row mt-2 ml-2 mr-2">
                                                <div class="col-4 col-lg-4">
                                                    <p class="mt-3 mt-lg-2 mb-1">Estado<font color="red">*</font></p>
                                                    <select name="estadoUser" id="InputEstado">
                                                        <option value="SP" selected="">SP</option>
                                                    </select>
                                                </div>
                                                <div class="col-8 col-lg-8" >
                                                    <p class="mt-3 mt-lg-2 mb-1 ">Cidade<font color="red">*</font></p>
                                                    <select name="cidadeUser" id="InputCidade">
                                                        <option value="Teodoro Sampaio" selected="">Teodoro Sampaio</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-lg-12" >
                                                    <p class="mt-3 mt-lg-2 mb-1 ">Bairro<font color="red">*</font></p>
                                                    <input type="text" placeholder="Ex:Estação" name="bairroUser" id="InputBairro" required=""/>
                                                </div>
                                                <div class="col-8 col-lg-8" >
                                                    <p class="mt-3 mt-lg-2 mb-1 ">Rua<font color="red">*</font></p>
                                                    <input type="text" placeholder="Ex:Avenida João Paes" name="ruaCadastro" id="InputBairro" required=""/>
                                                </div>
                                                <div class="col-4 col-lg-4 mr-0" >
                                                    <p class="mt-3 mt-lg-2 mb-1">Nº<font color="red">*</font></p>
                                                    <input type="text" placeholder="Ex:1920" name="numCasaUser" maxlength="4" id="InputNumero" onkeypress="validaNumber(event)" required=""/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">                            
                                    <input type="button" class="btn btn-danger" data-dismiss="modal" id="Cancel" value="Cancelar"/>
                                    <button class="btn btn-success Save" type="submit" name="cadastrar">Cadastrar</button>
                                </div>  
                            </form>
                        </div>
                        <?php
                        if (isset($_SESSION['Msgcadastro'])) {
                            if ($_SESSION['Msgcadastro'] == "ja tem!") {
                                print "<script >
                                    swal('Putz...', 'Este email já está em uso!', 'error');
                            </script>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </aside>
            <aside class="modal fade" id="login" tabindex="-1" role="dialog" >
                <div class="modal-dialog modal-md mt-0 pt-4 mb-0" role="document">
                    <div class="modal-content">
                        <!-- HELLEN AQUI È PARTE DA INFORMAÇÃO QUE IRA APARECER SOBRE O LANCHE -->

                        <div class="modal-header">
                            <h5 class="modal-title">Login</h5>
                            <button type="button" class="close" data-dismiss="modal" id="MyClose">

                                <span >&Cross;</span>

                            </button>
                        </div>
                        <form method="POST" name="login">
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-12" id="BoxCadastro">
                                        <div class="row container-fluid">
                                            <div class="col-12 col-lg-12">
                                                <p class="mb-2">Email<font color="red">*</font></p>
                                                <input class="" type="email" id="InputName" name="emailLogin" placeholder="Email" required=""/>
                                            </div>
                                            <div class="col-12">
                                                <p class="mt-3 mt-lg-2 mb-1">Senha<font color="red">*</font></p>
                                                <input class="SenhaLogin" type="password" id="InputSenha" name="senhaLogin" placeholder="Senha" required=""/>
                                                <button type="button" id="BtnViewHiddenLogin"><img class="eyeLogin" src="includes/img/icons/hide.png" id="view"/></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">                            
                                <input type="button" class="btn btn-danger" id="Cancel" value="Cancelar" data-dismiss="modal"/>
                                <button class="btn btn-success Save" type="submit" name="logar">Logar</button>
                            </div>
                        </form>
                    </div>

                </div>
                <div id="mensagem">
                    <?php
                    if (isset($_SESSION['Msglogin'])) {
                        if ($_SESSION['Msglogin'] == "nao existe") {
                            print "<script >
                                    swal('Está Conta não existe!', 'Algo errado!', 'error');
                            </script>";
                        } else if ($_SESSION['Msglogin'] == "Conta bloqueada")
                            print "<script >
                                    swal('Está Conta foi Bloqueada!', 'Algo errado!', 'error');
                            </script>";
                        unset($_SESSION['Msglogin']);
                    }
                    ?>

                </div>
            </aside>
            <?php
        }
    }

}
