<?php
require_once 'Conexao.php';

class edits extends Conexao {

    function editget($id) {

        $dados = $this->getOne("SELECT * FROM produtos WHERE pro_codigo = $id");
        $valor = number_format($dados['pro_valor'], 2, ',', '.');
        echo ' 
        <div class="modal-content">
                    <div class="modal-header mb-0">
                        <h5 class="modal-title">Editar Promoção</h5>
                    </div>
                    <form method="POST" enctype="multipart/form-data" >
                        <div class="modal-body" style="overflow-y: visible;">

                            <div class="row">
                                <div class="col-12 col-sm-12 mr-0 m-0 mt-0 mb-2">

                                </div>
                                <div class="col-12 col-sm-12" id="BoxInfoPerfil">
                                    <div class="container-fluid">

                                        <div class="row p-2">
                                            <div class="col-12" id="BoxImgProduto">
                                                <div class="col-12 mt-0 ml-2 mr-2" id="BoxUploadImgPromocao" title="Adicionar Imagem" >
                                                   <input name="imgPromocaoEdit" type="file" id="InputUploadImgPromoEdit" onchange="previewImagemPromocaoEdit();"/> 
                                                    <label for="InputUploadImgPromoEdit">
                                                        <img';
        if ($dados['pro_foto'] == "proDefaut.png") {
            echo '  src="../img/produtos/proDefaut.png" class="imgDefautPromocaoEdit"/>';
        } else {
            $pasta = md5($dados['tip_codigo']);
            echo '  src="../img/produtos/' . $pasta . '/' . $dados['pro_foto'] . '" class="imgDefautPromocaoEdit"/>';
        }
        echo ' 
                                                    </label>
                                                    <div>
                                                        <label for="InputUploadImgPro">
                                                            <img src="../img/icons/photo-camera.png" class="imgPhotoPromocao"/>
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-9 mt-3">
                                                <p class="mb-1">Nome da Promoção<font color="red">*</font></p>
                                                <input type="hidden" name="proCodigoEdit" value="' . $dados['pro_codigo'] . '"/>
                                                <input type="text" id="InputNameProduto" name="NomePromocaoEdit" placeholder="ex: X-Tudo" required="" value="' . $dados['pro_nome'] . '"/>
                                            </div>
                                            <div class="col-12 col-lg-3 mt-3">
                                                <p class="mb-1">Valor<font color="red">(R$)</font></p>
                                                <input type="text" id="InputValorProduto" name="ValorPromocaoEdit" placeholder="ex:18.9" onkeyup="Formata(this)" value="' . $valor . '" required/>
                                            </div>
                                            <div class="col-12 col-lg-6 mt-1">
                                                <p class="mb-1">Pontos<font color="red">*</font></p>
                                                <input type="text" id="InputPontosProduto" name="PontosPromocaoEdit" placeholder="ex:100" required="" onkeypress="validaNumber(event)" value="' . $dados['pro_pontos'] . '"/>
                                            </div>
                                            <div class="col-12 col-lg-6 mt-1">
                                                <p class="mb-1">Pontos Usuário<font color="red">*</font></p>
                                                <input type="text" id="InputPontosProduto" name="PontosPromocaoUsuEdit" placeholder="ex:10" required="" onkeypress="validaNumber(event)" value="' . $dados['pro_pontosUsu'] . '"/>
                                            </div>
                                            <div class="row col-12 mt-1 ml-1 mr-2"  id="BoxIng">                                                   
                                                
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">                            
                            <button class="btn btn-danger" data-dismiss="modal" id="Cancel">Cancelar</button>
                            <input class="btn btn-success" id="Edit" value="Salvar" type="submit" name="SavePromocao"/>

                        </div>
                    </form>
                </div>
                ';
    }

    function editPedido($id) {

        $dados = $this->getOne("SELECT usu_nome, ped.* FROM pedidos ped,usuario usu WHERE ped.pp_codigo = $id AND ped.usu_codigo = usu.usu_codigo");
        if ($dados) {

            echo ' 
                        <div class="modal-content">
                        <form method="POST">
                            <div class="modal-header">
                                <h3 class="modal-title" id="modal-title-default">' . $dados['usu_nome'] . '</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            
                            <div class="modal-body">
                                
                                <input type="hidden" name="codigoPedido" value="' . $dados['pp_codigo'] . '"/>
                                    <div class="row row-center m-0">
                                        <div class="col-12 row m-0">
                                            <p class="col-12">
                                                Bairro  
                                            </p>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="text" name="bairroPedido" class="form-control form-control-alternative inptEditPedido" id="bairroEditPedido" placeholder="Ex: Estação" value="' . $dados['ped_bairro'] . '" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0">
                                            <p class="col-12">
                                                Rua  
                                            </p>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="text" name="ruaPedido" class="form-control form-control-alternative inptEditPedido" id="ruaEditPedido" placeholder="Ex: Avenida Ribeiro Farias" value="' . $dados['ped_rua'] . '" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 row m-0">
                                            <p class="col-12">
                                                Número Casa  
                                            </p>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="text" name="nmCasaPedido" class="form-control form-control-alternative inptEditPedido" maxlength="4" id="numeroEditPedido" placeholder="Ex: 1999" value="' . $dados['ped_numeroCasa'] . '" onkeypress="validaNumber(event)" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn " style="background: firebrick;color:white;" name="saveLocationPedido">Salvar</button>

                            </div>
                                </form>
                        </div>
                ';
        }
    }

