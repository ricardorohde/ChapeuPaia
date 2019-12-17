
<?php
require_once 'Conexao.php';

class cliente extends Conexao {

    function listarPedidos() {
        $query = "SELECT pd.*, pp.*, pr.*, (pr.pro_valor * pp.ppp_qtd) as valorItem FROM pedidos pd, pedidos_produtos pp, produtos pr WHERE pd.usu_codigo = " . $_SESSION['codigoUser'] . " AND pd.pp_codigo = pp.pp_codigo AND pp.pro_codigo = pr.pro_codigo AND pd.ped_confirmUsu != 1";
        $res = $this->getAll($query);
        $pedidos = "";
        if ($res) {

            foreach ($res as $resultado) {
                $proValor = ' R$ ' . number_format($resultado['valorItem'], 2, ',', '.');
                $pedidos = $pedidos . "<div class='col-12 border-bottom row m-0 p-2'><div class='col-8'><b>" . $resultado['ppp_qtd'] . "</b> " . $resultado['pro_nome'] . "</div><div class='col-4'>$proValor</div></div>";
            }
            $buscaCod = "SELECT * FROM pedidos WHERE usu_codigo =" . $_SESSION['codigoUser'] . " AND ped_confirmUsu = 0";
            if ($cod = $this->getOne($buscaCod)) {
                $total = $this->getTotal($cod['pp_codigo'], 1);
                $valorTotal = ' R$ ' . number_format($total, 2, ',', '.');
                $pedidos = $pedidos . "<div class='col-12 border-bottom row m-0 p-2'><div class='col-8'>Total</div><div class='col-4'> $valorTotal</div></div>";
            }

            $pedidos = $pedidos . "<div class='col-12 border-none row m-0 p-2'><p class='col-12 text-center p-0 m-0'><a href='produtos.php?cart' class='acessCart m-0 text text-center' >Ver Carrinho</a></p></div>";
        } else {
            $pedidos = "<div class='col-12 p-2 row row-center'><div class='col-12 bxpd'><img src='./includes/img/icons/pedido-vazio.png' class='pdVazio'/></div><p class='text col-12 mt-2 textPdVz'>Nenhum item no carrinho!</p></div>";
        }
        $pedidos = json_encode($pedidos);
        print_r($pedidos);
    }

    function existPedido($id) {
        $verifica = "SELECT * FROM pedidos WHERE ped_confirmUsu = 0 AND usu_codigo = " . $_SESSION['codigoUser'];
        if (!$this->getOne($verifica)) {
            date_default_timezone_set('America/Sao_Paulo');
            $data = date("Y/m/d H:i:s");
            $query = "INSERT INTO `pedidos` (`usu_codigo`, `ped_confirmacao`, `ped_confirmUsu`,`ped_confirmCozinha`, `ped_valor`, `ped_estado`, `ped_cidade`, `ped_bairro`, `ped_rua`, `ped_numeroCasa`, `ped_hora`,ped_pagamento) VALUES ('{$_SESSION['codigoUser']}', '0', '0','0','0', '{$_SESSION['estadoUser']}', '{$_SESSION['cidadeUser']}', '{$_SESSION['bairroUser']}', '{$_SESSION['ruaUser']}', '{$_SESSION['numeroCasaUser']}', '$data', '')";
            $this->execute($query);

            if ($ret = $this->getOne("SELECT * FROM pedidos WHERE ped_confirmUsu = 0 AND usu_codigo = " . $_SESSION['codigoUser'])) {
                $this->cadastraProduto($id, $ret['pp_codigo']);
            }
        } else {
            if ($ret = $this->getOne("SELECT * FROM pedidos WHERE ped_confirmUsu = 0 AND usu_codigo = " . $_SESSION['codigoUser'])) {
                $this->cadastraProduto($id, $ret['pp_codigo']);
            }
        }
    }

