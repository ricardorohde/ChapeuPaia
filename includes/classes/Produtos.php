<?php

class Produtos extends Conexao {

    function GetPromocao() {
        $codigoTipo = $this->getTip('Promoções');
        if ($codigoTipo) {
            $query = "SELECT * FROM produtos WHERE tip_codigo = $codigoTipo";
            if ($ret = $this->getAll($query)) {
				
                foreach ($ret as $item) {
                    echo '<div class="item">
                            <div class="pad15 row">
                                <div class="ImgProView col-12">
                                <img';
                    if ($item['pro_foto'] == 'proDefaut.png') {
                        echo ' src="includes/img/produtos/proDefaut.png"';
                    } else {
                        $pasta = md5($item['tip_codigo']);
                        echo ' src="includes/img/produtos/' . $pasta . '/' . $item['pro_foto'] . '"';
                    }
                    echo ' />';
                    $proValor = ' R$ ' . number_format($item['pro_valor'], 2, ',', '.');
                    echo '</div>
                                <div class="InforProView col-12 p-0">
                                    <div class="row row-center m-0">
                                        <p class="TittlePro col-12">' . $item['pro_nome'] . '</p>
                                        <p class="col-12 ProValor">' . $proValor . '</p>
                                        <button type="button" class="BtnCompra" ';
                    if (isset($_SESSION['codigoUser'])) {
                        echo 'onclick="cadastraProduto(' . $item['pro_codigo'] . ')"';
                    } else {
                        echo ' data-toggle="modal" data-target="#cadastrar"';
                    } echo '>Adicionar ao Carrinho</button>'
                    ;
                    $busca = "SELECT igr.igr_nome FROM receita rec, ingredientes igr WHERE rec.pro_codigo = " . $item['pro_codigo'] . " AND rec.igr_codigo = igr.igr_codigo";
                    $busca = $this->getAll($busca);
                    if ($busca) {
                        echo '<p class = "col-12 IngreText">';
                        foreach ($busca as $igr) {
                            echo $igr['igr_nome'] . ', ';
                        }
                        echo '</p>';
                    }
                    echo'
                
                </div>
                </div>
                </div>
                </div>
				';
                }
            }
        }
    }

    public function getTip($tipo) {
        $query = "SELECT * FROM tipo WHERE tip_nome = '$tipo' AND tip_ativo = 1";
        $tipo = $this->getOne($query);
        return $tipo['tip_codigo'];
    }

    public function carrinhoSuspenso() {
        
    }

    public function getAllProdutos() {
        $query = "SELECT * FROM tipo WHERE tip_ativo = 1 ORDER BY tip_codigo DESC ";
        if ($tips = $this->getAll($query)) {

            foreach ($tips as $tipo) {
                if ($pro = $this->getAll("SELECT pro.*, tip.* FROM produtos pro, tipo tip WHERE pro.tip_codigo = " . $tipo['tip_codigo'] . " AND pro.tip_codigo = tip.tip_codigo")) {
                    echo '<div class="row row-center p-0 m-0 col-12" id="BxProdutoPg">
                        <p class="col-12 textProGet mt-sm-4">' . $tipo['tip_nome'] . '</p>
                        <div class="carousel col-12">';

                    foreach ($pro as $item) {
                        echo ' 
                            <div class="BxCardPro">
                                <div class="inBxCardPro row row-center">
                                    <div class="col-12 bxImgVenda" >
                                        <div class="bxPontosMore"><p>+' . $item['pro_pontosUsu'] . '</p></div>
                                        <img src="includes/img/produtos/';
                        if ($item['pro_foto'] == "proDefaut.png") {
                            echo $item['pro_foto'] . '" class="imgPro';
                        } else {
                            $pasta = md5($item['tip_codigo']);
                            echo $pasta . '/' . $item['pro_foto'];
                        }
                        echo '" ';
                        $formataImg = $item['pro_nome'];
                        if ($formataImg == "Promoções") {
                            echo ' class="promocaoShow"';
                        }
                        echo '						
						/>
                                    </div>
                                    <div class="col-12 row row-center m-0">
                                     ';
                        $valor = ' R$ ' . number_format($item['pro_valor'], 2, ',', '.');
                        echo ' <p class="text col-12 textValorPro mb-0 pb-0">' . $valor  . '</p>
                            <p class="text col-12 mt-0 textIngrediente textValorPontos mt-0 mb-0 p-0 ml-3">'.$item['pro_pontos'].'</p>
                                        <hr class="col-11 row-center mr-0 ml-0 pl-0"/>
                                        <div class="BxBtnCompra">
                                            <button ';
                        if (isset($_SESSION['codigoUser'])) {
                            echo ' onclick="cadastraProduto(' . $item['pro_codigo'] . ')"';
                        } echo '>
                                                <img src="./includes/img/icons/add-shopping.png" />
                                            </button>
                                        </div>
                                        <p class="text col-12 namePro mt-3">' . $item['pro_nome'] . '</p>
                                            
                                        <p class="textIngrediente col-12">';
                        if ($igr = $this->getAll("SELECT igr.igr_nome FROM receita rec, ingredientes igr WHERE rec.pro_codigo = " . $item['pro_codigo'] . " AND rec.igr_codigo = igr.igr_codigo")) {
                            foreach ($igr as $item2) {
                                echo " " . $item2['igr_nome'] . ",";
                            }
                        } else {
                            echo 'Nenhum Ingrediente!';
                        }
                        echo '</p>';

                        echo '   
                                            
                                    </div>
                                </div>
                            </div>';
                    }
                }
                echo '</div>
                    </div>';
            }
        }
    }