    function showItens($id) {
        if ($a = $this->getOne("SELECT usu_nome, ped.* FROM pedidos ped,usuario usu WHERE ped.pp_codigo = $id AND ped.usu_codigo = usu.usu_codigo")) {
            echo '<div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="modal-title-default">' . $a['usu_nome'] . '</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            
                            <div class="modal-body">
                                ';
            $busca = "SELECT pp.*, pro.*, tip.* FROM pedidos_produtos pp, produtos pro, tipo tip WHERE pp.pp_codigo = $id AND pp.pro_codigo = pro.pro_codigo AND pro.tip_codigo = tip.tip_codigo";
            if ($ret = $this->getAll($busca)) {

                foreach ($ret as $item) {
                    echo ' 
                    <div class="col-12 row m-0 mt-2 bxShowItens">
                        <div class="col-9">
                            <p>' . $item['ppp_qtd'] . ' ' . $item['tip_nome'] . ' de ' . $item['pro_nome'] . '</p>
                        </div>
                        <div class="col-3 p-0">
                            <button class="btnDelItenPedido" type="button" onclick="';


                    echo 'delItenFromPedido(' . $item['pro_codigo'] . ',' . $id . ');">';

                    echo '
                                X
                            </button>
                        </div>
                    </div>
                    ';
                }
            }
            echo '
                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-link  ml-auto btn-lg" data-dismiss="modal">Cancelar</button>
                                

                            </div>
                        </div>';
        }
    }

    function delItem($produto, $pedidoId) {
        $verifica = "SELECT * FROM pedidos WHERE pp_codigo = $pedidoId";
        if ($pedido = $this->getOne($verifica)) {
            if ($pedido['ped_pagamento'] == "Pontos") {
                $getDados = "SELECT usu.*,ped.*,pp.*, pro.*, SUM(pro.pro_pontos * pp.ppp_qtd) AS pontosProduto, SUM(pro.pro_pontosUsu * pp.ppp_qtd) AS pontosUsu FROM usuario usu, pedidos ped, pedidos_produtos pp, produtos pro WHERE pp.pp_codigo = $pedidoId AND pp.pro_codigo = $produto AND pp.pro_codigo = pro.pro_codigo AND pp.pp_codigo = ped.pp_codigo AND ped.usu_codigo = usu.usu_codigo";
                if ($dados = $this->getOne($getDados)) {

                    $pontosUsu = $dados['usu_pontos'];
                    $pontosUsu = $pontosUsu + $dados['pontosProduto'];

                    $pontos = "UPDATE usuario SET usu_pontos = $pontosUsu WHERE usu_codigo = " . $dados['usu_codigo'];
                    if ($this->execute($pontos)) {
                        $dados['ped_valor'] -= $dados['pontosProduto'];
                        $updateValor = "UPDATE pedidos SET ped_valor = " . $dados['ped_valor'];
                        if ($this->execute($updateValor)) {
                            $this->del($produto, $pedidoId);
                        }
                    }
                }
            } else if ($pedido['ped_pagamento'] == "Dinheiro") {
                $getDados = "SELECT usu.*,ped.*,pp.*, pro.*,SUM(pro.pro_valor * pp.ppp_qtd) AS dinheiro, SUM(pro.pro_pontosUsu * pp.ppp_qtd) AS pontosUsu  FROM pedidos_produtos pp, produtos pro, usuario usu, pedidos ped WHERE pp.pp_codigo = $pedidoId AND pp.pro_codigo = $produto AND pp.pro_codigo = pro.pro_codigo AND pp.pp_codigo = ped.pp_codigo AND ped.usu_codigo = usu.usu_codigo";
                if ($dados = $this->getOne($getDados)) {
                    $pedido['ped_valor'] -= $dados['dinheiro'];
                    $dados['usu_pontos'] -= $dados['pontosUsu'];
                    $dinheiro = "UPDATE pedidos SET ped_valor = " . $pedido['ped_valor'] . " WHERE pp_codigo = " . $dados['pp_codigo'];
                    if ($this->execute($dinheiro)) {
                        $attUsu = "UPDATE usuario SET usu_pontos = " . $dados['usu_pontos'] . " WHERE usu_codigo = " . $dados['usu_codigo'];
                        if ($this->execute($attUsu)) {
                            $this->del($produto, $pedidoId);
                        }
                    }
                }
            }
        }
    }