    function cadastraProduto($id, $ped) {
        if ($a = $this->getOne("SELECT * FROM pedidos_produtos WHERE pp_codigo = $ped AND pro_codigo = $id")) {
            $newQtd = $a['ppp_qtd'] + 1;
            $mudaQtd = "UPDATE pedidos_produtos SET ppp_qtd = " . $newQtd . " WHERE pp_codigo = $ped AND pro_codigo = $id";
            $this->execute($mudaQtd);
            $valor = $this->getTotal($ped, 1);
            if ($valor) {
                $update = "UPDATE pedidos SET ped_valor = " . $valor . " WHERE pp_codigo = $ped";
                $this->execute($update);
            }
        } else {

            $query = "INSERT INTO `pedidos_produtos`( `pp_codigo`, `pro_codigo`, `ppp_qtd`) VALUES ($ped,$id,1)";
            if ($this->execute($query)) {
                $valor = $this->getTotal($ped, 1);
                if ($valor) {
                    $update = "UPDATE pedidos SET ped_valor = " . $valor . " WHERE pp_codigo = $ped";
                    $this->execute($update);
                }
                echo "<script>itensCarrinho(0);</script>";
            }
        }
    }

    function getTotal($ped, $operacao) {
        $cont = "SELECT pp.*, (pro.pro_valor * pp.ppp_qtd) as total_item, SUM(pro.pro_valor * pp.ppp_qtd) AS total, SUM(pro.pro_pontos * pp.ppp_qtd) AS pontos FROM pedidos_produtos pp, produtos pro, pedidos ped WHERE pp.pro_codigo = pro.pro_codigo AND pp.pp_codigo = $ped AND pp.pp_codigo = ped.pp_codigo AND ped.ped_confirmUsu != 1";
        if ($a = $this->getOne($cont)) {
            if ($operacao == 1) {
                return $a['total'];
            } else {
                return $a['pontos'];
            }
        }
    }

    function getTotalPontosAdd($ped) {
        $cont = "SELECT SUM(pp.ppp_qtd * pro.pro_pontosUsu) AS pontos FROM pedidos_produtos pp, pedidos ped, produtos pro WHERE pro.pro_codigo = pp.pro_codigo AND pp.pp_codigo = ped.pp_codigo AND ped.pp_codigo = $ped";
        if ($a = $this->getOne($cont)) {
            return $a['pontos'];
        }
    }

    function getTotalItens() {

        if ($ped = $this->getPedido($_SESSION['codigoUser'])) {
            $qtd = "SELECT SUM(ppp_qtd) AS ItensQtd FROM pedidos_produtos WHERE pp_codigo = $ped";
            if ($a = $this->getOne($qtd)) {
                $t = $a['ItensQtd'];
                if ($t == 0 || $t == "") {
                    print_r("0");
                } else {
                    print_r($t);
                }
            } else {
                print_r("0");
            }
        } else {
            print_r("0");
        }
    }

    function getPedido($id) {
        $query = "SELECT * FROM pedidos WHERE usu_codigo = $id AND ped_confirmUsu = 0";
        $dados = $this->getOne($query);
        return $dados['pp_codigo'];
    }

    function updateLocation($bairro, $rua, $numero) {
        $query = "UPDATE pedidos SET ped_bairro = '$bairro', ped_rua = '$rua', ped_numeroCasa = $numero WHERE usu_codigo = " . $_SESSION['codigoUser'] . " AND ped_confirmUsu = 0";
        $this->execute($query);
    }

    function getLocation() {
        $query = "SELECT * FROM pedidos WHERE usu_codigo = " . $_SESSION['codigoUser'] . " AND ped_confirmUsu = 0";
        $ret = $this->getOne($query);
        return $ret;
    }