    public function getAllTipToFilter() {
        $query = "SELECT * FROM tipo WHERE tip_ativo = 1";
        $ret = $this->getAll($query);
        if ($ret) {
            foreach ($ret as $tipos) {
                echo '<a href="produtos.php?filter=' . $tipos['tip_codigo'] . '" class="ml-2 col-12 linkF">' . $tipos['tip_nome'] . '</a>';
            }
        }
    }

    public function filterProduto($busca) {
        $query = "SELECT * FROM produtos WHERE pro_nome like '%$busca%' ORDER BY pro_nome DESC";
        ?>

        <p class="col-12 mt-0 mb-2 textResult">Produto "<?php echo $busca; ?>"</p>
        <?php
        if ($ret = $this->getAll($query)) {
            ?>

            <?php
            foreach ($ret as $item) {
                ?>

                <div class="col-12 col-sm-11 col-md-10 col-lg-9 row row-center BxFiltered">

                    <div class="col-12 row row-center BxFilterLanche">
                        <div class="bxPontosMoreFilter"><p>+<?php echo $item['pro_pontosUsu']; ?></p></div>
                        <div class="col-5 col-sm-4 ">
                            <?php
                            if ($item['pro_foto'] == "proDefaut.png") {
                                echo '<img src = "includes/img/produtos/' . $item['pro_foto'] . '" class = "float-right" style="width: 100px; height:100px;position:absolute; top:50%;left:60%;transform:translate(-50%, -50%);"/>';
                            } else {
                                $pasta = md5($item['tip_codigo']);
                                echo '<img src = "includes/img/produtos/' . $pasta . '/' . $item['pro_foto'] . '" class = "float-right"/>';
                            }
                            ?>
                        </div>
                        <div class="col-7 col-sm-8 row row-center m-0 p-0">
                            <div class="col-12">
                                <p class="textNameFiltered"><?php echo $item['pro_nome'] ?></p>
                            </div>
                            <div class="col-12">
                                <?php $valor = ' R$ ' . number_format($item['pro_valor'], 2, ',', '.'); ?>
                                <p class="textValueFiltered"><?php echo $valor; ?></p>
                                 <p class="text col-12 mt-0 textIngrediente textValorPontos mt-0 mb-0 p-0 ml-3"><?php echo $item['pro_pontos'];?></p>
                            </div>
                            <div class="col-12">
                                <p class="allIgr ">
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
                            </div>
                            <div class="imgAddPro">

                                <?php
                                echo '<button ';
                                if (isset($_SESSION['codigoUser'])) {
                                    echo 'onclick="cadastraProduto( ' . $item['pro_codigo'] . ')"';
                                }
                                echo '>';
                                ?>

                                <img src="includes/img/icons/add-shopping.png" class="imgAddToCard"/>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="textNoExist col-12"><img src="./includes/img/icons/pedido-vazio.png"</div>
            <p class="textNoExist col-12">Nenhum produto com esse nome!</p>

            <?php
        }
    }

    public function getAllProdutosFiltered($tipo) {
        if ($tipo > 0) {
            $query = "SELECT * FROM tipo WHERE tip_codigo = $tipo AND tip_ativo = 1 ORDER BY tip_codigo DESC";
            if ($tips = $this->getAll($query)) {

                foreach ($tips as $tipo) {
                    if ($pro = $this->getAll("SELECT * FROM produtos WHERE tip_codigo = " . $tipo['tip_codigo'])) {
                        echo '<div class="row row-center p-0 m-0 col-12" id="BxProdutoPg">
                        <p class="col-12 textProGet mt-sm-4">' . $tipo['tip_nome'] . '</p>
                        <div class="carousel col-12">';

                        foreach ($pro as $item) {
                            echo ' 
                            <div class="BxCardPro">
                                <div class="inBxCardPro row row-center m-0">
                                    <div class="col-12 bxImgVenda" >
                                    <div class="bxPontosMore"><p>+';

                            echo $item['pro_pontosUsu'];
                            echo '</p></div>
                                        <img src="includes/img/produtos/';
                            if ($item['pro_foto'] == "proDefaut.png") {
                                echo $item['pro_foto'] . '" class="imgPro';
                            } else {
                                $pasta = md5($item['tip_codigo']);
                                echo $pasta . '/' . $item['pro_foto'];
                            }

                            echo '"';
                            $formataImg = $item['pro_nome'];
                            if ($formataImg == "Promoções") {
                                echo ' class="promocaoShow"';
                            }
                            echo '/>
                                    </div>
                                    <div class="col-12 row row-center m-0">
                                     ';
                            $valor = ' R$ ' . number_format($item['pro_valor'], 2, ',', '.');
                            echo ' <p class="text col-12 textValorPro">' . $valor . '</p>
                                
                                        <hr class="col-11 row-center mr-0 ml-0 pl-0"/>
                                        <div class="BxBtnCompra">
                                            <button ';
                            if (isset($_SESSION['codigoUser'])) {
                                echo ' onclick="cadastraProduto(' . $item['pro_codigo'] . ')"';
                            } echo '>
                                                <img src="./includes/img/icons/add-shopping.png" />
                                            </button>
                                        </div>
                                        <p class="text col-12 namePro">' . $item['pro_nome'] . '</p>
                                            
                                        <p class="textIngrediente col-12">';
                            if ($igr = $this->getAll("SELECT igr.igr_nome FROM receita rec, ingredientes igr WHERE rec.pro_codigo = " . $item['pro_codigo'] . " AND rec.igr_codigo = igr.igr_codigo")) {
                                foreach ($igr as $item2) {
                                    echo " " . $item2['igr_nome'] . ",";
                                }
                            } else {
                                echo 'Nenhum Ingrediente!';
                            }
                            echo '</p>';

                            echo '   
                                            
                                    </div>
                                </div>
                            </div>';
                        }
                    }
                    echo '</div>
                    </div>';
                }
            } else {
                ?>
                <div class="textNoExist col-12"><img src="./includes/img/icons/pedido-vazio.png"</div>
                <p class="textNoExist col-12">Nenhum produto com essa categoria!</p>

                <?php
            }
        }
    }

    public function FilteredByPrice($query) {

        if ($ret = $this->getAll($query)) {
            $stop = 0;
            $cont = 0;
            echo "<p class='col-12 textProGet mt-sm-4'>Buscados os primeiros 16</p>";
            foreach ($ret as $item) {
                if ($stop <= 15) {
                    if ($cont == 0 || $cont == 4) {
                        echo ' <div class="carousel col-12">';
                    }
                    echo ' 
                            <div class="BxCardPro">
                                <div class="inBxCardPro row row-center">
                                    <div class="col-12 bxImgVenda" >
                                    <div class="bxPontosMore"><p>+';

                    echo $item['pro_pontosUsu'];
                    echo '</p></div>
                                        <img src="includes/img/produtos/';
                    if ($item['pro_foto'] == "proDefaut.png") {
                        echo $item['pro_foto'] . '" class="imgPro';
                    } else {
                        $pasta = md5($item['tip_codigo']);
                        echo $pasta . '/' . $item['pro_foto'];
                    }
                    echo '" />
                                    </div>
                                    <div class="col-12 row row-center">
                                     ';
                    $valor = ' R$ ' . number_format($item['pro_valor'], 2, ',', '.');
                    echo ' <p class="text col-12 textValorPro mb-0">' . $valor . '</p>
                        <p class="text col-12 mt-0 textIngrediente textValorPontos mt-0 mb-0 p-0 ml-3">'.$item['pro_pontos'].'</p>
                                        <hr class="col-11 row-center mr-0 ml-0 pl-0"/>
                                        <div class="BxBtnCompra">
                                            <button ';
                    if (isset($_SESSION['codigoUser'])) {
                        echo ' onclick="cadastraProduto(' . $item['pro_codigo'] . ')"';
                    } echo '>
                                                <img src="./includes/img/icons/add-shopping.png" />
                                            </button>
                                        </div>';



                    echo ' 
                                        
                                        <p class="text col-12 namePro">' . $item['pro_nome'] . '</p>
                                        ';

                    echo ' 
                                        <p class="textIngrediente col-12">';
                    if ($igr = $this->getAll("SELECT igr.igr_nome FROM receita rec, ingredientes igr WHERE rec.pro_codigo = " . $item['pro_codigo'] . " AND rec.igr_codigo = igr.igr_codigo")) {
                        foreach ($igr as $item2) {
                            echo " " . $item2['igr_nome'] . ",";
                        }
                    } else {
                        echo 'Nenhum Ingrediente!';
                    }
                    echo '</p>';

                    echo '   
                                            
                                    </div>
                                </div>
                            </div>';

                    $cont += 1;
                    if ($cont == 0 || $cont == 4) {
                        echo ' </div>';
                        if ($cont == 4) {
                            $cont = 0;
                        }
                    }
                }
                $stop += 1;
            }
        }
    }

    public function FilteredByMoreBought($query) {

        if ($ret = $this->getAll($query)) {

            $cont = 0;
            echo "<p class='col-12 textProGet mt-sm-4'>Buscados itens mais comprados!</p>";
            foreach ($ret as $item) {
                if ($cont == 0 || $cont == 4) {
                    echo ' <div class="carousel col-12">';
                }
                echo ' 
                            <div class="BxCardPro">
                                <div class="inBxCardPro row row-center">
                                    <div class="col-12 bxImgVenda" >
                                    <div class="bxPontosMore"><p>+';
                echo $item['pro_pontosUsu'];
                echo '</p></div>
                                        <img src="includes/img/produtos/';
                if ($item['pro_foto'] == "proDefaut.png") {
                    echo $item['pro_foto'] . '" class="imgPro';
                } else {
                    $pasta = md5($item['tip_codigo']);
                    echo $pasta . '/' . $item['pro_foto'];
                }
                echo '" />
                                    </div>
                                    <div class="col-12 row row-center">
                                     ';
                $valor = ' R$ ' . number_format($item['pro_valor'], 2, ',', '.');
                echo ' <p class="text col-12 textValorPro">' . $valor . '</p>
                    <p class="text col-12 mt-0 textIngrediente textValorPontos mt-0 mb-0 p-0 ml-3">'.$item['pro_pontos'].'</p>
                                        <hr class="col-11 row-center mr-0 ml-0 pl-0"/>
                                        <div class="BxBtnCompra">
                                            <button ';
                if (isset($_SESSION['codigoUser'])) {
                    echo ' onclick="cadastraProduto(' . $item['pro_codigo'] . ')"';
                } echo '>
                                                <img src="./includes/img/icons/add-shopping.png" />
                                            </button>
                                        </div>';

                echo '<p class="col-12 text maisComprados">' . $item['quantidade'] . ' vendidos</p>';

                echo ' 
                                        
                                        <p class="text col-12 namePro">' . $item['pro_nome'] . '</p>
                                        ';

                echo ' 
                                        <p class="textIngrediente col-12">';
                if ($igr = $this->getAll("SELECT igr.igr_nome FROM receita rec, ingredientes igr WHERE rec.pro_codigo = " . $item['pro_codigo'] . " AND rec.igr_codigo = igr.igr_codigo")) {
                    foreach ($igr as $item2) {
                        echo " " . $item2['igr_nome'] . ",";
                    }
                } else {
                    echo 'Nenhum Ingrediente!';
                }
                echo '</p>';

                echo '   
                                            
                                    </div>
                                </div>
                            </div>';

                $cont += 1;
                if ($cont == 0 || $cont == 4) {
                    echo ' </div>';
                    if ($cont == 4) {
                        $cont = 0;
                    }
                }
            }
        }
    }

}