    function del($produto, $pedido) {
        if ($a = $this->getOne("SELECT COUNT(pp_codigo) AS qtd FROM pedidos_produtos WHERE pp_codigo = $pedido")) {
            if ($a['qtd'] == 1) {
                $query = "DELETE FROM pedidos_produtos WHERE pp_codigo = $pedido AND pro_codigo = $produto";
                if ($this->execute($query)) {
                    $delPedido = "DELETE FROM pedidos WHERE pp_codigo = $pedido";
                    if ($this->execute($delPedido)) {
                        echo "<script>window.location.href='admin.php?pedidos';</script>";
                    }
                } else {
                    echo "<script>window.alert('erro');</script>";
                }
            } else {
                $query = "DELETE FROM pedidos_produtos WHERE pp_codigo = $pedido AND pro_codigo = $produto";
                if ($this->execute($query)) {

                    echo "<script>window.location.href='admin.php?pedidos';</script>";
                } else {
                    echo "<script>window.alert('erro');</script>";
                }
            }
        }
    }

    function finalizaPedido($id) {
        $dados = "SELECT * FROM pedidos WHERE pp_codigo = $id";
        if ($ret = $this->getOne($dados)) {
            if ($a = $this->getAll("SELECT * FROM mensagens WHERE usu_codigo = " . $ret['usu_codigo'])) {
                $deletaMen = "DELETE FROM mensagens WHERE usu_codigo = " . $ret['usu_codigo'];
                if ($this->execute($deletaMen)) {
                    
                } else {
                    echo "<script>window.alert('Erro');</script>";
                }
            }
            $updateMen = "INSERT INTO `mensagens`(`men_texto`, `men_visualizado`, `usu_codigo`) VALUES ('Seu esta a caminho!Obrigado',0," . $ret['usu_codigo'] . ")";
            if ($this->execute($updateMen)) {
                $query = "UPDATE pedidos SET ped_confirmacao = 1, ped_confirmCozinha = 1 WHERE pp_codigo = $id";
                if ($this->execute($query)) {
                    echo "<script>window.location.href='admin.php?pedidos';</script>";
                } else {
                    echo "<script>window.alert('Erro ao confirmar o Pedido');</script>";
                }
            } else {
                echo "<script>window.alert('Erro ao enviar Mensagem');</script>";
            }
        } else {
            echo "<script>window.alert('Nenhum Pedido com esse ID');</script>";
        }
    }

    function modalEditTipo($id) {
        $query = "SELECT * FROM tipo WHERE tip_codigo = $id";
        if ($a = $this->getOne($query)) {
            ?>
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Editar Tipo</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body row m-0">

                <div class="col-md-12">
                    <div class="form-group">
                        <input type="hidden" name="idUpdate" value="<?php echo $a['tip_codigo'];?>"/>
                        <input type="text" class="form-control form-control-alternative" id="updtTipo" placeholder="Ex: Bebida" name="updtNameTipo" value="<?php echo $a['tip_nome'];?>">
                    </div>
                </div>


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Cancelar</button> 
                <button type="submit" class="btn btn-primary" name="saveTipo">Salvar</button>

            </div>
            <?php
        }
    }

}

if (isset($_GET['idPromocao'])) {
    $id = $_GET['idPromocao'];
    $promocao = new edits();
    $promocao->editget($id);
} else if (isset($_GET['editPedido'])) {
    $id = $_GET['editPedido'];
    $pedido = new edits();
    $pedido->editPedido($id);
} else if (isset($_GET['showItens'])) {
    $id = $_GET['showItens'];
    $pedido = new edits();
    $pedido->showItens($id);
} else if (isset($_GET['excluirItem']) && isset($_GET['pedido'])) {
    $pedido = new edits();
    $pedido->delItem($_GET['excluirItem'], $_GET['pedido']);
} else if (isset($_GET['finalizaId'])) {
    $pedido = new edits();
    $pedido->finalizaPedido($_GET['finalizaId']);
} else if (isset($_GET['editTipo'])) {
    $pedido = new edits();
    $pedido->modalEditTipo($_GET['editTipo']);
}