    public function getItensCartSelected() {
        $query = "SELECT pd.*, pp.*, pr.*, (pr.pro_valor * pp.ppp_qtd) as valorItem , (pr.pro_pontos * pp.ppp_qtd) as pontosPro FROM pedidos pd, pedidos_produtos pp, produtos pr WHERE pd.usu_codigo = " . $_SESSION['codigoUser'] . " AND pd.pp_codigo = pp.pp_codigo AND pp.pro_codigo = pr.pro_codigo AND pd.ped_confirmUsu != 1";
        $ret = $this->getAll($query);

        if ($ret) {
            ?>
            <div class = "col-1 d-none d-md-block"></div>
            <div class = "row col-12 m-0 col-md-10 pb-3 mt-sm-0 mt-md-4" id = "BxCartFinally">
                <div class = "col-12 row row-center mb-2 BxCarrinhoHeight pt-4">
                    <p class = "textCart">
                        Carrinho(<?php
                        $a = $this->getTotalItens();
                        echo $a;
                        ?>)
                    </p>
                    <span class = "borderCart">

                    </span>
                    <hr class = "col-12 col-md-11 m-0 mr-0 pt-0 mr-md-3" />
                </div>
                <?php
                $cont = 1;
                foreach ($ret as $item) {
                    $proValor = ' R$ ' . number_format($item['valorItem'], 2, ',', '.');
                    $pontos = $this->getTotal($item['pp_codigo'], 0);
                    $pontos2 = $item['pontosPro'];
                    $pontosAdd = $this->getTotalPontosAdd($item['pp_codigo']);
                    ?>


                    <div class = "col-12 row mt-5 mb-5">
                        <div class = "col-12 col-md-4 col-lg-3 p-0" style = "min-height: 130px;">
                            <div class = "BxImgFinally">

                                <?php
                                if ($item['pro_foto'] == "proDefaut.png") {
                                    echo "<img src = 'includes/img/produtos/proDefaut.png' class = 'imgPro2'/>";
                                } else {

                                    $pasta = md5($item['tip_codigo']);
                                    echo '<img src = "includes/img/produtos/' . $pasta . '/' . $item['pro_foto'] . '" class = "imgCartFinally"/>';
                                }
                                ?>

                            </div>


                        </div>
                        <div class = "col-12 col-lg-9 col-md-8 row row-center">
                            <?php
                            $qtd = strlen($item['pro_nome']);
                            if ($qtd > 30) {
                                $nome = substr($item['pro_nome'], 0, 30) . " ...";
                            } else {
                                $nome = $item['pro_nome'];
                            }
                            ?>

                            <p class = "col-12 col-md-7 col-lg-8 NameProFinally pb-3"><?php echo $nome; ?></p>

                            <div class = "col-12 com-md-5 col-lg-4">
                                <p class = "textValorFinally mt-lg-3 mt-4"><?php echo $proValor . "/" . $pontos2; ?></p>
                            </div>

                            <p class = "col-12 col-md-6 col-lg-6 mt-2">
                                <?php
                                if ($igr = $this->getAll("SELECT igr.igr_nome FROM receita rec, ingredientes igr WHERE rec.pro_codigo = " . $item['pro_codigo'] . " AND rec.igr_codigo = igr.igr_codigo")) {
                                    foreach ($igr as $item2) {
                                        echo " " . $item2['igr_nome'] . ",";
                                    }
                                } else {
                                    echo 'Nenhum Ingrediente!';
                                }
                                ?>
                            </p>
                            <div class = "col-md-2 col-lg-2 d-none d-md-block">

                            </div>

                            <div class = "col-12 col-md-4 col-lg-4 float-right AddSubBx p-0">
                                <button class = "btnMenos ml-3" onclick="Sub('qtd<?php echo $cont; ?>')">-</button>
                                <input type = "tel" name = "qtd" id="qtd<?php echo $cont; ?>" class = "inptAddSub" value = "<?php echo $item['ppp_qtd'] ?>" readonly = "" onkeypress = "validaNumber(event)"/>
                                <button class = "btnMais" onclick="Add('qtd<?php echo $cont; ?>')">+</button>
                                <input type="hidden" class="qtd<?php echo $cont; ?>" value="<?php echo $item['pro_codigo'] ?>" />
                            </div>
                            <div class = "col-12 mt-3 mb-3">
                                <a onclick="delProduto(<?php echo $item['pro_codigo']; ?>);"><p class = "textDelProFinally ml-0">Excluir</p></a>
                            </div>
                        </div>

                    </div>
                    <hr class = "col-11 m-0 mr-3 mb-0 pb-0" />


                    <?php
                    $cont+=1;
                }
                ?>
                <div class = "col-12 row row-center bxComplete">
                    <div class = "col-12 row row-center pt-3 pb-3">

                        <div class = "col-6 col-md-9 ">
                            <p class = "textQtdProFinally ">Produtos(<?php
                                $a = $this->getTotalItens();
                                echo $a;
                                ?>)
                            </p>
                        </div>
                        <div class = "col-6 col-md-3 ">
                            <p class = "textQtdProFinally fl-right">
                                <?php
                                $a = $this->getTotal($item['pp_codigo'], 1);
                                $valorTotal = ' R$ ' . number_format($a, 2, ',', '.');
                                echo $valorTotal;
                                ?></p>
                        </div>
                        <div class = "col-12 col-md-9 mt-3 mb-3 txtCidade">
                            <p class = "textLocationFinally  ml-0">
                                <a data-target = "#location" data-toggle = "modal">
                                    <?php
                                    $loca = $this->getLocation();
                                    if ($loca['ped_rua'] != "" && $loca['ped_bairro'] != "" && $loca['ped_numeroCasa'] != "" && $loca['ped_cidade'] != "") {
                                        echo $loca['ped_rua'] . ', ';
                                        echo $loca['ped_bairro'] . ', ';
                                        echo $loca['ped_numeroCasa'] . ', ';
                                        echo $loca['ped_cidade'];
                                    } else {
                                        echo $_SESSION['ruaUser'] . ', ';
                                        echo $_SESSION['bairroUser'] . ', ';
                                        echo $_SESSION['numeroCasaUser'] . ', ';
                                        echo $_SESSION['cidadeUser'];
                                    }
                                    ?>
                                    <span class="ni ni-bold-down pt-2"></span>
                                </a>
                            </p>
                        </div>

                        <hr class = "d-block d-md-none col-11 m-0"/>
                        <div class = "col-6 col-md-9 mt-2">
                            <p class = "textTotalProFinally">Pontos</p>
                        </div>



                        <div class = "col-6 col-md-3 mt-2">
                            <p class = "textValorFinally2 textLocationFinally">
                                <?php
                                echo $pontos;
                                ?></p>
                        </div>
                        <div class = "col-6 col-md-9 mt-4">
                            <p class = "textTotalProFinally">Total</p>
                        </div>



                        <div class = "col-6 col-md-3 mt-4">

                            <p class = "textValorFinally2 textLocationFinally">
                                <?php
                                echo $valorTotal;
                                ?>
                            </p>


                        </div>


                    </div>
                </div>
                <hr class = "col-11 m-0 mr-3 mb-0 pb-0" />
                <div class = "col-12 row row-center bxComplete pb-5 pt-5 p-0">
                    <div class = "bxBtnFinally ">
                        <button class = "BtnFinally" data-target="#paying" data-toggle="modal">Finalizar a compra</button>
                    </div>
                </div>
            </div>
            <div class = "col-1 d-none d-md-block"></div>
            <aside class="modal" id="location" tabindex="-1" role="dialog" >
                <div class="modal-dialog modal-lg mt-0 mb-0" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Local de Entrega</h5>

                        </div>
                        <form method="POST" id="FormLocation">
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-12 col-sm-12" id="BoxInfoPerfil">
                                        <div class="row container-fluid">

                                            <div id="localizacao" class="row col-12 mt-2 m-0 p-0">
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
                                                <?php
                                                if ($loca['ped_rua'] != "" && $loca['ped_bairro'] != "" && $loca['ped_numeroCasa'] != "" && $loca['ped_cidade'] != "") {
                                                    ?>
                                                    <div class="col-12 col-lg-12" >
                                                        <p class="mt-3 mt-lg-2 mb-1 ">Bairro</p>
                                                        <input type="text" placeholder="Ex: Estação" class="bairro" name="bairroCadastro" id="InputBairro" value="<?php echo $loca['ped_bairro']; ?>"/>
                                                    </div>
                                                    <div class="col-8 col-lg-8" >
                                                        <p class="mt-3 mt-lg-2 mb-1 ">Rua</p>
                                                        <input type="text" placeholder="Ex: Avenida João Paes" class="avenida" name="ruaAlterar" id="InputBairro" value="<?php echo $loca['ped_rua']; ?>"/>
                                                    </div>
                                                    <div class="col-4 col-lg-4 mr-0" >
                                                        <p class="mt-3 mt-lg-2 mb-1">Nº</p>
                                                        <input type="text" placeholder="Ex: 1920" name="numeroCasaAlterar" class="numeroCasa" maxlength="4" id="InputNumero" value="<?php echo $loca['ped_numeroCasa']; ?>"/>
                                                    </div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div class="col-12 col-lg-12" >
                                                        <p class="mt-3 mt-lg-2 mb-1 ">Bairro</p>
                                                        <input type="text" placeholder="Ex: Estação" class="bairro" name="bairroCadastro" id="InputBairro" value="<?php echo $_SESSION['bairroUser']; ?>"/>
                                                    </div>
                                                    <div class="col-8 col-lg-8" >
                                                        <p class="mt-3 mt-lg-2 mb-1 ">Rua</p>
                                                        <input type="text" placeholder="Ex: Avenida João Paes" class="avenida" name="ruaAlterar" id="InputBairro" value="<?php echo $_SESSION['ruaUser']; ?>"/>
                                                    </div>
                                                    <div class="col-4 col-lg-4 mr-0" >
                                                        <p class="mt-3 mt-lg-2 mb-1">Nº</p>
                                                        <input type="text" placeholder="Ex: 1920" name="numeroCasaAlterar" class="numeroCasa" maxlength="4" id="InputNumero" value="<?php echo $_SESSION['numeroCasaUser']; ?>"/>
                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                            </div>
                                            <div class="alertError col-12">
                                                <p class="text-center mt-2">Por favor preencha todos os campos!</p>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer bxSaveLocation">      
                                <input class="btn" id="SaveLocation" type="submit" name="Cadastrar" Value="Continuar" onclick="validaLocation();"/>
                            </div>
                        </form>
                    </div>

                </div>
            </aside>
            <div class="modal fade" id="paying" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">

                        <div class="modal-body p-0">


                            <div class="card bg-secondary shadow border-0">
                                <div class="card-header bg-transparent pb-3">
                                    <p class="textPontos">Seus Pontos : <font color="firebrick"><?php echo $_SESSION['pontosUser']; ?></font></p>
                                </div>
                                <div class="card-body px-lg-5 py-lg-5 pt-3">
                                    <div class="text-center text-muted mb-4">
                                        <small>Forma de Pagamento</small>
                                    </div>
                                    <form role="form" class="row m-0" method="POST">
                                        <div class="col-12">
                                            <div class="bxPontosMore2">
                                                <p>
                                                    <?php
                                                    echo 'ganhe +' . $pontosAdd . ' pontos se for no dinheiro ou cartão';
                                                    ?>
                                                </p> 
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="custom-control custom-radio mb-3">
                                                <input name="pagamento" class="custom-control-input" value="0" id="dinheiro" type="radio">
                                                <label class="custom-control-label" for="dinheiro">Dinheiro</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="custom-control custom-radio mb-3">
                                                <input name="pagamento" class="custom-control-input" value="1" id="cartao" type="radio">
                                                <label class="custom-control-label" for="cartao">Cartão</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="custom-control custom-radio mb-3">
                                                <input name="pagamento" class="custom-control-input" value="2" id="pontos" type="radio" 
                                                <?php
                                                if ($_SESSION['pontosUser'] < $pontos) {
                                                    echo ' disabled="" ';
                                                }
                                                ?>
                                                       />
                                                <label class="custom-control-label" for="pontos">Pontos</label>
                                            </div>
                                        </div>
                                        <div class="msgCartao col-12">
                                            <p>Para maior segurança o pagamento será feito pessoalmente, e não pelo site. Obrigado!</p>
                                        </div>
                                        
                                        <div class="text-center col-12">
                                            <button name="completarPedido" class="btn btn-primary btn-lg btn-block" type="submit">
                                                <span class="btn-inner--icon"><i class="ni ni-bag-17"></i></span>
                                                <span class="btn-inner--text">Confirmar</span>

                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class = "col-1 d-none d-md-block"></div>
            <div class = "row col-12 m-0 col-md-10 pb-3 mt-sm-0 mt-md-4" id = "BxCartFinally">
                <div class="img-fluid col-12 row-center row pt-5">
                    <div class="col-12 mt-5">
                        <div style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
                            <img src="./includes/img/icons/pedido-vazio.png" class="imgCarrinhoVazio m-0" />
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <p class="textCarrinhoVazio col-12 mt-2">Nenhum Item!</p>
                    </div>
                    <div class="col-12">
                        <div style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
                            <a href="produtos.php"><button class="btnMoreCompra">Voltar as Compras</button></a>
                        </div>

                    </div>
                </div>

            </div>

            <div class = "col-1 d-none d-md-block"></div>
            <?php
        }
    }

    function delProduto($id) {
        $busca = "SELECT * FROM pedidos WHERE usu_codigo = " . $_SESSION['codigoUser'] . " AND ped_confirmUsu = 0";
        if ($a = $this->getOne($busca)) {
            $query = "DELETE pp.* FROM pedidos_produtos pp, pedidos ped WHERE pp.pro_codigo = $id AND pp.pp_codigo = ped.pp_codigo  AND ped.usu_codigo = " . $_SESSION['codigoUser'] . " AND ped.ped_confirmUsu = 0 AND ped.pp_codigo = " . $a['pp_codigo'];
            $this->execute($query);

            $valor = $this->getTotal($a['pp_codigo'], 1);
            if ($valor) {
                $update = "UPDATE pedidos SET ped_valor = " . $valor . " WHERE pp_codigo =" . $a['pp_codigo'];
                $this->execute($update);
            }
        }
    }

    function updatePro($id, $qtd) {
        $busca = "SELECT * FROM pedidos WHERE usu_codigo = " . $_SESSION['codigoUser'] . " AND ped_confirmUsu = 0";
        if ($a = $this->getOne($busca)) {
            $query = "UPDATE pedidos_produtos SET ppp_qtd = $qtd WHERE pro_codigo = $id AND pp_codigo = " . $a['pp_codigo'];
            $this->execute($query);

            $valor = $this->getTotal($a['pp_codigo'], 1);
            if ($valor) {
                $update = "UPDATE pedidos SET ped_valor = " . $valor . " WHERE pp_codigo = " . $a['pp_codigo'];
                $this->execute($update);
            }
        }
    }

    function listaMensagens() {
        $query = "SELECT * FROM mensagens WHERE usu_codigo = " . $_SESSION['codigoUser'] . " AND men_visualizado = 0";
        $res = $this->getAll($query);
        $mensagens = "";
        if ($res) {
            $this->updateMensages();
            foreach ($res as $resultado) {
                $mensagens = $mensagens . "<div class='col-12 border-bottom row m-0 p-2'><div class='col-3'><img src='includes/img/icons/alert-message.png' /></div><div class='col-9'><p class='textMensage'>" . $resultado['men_texto'] . "</p></div></div>";
            }
        } else {
            $query = "SELECT * FROM mensagens WHERE usu_codigo = " . $_SESSION['codigoUser'] . " AND men_visualizado = 1";
            $res = $this->getAll($query);
            $mensagens = "<div class='col-12 p-2 row row-center  m-0'><p class='text col-12 mt-2 border-bottom mb-0 pb-2 textPdVz'>Nenhuma notificação nova!</p></div>";
            foreach ($res as $resultado) {
                $mensagens = $mensagens . "<div class='col-12 border-bottom row m-0 p-2'><div class='col-3'><img src='includes/img/icons/alert-message.png' /></div><div class='col-9'><p class='textMensage'>" . $resultado['men_texto'] . "</p></div></div>";
            }
        }

        $mensagens = json_encode($mensagens);
        print_r($mensagens);
    }

    function getTotalMensages() {
        $busca = "SELECT COUNT(men_codigo) AS qtd FROM mensagens WHERE usu_codigo = " . $_SESSION['codigoUser'] . " AND men_visualizado = 0";
        if ($a = $this->getOne($busca)) {
            $t = $a['qtd'];
            if ($t == 0 || $t == "") {
                print_r("0");
            } else {
                print_r($t);
            }
        } else {
            print_r("0");
        }
    }

    function updateMensages() {
        $verifica = "SELECT * FROM mensagens WHERE men_visualizado = 0 AND usu_codigo = " . $_SESSION['codigoUser'];
        if ($this->getAll($verifica)) {
            $query = "UPDATE mensagens SET men_visualizado = 1 WHERE usu_codigo = " . $_SESSION['codigoUser'];
            $this->execute($query);
        }
    }

    function finalizaPedido($pagamento) {
        $pedido = $this->getOne("SELECT * FROM pedidos WHERE ped_confirmUsu = 0 AND usu_codigo = " . $_SESSION['codigoUser']);
        if ($pedido) {
            date_default_timezone_set('America/Brazilian');
            $data = date("Y/m/d H:i:s");
            if ($pagamento == "Pontos") {
                $confirm = $this->getOne("SELECT usu_pontos FROM usuario WHERE usu_codigo = " . $_SESSION['codigoUser']);
                $pontos = $this->getTotal($pedido['pp_codigo'], 0);
                if ($confirm['usu_pontos'] >= $pontos) {

                    $query = "UPDATE pedidos SET ped_pagamento = '$pagamento', ped_hora = '$data', ped_confirmUsu = 1, ped_valor = $pontos WHERE pp_codigo = '" . $pedido['pp_codigo'] . "'";
                    if ($this->execute($query)) {
                        $newPontos = $confirm['usu_pontos'] - $pontos;
                        if ($newPontos <= $_SESSION['pontosUser']) {
                            $atualizaUsu = "UPDATE usuario SET usu_pontos = $newPontos WHERE usu_codigo = " . $_SESSION['codigoUser'];
                            if ($this->execute($atualizaUsu)) {
                                $_SESSION['pontosUser'] = $newPontos;
                                header("Location: produtos.php?cart");
                            }
                        } else {
                            header("Location: produtos.php?cart");
                        }
                    }
                }
            } else if ($pagamento == "Dinheiro" || $pagamento == "Cartão") {
                $dinheiro = $this->getTotal($pedido['pp_codigo'], 1);
                $pontosAdd = $this->getTotalPontosAdd($pedido['pp_codigo']);
                $confirm = $this->getOne("SELECT usu_pontos FROM usuario WHERE usu_codigo = " . $_SESSION['codigoUser']);
                if ($confirm) {
                    $newPontos = $confirm['usu_pontos'] + $pontosAdd;
                    $query = "UPDATE pedidos SET ped_pagamento = '$pagamento', ped_hora = '$data', ped_confirmUsu = 1, ped_valor = $dinheiro WHERE pp_codigo = '" . $pedido['pp_codigo'] . "'";
                    if ($this->execute($query)) {
                        $atualizaUsu = "UPDATE usuario SET usu_pontos = $newPontos WHERE usu_codigo = " . $_SESSION['codigoUser'];
                        if ($this->execute($atualizaUsu)) {
                            $_SESSION['pontosUser'] = $newPontos;
                            header("Location: produtos.php?cart");
                        }
                    }
                }
            }
        }
    }

}

if (isset($_GET['pedido'])) {
    $cliente = new cliente();
    session_start();
    if ($_GET['pedido'] == 0) {
        $cliente->listarPedidos();
    }
} else if (isset($_GET['proCompra'])) {
    session_start();
    $cliente = new cliente();
    if ($_GET['proCompra'] > 0) {
        $cliente->existPedido($_GET['proCompra']);
    }
} else if (isset($_GET['carrinho'])) {
    session_start();

    $cliente = new cliente();
    $cliente->getTotalItens();
} else if (isset($_GET['saveLocation'])) {
    session_start();
    if (isset($_GET['bairro']) && isset($_GET['rua']) && isset($_GET['numero'])) {
        $salva = new cliente();

        $salva->updateLocation($_GET['bairro'], $_GET['rua'], $_GET['numero']);
    }
} else if (isset($_GET['delProdutoSelected'])) {
    session_start();

    $cliente = new cliente();
    $cliente->delProduto($_GET['delProdutoSelected']);
} else if (isset($_GET['updatePro']) && isset($_GET['qtd'])) {
    session_start();
    $cliente = new cliente();
    $cliente->updatePro($_GET['updatePro'], $_GET['qtd']);
} else if (isset($_GET['mensagens'])) {
    session_start();
    $cliente = new cliente();
    if ($_GET['mensagens'] == 0) {
        $cliente->listaMensagens();
        $cliente->updateMensages();
    }
} else if (isset($_GET['totalMensages'])) {
    session_start();
    $cliente = new cliente();
    $cliente->getTotalMensages();
}
?>