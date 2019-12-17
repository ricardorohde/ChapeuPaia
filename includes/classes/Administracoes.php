
<?php

class AdministrarUsuarios extends Conexao {

    public function BuscaTodosUsuarios() {
        $queryUsuarios = "SELECT * FROM usuario WHERE usu_nivel != 3 ORDER BY  usu_status != 1";
        $usuarios = $this->getAll($queryUsuarios);
        if ($usuarios) {
            echo '<table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Pontos</th>
                                <th>Nivel</th>
                                <th>Bloquear</th>
                                <th>Editar</th>
                                <th>Excluir</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach ($usuarios as $campos) {
                $pasta = md5($campos['usu_codigo']);
                echo ' 
                            <tr>
                                <td><div class="perfilViewAdmin"><img src="../img/perfils/';
                if ($campos['usu_foto'] == "userDefaut.png") {
                    echo "userDefaut.png";
                } else {
                    echo $pasta . "/" . $campos['usu_foto'];
                }
                echo '" class="imgViewAdmin img-fluid"/><div class="BallStatus" style=';
                if ($campos['usu_status'] == 1) {
                    echo '"background:lightgreen;">';
                } else {
                    echo '"background:lightgray;">';
                }
                echo ' 
                                        </div></div></td>
                                <td>' . $campos['usu_nome'] . '</td>
                                <td>' . $campos['usu_email'] . '</td>
                                <td>' . $campos['usu_telefone'] . '</td>
                                <td>' . $campos['usu_pontos'] . '</td>
                                <td>' . $campos['usu_nivel'] . '</td>
                                <td>';
                if ($campos['usu_block'] == 0) {
                    echo '<a href="#" onclick="confirmacaoBlock(' . $campos['usu_codigo'] . ')">';
                    echo '<img src="../img/icons/liberar.png" class="icons" alt="Bloquear"/>';
                } else {
                    echo '<a href="#" onclick="confirmacaoUnlock(' . $campos['usu_codigo'] . ')">';
                    echo '<img src="../img/icons/bloquear.png" class="icons" alt="Liberar"/></a></td>';
                }

                echo '<td>
                                        <button data-target="#modalEditUser" data-toggle="modal" style="background:none;border:none;outline:none;" data-whatever = "' . $campos['usu_codigo'] . '" data-whatevernome="' . $campos['usu_nome'] . '" data-whateverfoto="' . $pasta . "/" . $campos['usu_foto'] . '" data-whateveremail = "' . $campos['usu_email'] . '" data-whatevertelefone = "' . $campos['usu_telefone'] . '" data-whateverpontos = "' . $campos['usu_pontos'] . '" data-whatevernivel = "' . $campos['usu_nivel'] . '" data-whateverbairro = "' . $campos['usu_bairro'] . '" data-whateverrua = "' . $campos['usu_rua'] . '" data-whatevercasa = "' . $campos['usu_numeroCasa'] . '">
                                            <img src="../img/icons/edit.png" class="icons"/>
                                        </button>
                                        </td>
                                <td><a href="#" onclick="confirmacaoCadastro(' . $campos['usu_codigo'] . ')"><img src="../img/icons/delete.png" class="icons" alt="Excluir"/></a></td>
                            </tr>
                          ';
            }

            echo ' </tbody>
                     </table>';
        } else if (!$usuarios) {
            echo "<p style='color:red;font-size:20px;position:absolute;tranform:translate(-50%,-50%); left:35%; top:20%;' class='text pt-5 text-center'>Nenhum usuário cadastrado!</p>";
        }
    }

    public function BuscaUmUsuario($nome) {
        $queryUsuarios = "SELECT * FROM usuario WHERE usu_nome like '%" . $nome . "%' ORDER BY usu_nome";
        $usuarios = $this->getAll($queryUsuarios);
        if ($usuarios) {
            echo '<table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Pontos</th>
                                <th>Nivel</th>
                                <th>Bloquear</th>
                                <th>Editar</th>
                                <th>Excluir</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach ($usuarios as $campos) {
                $pasta = md5($campos['usu_codigo']);
                echo ' 
                            <tr>
                                <td><div class="perfilViewAdmin"><img src="../img/perfils/';
                if ($campos['usu_foto'] == "userDefaut.png") {
                    echo "userDefaut.png";
                } else {
                    echo $pasta . "/" . $campos['usu_foto'];
                }
                echo '" class="imgViewAdmin img-fluid"/><div class="BallStatus" style=';
                if ($campos['usu_status'] == 1) {
                    echo '"background:lightgreen;">';
                } else {
                    echo '"background:lightgray;">';
                }
                echo '</div></div></td>
                                <td>' . $campos['usu_nome'] . '</td>
                                <td>' . $campos['usu_email'] . '</td>
                                <td>' . $campos['usu_telefone'] . '</td>
                                <td>' . $campos['usu_pontos'] . '</td>
                                <td>' . $campos['usu_nivel'] . '</td>
                                <td>';
                if ($campos['usu_block'] == 0) {
                    echo '<a href="#" onclick="confirmacaoBlock(' . $campos['usu_codigo'] . ')">';
                    echo '<img src="../img/icons/liberar.png" class="icons" alt="Bloquear"/>';
                } else {
                    echo '<a href="#" onclick="confirmacaoUnlock(' . $campos['usu_codigo'] . ')">';
                    echo '<img src="../img/icons/bloquear.png" class="icons" alt="Liberar"/></a></td>';
                }

                echo '<td>
                                        <button data-target="#modalEditUser" data-toggle="modal" style="background:none;border:none;" data-whatever = "' . $campos['usu_codigo'] . '" data-whatevernome="' . $campos['usu_nome'] . '" data-whateverfoto="' . $pasta . "/" . $campos['usu_foto'] . '" data-whateveremail = "' . $campos['usu_email'] . '" data-whatevertelefone = "' . $campos['usu_telefone'] . '" data-whateverpontos = "' . $campos['usu_pontos'] . '" data-whatevernivel = "' . $campos['usu_nivel'] . '" data-whateverbairro = "' . $campos['usu_bairro'] . '" data-whateverrua = "' . $campos['usu_rua'] . '" data-whatevercasa = "' . $campos['usu_numeroCasa'] . '">
                                            <img src="../img/icons/edit.png" class="icons"/>
                                        </button>
                                        </td>
                                <td><a href="#" onclick="confirmacaoCadastro(' . $campos['usu_codigo'] . ')"><img src="../img/icons/delete.png" class="icons" alt="Excluir"/></a></td>
                            </tr>
                          ';
            }

            echo ' </tbody>
                     </table>';
        } else if (!$usuarios) {
            echo "<p style='color:red;font-size:15px;position:absolute;tranform:translate(-50%,-50%); left:35%; top:25%;' class='text pt-5 text-center'>Nenhum usuário Encontrado com o nome $nome!</p>";
        }
    }

    public function ExcluirUsuario($id) {
        if ($id == $_SESSION['codigoUser']) {
            header("Location: administrarUsuarios.php");
        } else {
            $query = "DELETE FROM `usuario` WHERE usu_codigo = {$id}";
            $this->execute($query);
            $pasta = '../img/perfils/' . md5($id);
            chmod("$pasta", 0777);
            $img = opendir($pasta);
            while ($nome_itens = readdir($img)) {
                $itens[] = $nome_itens;
            }
            foreach ($itens as $key => $arquivo) {
                if ($arquivo != '.' && $arquivo != '..') {
                    unlink($pasta . '/' . $arquivo);
                }
            }
            closedir($pasta);
            rmdir($pasta);
            header("Location: admin.php?usuarios");
        }
    }

    public function BloquearUsuario($id) {
        $query = "UPDATE usuario SET usu_block = 1 WHERE usu_codigo = {$id}";
        $this->execute($query);
        header("Location: admin.php?usuarios");
    }

    public function DesbloquearUsuario($id) {
        $query = "UPDATE usuario SET usu_block = 0 WHERE usu_codigo = {$id}";
        $this->execute($query);
        header("Location: admin.php?usuarios");
    }

}

class AlterarUsuario extends Conexao {

    private $codigo;
    private $nome;
    private $email;
    private $pontos;
    private $telefone;
    private $nivel;
    private $estado;
    private $bairro;
    private $rua;
    private $numeroCasa;

    public function __construct($codigo, $nome, $email, $pontos, $telefone, $nivel, $novoEstado, $novaCidade, $novoBairro, $ruaCasa, $numeroNovoCasa) {
        parent::__construct();
        $this->codigo = $codigo;
        $this->nome = $nome;
        $this->email = $email;
        $this->pontos = $pontos;
        $this->telefone = $telefone;
        $this->nivel = $nivel;
        $this->estado = $novoEstado;
        $this->cidade = $novaCidade;
        $this->bairro = $novoBairro;
        $this->rua = $ruaCasa;
        $this->numeroCasa = $numeroNovoCasa;
        $this->Altera();
    }

    private function Altera() {
        $busca = "SELECT * FROM usuario WHERE usu_email = '{$this->email}' AND usu_codigo != '{$this->codigo}'";
        if ($this->getOne($busca)) {
            $_SESSION['usuExis'] = 'true';
        } else {
            $query = "UPDATE `usuario` SET `usu_nome`='{$this->nome}',`usu_email`='{$this->email}', `usu_telefone`='{$this->telefone}',`usu_pontos`='{$this->pontos}',usu_estado = '{$this->estado}', usu_cidade = '{$this->cidade}', usu_bairro = '{$this->bairro}', usu_rua = '{$this->rua}', usu_numeroCasa = '{$this->numeroCasa}', `usu_nivel`='{$this->nivel}' WHERE usu_codigo = $this->codigo";
            $this->execute($query);
            header("Location: admin.php?usuarios");
        }
    }

}

class Pedidos extends Conexao {

    public function __construct() {
        parent::__construct();
    }

    public function BucaPedidos() {
        $query = "SELECT usu.*, ped.* FROM pedidos ped, usuario usu WHERE ped.ped_confirmUsu = 1 AND ped_confirmacao = 0 AND ped_confirmCozinha = 0 AND ped.usu_codigo = usu.usu_codigo ORDER BY ped.ped_hora";
        $resultado = $this->getAll($query);
        if ($resultado) {
            foreach ($resultado as $item) {
                echo ' 
            <tr>
                <th scope="row">
                    <div class="media align-items-center">
                        <a href="#" class="rounded-circle">
                            <img alt="Image placeholder" class="imgPerfil" src="../img/perfils/';
                if ($item['usu_foto'] == "userDefaut.png") {
                    echo 'userDefaut.png';
                } else {
                    $pasta = md5($item['usu_codigo']);
                    echo $pasta . '/' . $item['usu_foto'];
                }
                echo
                '">
                        </a>
                        <div class="media-body">
                            <span class="mb-0 text-sm ml-2">' . $item['usu_nome'] . '</span>
                        </div>
                    </div>
                </th>
                <td>
                  ' . $item['ped_bairro'] . ',  ' . $item['ped_rua'] . ', ' . $item['ped_numeroCasa'] . '
                </td>
                <td>
                    <span class="badge badge-dot mr-4">
                        <i class="';
                if ($item['ped_confirmUsu'] == 1 && $item['ped_confirmacao'] == 0 && $item['ped_confirmCozinha'] == 0) {
                    echo 'bg-danger"></i> Pendente';
                } else if ($item['ped_confirmUsu'] == 1 && $item['ped_confirmCozinha'] == 0 && $item['ped_confirmacao'] == 1) {
                    echo 'bg-warning"></i> Cozinha';
                } else if ($item['ped_confirmUsu'] == 1 && $item['ped_confirmCozinha'] == 1 && $item['ped_confirmacao'] == 1) {
                    echo 'bg-success"></i> Finalizado';
                }
                echo '
                    </span>
                </td>
                <td>
                    ' . $item['ped_pagamento'] . '
                </td>
                <td>
                     ';
                if ($item['ped_pagamento'] == "Pontos") {
                    echo $item['ped_valor'];
                } else {
                    $valor = ' R$ ' . number_format($item['ped_valor'], 2, ',', '.');
                    echo $valor;
                }
                echo ' 
                </td>
                ';
                if ($item['ped_confirmUsu'] == 1 && $item['ped_confirmacao'] == 0) {
                    echo '
                
                <td class="text-right">
                    <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                       </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#showItens" data-codigo="' . $item['pp_codigo'] . '">Ver Itens</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalEditPedido" data-codigo="' . $item['pp_codigo'] . '">Editar</a>
                            <a class="dropdown-item" onclick="confirmacaoDelPedidos(' . $item['pp_codigo'] . ')">Excluir</a>
                            <a class="dropdown-item" href="#" onclick="confirmacaoConfirmPedidos(' . $item['pp_codigo'] . ',' . $item['usu_codigo'] . ')">Confirmar</a>
                            <a class="dropdown-item" href="#" onclick="confirmacaoFinalizaPedido(' . $item['pp_codigo'] . ')">Finalizar</a>
                        </div>
                </div>
            </td>
            ';
                } else {
                    echo '<td class="text-right">
                    <div class="dropdown">
                    </div>
                    </td>';
                }
                echo '
        </tr>
                                            ';
            }
        }
    }

    function updatePedido($id, $bairro, $rua, $numero) {
        $verifica = "SELECT * FROM pedidos WHERE ped_bairro = '$bairro' AND ped_rua = '$rua' AND ped_numeroCasa = '$numero' AND pp_codigo = $id";
        if ($a = $this->getOne($verifica)) {
            header("Location: admin.php?pedidos");
        } else {
            $query = "UPDATE pedidos SET ped_bairro = '$bairro', ped_rua = '$rua', ped_numeroCasa = '$numero' WHERE pp_codigo = $id";
            if ($this->execute($query)) {
                echo "<script>window.location.href='admin.php?pedidos';</script>";
                echo "<script>window.alert('Pedido Atualizado');</script>";
            } else {
                echo "<script>window.alert('erro');</script>";
            }
        }
    }

    public function DelPedidos($id) {
        $verifica = "SELECT * FROM pedidos WHERE pp_codigo =" . $id;
        if ($a = $this->getOne($verifica)) {
            $delPP = "DELETE FROM pedidos_produtos WHERE pp_codigo = " . $id;
            if ($this->execute($delPP)) {
                $deleta = "DELETE FROM pedidos WHERE pp_codigo = $id";
                $del = $this->execute($deleta);
                if ($del) {
                    echo "<script>window.location.href='admin.php?pedidos';</script>";
                } else {
                    echo "<script>window.alert('Error');</script>";
                }
            }
        }
    }

    public function Confirm($id, $user) {
        if ($id > 0) {
            $update = "UPDATE pedidos SET ped_confirmacao = 1 WHERE pp_codigo = $id";
            $confirma = $this->execute($update);
            if ($confirma) {
                $query = "INSERT INTO mensagens(men_texto,men_visualizado, usu_codigo) VALUE ('Seu produto está sendo feito! Aguarde um pouco', 0,$user)";
                if ($this->execute($query)) {
                    echo "<script>window.location.href='admin.php?pedidos';</script>";
                } else {
                    echo "<script>window.alert('Error');</script>";
                }
            }
        }
    }

}

class FuncaoTipo extends Conexao {

    public function cadastraTipo($nome) {

        if ($nome != null) {
            $verifica = $this->getOne("SELECT * FROM tipo WHERE tip_nome = '" . $nome . "'");
            if (!$verifica) {
                $query = "INSERT INTO tipo(tip_nome,tip_ativo) VALUES ('$nome',1)";
                if ($this->execute($query)) {
                    $buscaCod = "SELECT * FROM tipo WHERE tip_nome = '$nome'";
                    $get = $this->getOne($buscaCod);
                    $codigoPasta = $get['tip_codigo'];
                    $pasta = md5($codigoPasta);
                    mkdir("../img/produtos/$pasta/", 0777, true);
                    header("Location: admin.php?produtos");
                }
            } else {
                echo "<script>
                        swal('Putz...', 'Este email já está em uso!', 'error');
                     </script>";
            }
        }
    }

    public function BuscaAllTipos() {
        $busca = "SELECT * FROM tipo WHERE tip_nome != 'Promoções'";
        $res = $this->getAll($busca);

        if ($res) {
            $cont = 1;
            foreach ($res as $tipos) {

                echo '
                <div class="col-12 row mt-1 p-0 border">
                    <div class="col-6 col-sm-6  col-md-6 col-lg-4 mt-1"><p>' . $tipos['tip_nome'] . '</p></div> 
                    <div class="col-2 col-sm-2 col-md-2 pr-3 col-lg-2 pr-md-0 ">
                        <a id="DeleteTipo"  onclick="confirmacaoDelTipo(' . $tipos['tip_codigo'] . ')" ><button class=" mt-0 ml-4" type="" name="DeletarTipo" id="BtnDel2"><img src="../img/icons/delete.png"></button></a>
                        <input type="hidden" id="textModal" value="Deseja apagar esse tipo, será apagado todos os produtos dentro?"/>
                    </div>
                    <div class="col-2 col-sm-2 col-md-2 pr-3 col-lg-3 pr-md-0 ">
                        <a id="DeleteTipo"  data-toggle="modal" data-target="#modalEditTipo" data-codigo="' . $tipos['tip_codigo'] . '"><button class=" mt-0 ml-4" type="" name="DeletarTipo" id="BtnDel2"><img src="../img/icons/edit.png"></button></a>
                        
                    </div>
                    <div class="col-2 col-sm-2 col-md-2 col-lg-3 pr-md-0">
                    <label class="custom-toggle mt-2">
                        <input type="checkbox"';
                if($tipos['tip_ativo'] == 1){
                    echo ' checked';
                }else{
                    
                }
                echo ' onclick="atualizarTipo(this);" value="'.$tipos['tip_ativo'].'" name="'.$tipos['tip_codigo'].'">
                        <span class="custom-toggle-slider"></span>
                     </label>
                    </div>
                 </div>';
                $cont++;
            }
        } else {
            echo "<p class='text text-center' style='color:red;'>Nenhum Tipo Cadastrado</p>";
        }
    }

    public function updateTipoName($tipo, $id) {
        if ($tipo != null && $id > 0) {
            $query = "SELECT * FROM tipo WHERE tip_codigo = $id";
            if ($this->getOne($query)) {
                $update = "UPDATE tipo SET tip_nome = '$tipo' WHERE tip_codigo = $id";
                if ($this->execute($update)) {
                    header('Location: admin.php?produtos');
                }
            }
        }
    }

    public function ApagarTipo($id) {
        $buscaFoto = "SELECT * FROM tipo WHERE tip_codigo = $id";
        $a = $this->getOne($buscaFoto);
        if ($a) {
            $buscaProRec = "SELECT pro.* FROM produtos pro, receita rec WHERE pro.tip_codigo = $id AND pro.pro_codigo = rec.pro_codigo";
            $result = $this->getAll($buscaProRec);
            if ($result) {
                foreach ($result as $del) {
                    $ver = "SELECT * FROM receita WHERE pro_codigo = " . $del['pro_codigo'];
                    if ($this->getAll($ver)) {
                        $apagaRec = "DELETE FROM receita WHERE pro_codigo = " . $del['pro_codigo'];
                        $this->execute($apagaRec);
                    }
                }
            } else {
                $buscaProRec = "SELECT pro.* FROM produtos pro WHERE pro.tip_codigo = $id";
                $result = $this->getAll($buscaProRec);
            }
            foreach ($result as $del) {
                $apagaPro = "DELETE FROM produtos WHERE pro_codigo = " . $del['pro_codigo'];
                $this->execute($apagaPro);
            }
            $query = "DELETE FROM tipo WHERE tip_codigo = $id";
            $ret = $this->execute($query);

            if ($ret) {
                $pastaMd = md5($id);
                $pasta = "../img/produtos/$pastaMd/";
                chmod("$pasta", 0777);
                $img = opendir($pasta);
                while ($nome_itens = readdir($img)) {
                    $itens[] = $nome_itens;
                }
                foreach ($itens as $key => $arquivo) {
                    if ($arquivo != '.' && $arquivo != '..') {
                        unlink($pasta . '/' . $arquivo);
                    }
                }
                closedir($pasta);
                rmdir($pasta);
                header("Location: admin.php?produtos");
            } else {
                echo "<script>window.alert('Este ja foi excluído');</script>";
                header("Location: admin.php?produtos");
            }
        }
    }

    public function updateTipo($tip_ativo, $tip_codigo) {
        $query = "UPDATE tipo SET tip_ativo = " . $tip_ativo . " WHERE tip_codigo = " . $tip_codigo;
        $this->execute($query);
    }

}

class FuncaoProduto extends Conexao {

    public function getTip($tipo) {
        $query = "SELECT * FROM tipo WHERE tip_nome = '$tipo'";
        $tipo = $this->getOne($query);
        return $tipo['tip_codigo'];
    }

    public function BuscaAllProdutos() {
        $tipoBusca = $this->getTip('Promoções');
        if ($tipoBusca) {
            $buscaPro = "SELECT tip.*, pro.* FROM tipo tip, produtos pro WHERE pro.tip_codigo = tip.tip_codigo AND tip.tip_codigo != $tipoBusca";
            $geralPro = $this->getAll($buscaPro);
            if ($geralPro) {
                $cont = 1;
                foreach ($geralPro as $produtos) {
                    $valor = ' R$ ' . number_format($produtos['pro_valor'], 2, ',', '.');
                    $pasta = md5($produtos['tip_codigo']);
                    echo '  <div class="col-12 mt-1 border p-2 pl-1 ml-2 row">
                            <label class="col-lg-3 col-4 col-sm-3 h-100"><img src="../img/produtos/';
                    if ($produtos['pro_foto'] == 'proDefaut.png') {
                        echo 'proDefaut.png';
                    } else {
                        echo $pasta . '/' . $produtos['pro_foto'];
                    }
                    echo '" class="imgProduto"/></label>
                            <label class="col-lg-4 col-8 col-sm-9 border"><b>' . $produtos['pro_nome'] . '</b> - Tipo - <b>' . $produtos['tip_nome'] . '</b></label>
                            <label class="col-lg-2 col-4 col-sm-4">' . $valor . '</label>
                           <label class="col-lg-2 col-4 col-sm-4">
                                <a href="admin.php?produtos&proEdit&id=' . $produtos['pro_codigo'] . '">
                                    <button style="background:none;border:none;outline:none;">
                                        <img src="../img/icons/edit.png" class="imgEditProduto"/>
                                    </button>
                                </a>
                            </label>
                            <label class="col-lg-1 col-4 col-sm-4"><a id="DeleteProduto" onclick="confirmacaoDelProdutos(' . $produtos['pro_codigo'] . ')"><img src="../img/icons/delete.png" class="imgEditProduto"/></a></label>
                             <label class="col-6 col-md-8"><a style="text-decoration:underline;" data-toggle="collapse" data-target="#verIgr' . $cont . '">Ver ingredientes</a></label>
                            
                              <label class="col-6 col-md-4 float-right">' . $produtos['pro_pontos'] . ' Pontos do Produto</label> 
                            <label class="col-12 collapse" id="verIgr' . $cont . '">
                             ';
                    $busca = "SELECT igr.igr_nome FROM receita rec, ingredientes igr WHERE rec.pro_codigo = " . $produtos['pro_codigo'] . " AND rec.igr_codigo = igr.igr_codigo";
                    $busca = $this->getAll($busca);
                    if ($busca) {
                        echo '<p class="allIgr text">';
                        foreach ($busca as $igr) {
                            echo $igr['igr_nome'] . ', ';
                        }
                        echo '</p>';
                    } else {
                        echo '<p class="text text-danger p-2 text-center">Nenhum ingrediente nesse produto!</p>';
                    }
                    echo '
                             </label>
                              
                        </div>';
                    $cont++;
                }
            } else {
                echo "<p class='text text-center' style='color:red;'>Nenhum Produto Cadastrado</p>";
            }
        } else {
            echo "<p class='text text-center' style='color:red;'>Nenhum Produto Cadastrado</p>";
        }
    }

    public function FilterGet() {
        $codigoT = $this->getTip('Promoções');
        $busca = "SELECT * FROM tipo WHERE tip_codigo != $codigoT";
        $filtros = $this->getAll($busca);
        if ($filtros) {
            foreach ($filtros as $resultFilter) {
                echo '
                      <div class="col-lg-4 col-6 mt-2" id="FilterBox">
                      
                        <a class="FilterA" href="?produtos&filterTipo=' . $resultFilter['tip_codigo'] . '" name="">
                          <div id="FilterNameUnderBox" class="">' . $resultFilter['tip_nome'] . '</div>
                        </a>
                      
                      </div>
                    ';
            }
        }
    }

    public function FilterSet($id) {
        $buscaPro = "SELECT tip.*, pro.* FROM tipo tip, produtos pro WHERE pro.tip_codigo = tip.tip_codigo AND tip.tip_codigo = $id";
        $geralPro = $this->getAll($buscaPro);
        if ($geralPro) {

            $cont = 1;
            foreach ($geralPro as $produtos) {
                $valor = ' R$ ' . number_format($produtos['pro_valor'], 2, ',', '.');
                $pasta = md5($produtos['tip_codigo']);
                echo '  <div class="col-12 mt-1 border p-2 pl-1 ml-2 row">
                            <label class="col-lg-3 col-4 col-sm-3 h-100"><img src="../img/produtos/';
                if ($produtos['pro_foto'] == 'proDefaut.png') {
                    echo 'proDefaut.png';
                } else {
                    echo $pasta . '/' . $produtos['pro_foto'];
                }
                echo '" class="imgProduto"/></label>
                            <label class="col-lg-4 col-8 col-sm-9 border"><b>' . $produtos['pro_nome'] . '</b> - Tipo - <b>' . $produtos['tip_nome'] . '</b></label>
                            <label class="col-lg-2 col-4 col-sm-4">' . $valor . '</label>
                           <label class="col-lg-2 col-4 col-sm-4">
                                <a href="admin.php?produtos&proEdit&id=' . $produtos['pro_codigo'] . '">
                                    <button style="background:none;border:none;outline:none;">
                                        <img src="../img/icons/edit.png" class="imgEditProduto"/>
                                    </button>
                                </a>
                            </label>
                            <label class="col-lg-1 col-4 col-sm-4"><a id="DeleteProduto" onclick="confirmacaoDelProdutos(' . $produtos['pro_codigo'] . ')"/><img src="../img/icons/delete.png" class="imgEditProduto"/></a></label>
                            <input type="hidden" id="textModal" value="Deseja apagar esse produto?, será apagado de todo seu histórico"/> 
                            <label class="col-6 col-md-8"><a  style="text-decoration:underline;" data-toggle="collapse" data-target="#verIgr' . $cont . '">Ver ingredientes</a></label>
                            <label class="col-6 col-md-4 float-right">' . $produtos['pro_pontos'] . ' Pontos do Produto</label> 
                            <label class="col-12 collapse" id="verIgr' . $cont . '">
                             ';
                $busca = "SELECT igr.igr_nome FROM receita rec, ingredientes igr WHERE rec.pro_codigo = " . $produtos['pro_codigo'] . " AND rec.igr_codigo = igr.igr_codigo";
                $busca = $this->getAll($busca);
                if ($busca) {
                    echo '<p class="allIgr text">';
                    foreach ($busca as $igr) {
                        echo $igr['igr_nome'] . ', ';
                    }
                    echo '</p>';
                } else {
                    echo '<p class="text text-danger p-2 text-center">Nenhum ingrediente nesse produto!</p>';
                }
                echo '
                             </label>
                            
                        </div>';
                $cont++;
            }
        } else {
            echo "<p class='text text-center' style='color:red;'>Nenhum Produto Cadastrado nesse tipo</p>";
        }
    }

    public function geraSelectTipo() {
        $codT = $this->getTip('Promoções');
        $gera = "SELECT * FROM tipo WHERE tip_codigo != $codT";
        $tipo = $this->getAll($gera);
        if ($tipo) {
            foreach ($tipo as $select) {
                echo '<option value=' . $select['tip_codigo'] . '>' . $select['tip_nome'] . '</option>';
            }
        } else {
            
        }
    }

    public function geraSelectTipoSelected($tip) {
        $codT = $this->getTip('Promoções');
        $gera = "SELECT * FROM tipo WHERE tip_codigo != $codT";
        $tipo = $this->getAll($gera);
        if ($tipo) {
            foreach ($tipo as $select) {
                echo '<option value="' . $select['tip_codigo'] . '"';

                if ($select['tip_codigo'] == $tip) {
                    echo 'selected';
                }
                echo '>' . $select['tip_nome'] . '</option>';
            }
        } else {
            
        }
    }

    public function GetAllIngredientes() {
        $query = "SELECT * FROM ingredientes";
        $ret = $this->getAll($query);
        if ($ret) {
            $cont = 1;
            foreach ($ret as $ing) {
                $ingValor = ' R$ ' . number_format($ing['igr_valor'], 2, ',', '.');
                echo '
                <div class="custom-control custom-checkbox col-lg-6 col-6 mt-1">
                    <input type="checkbox" class="custom-control-input" id="igr' . $cont . '" name="checkbox[]" value="' . $ing['igr_codigo'] . '"/>
                    <label class="custom-control-label" for="igr' . $cont . '">' . $ing['igr_nome'] . '(<font color="green">' . $ingValor . '</font>)</label>
                </div>';
                $cont++;
            }
        }
    }

    public function GetIngredientesByProduto($id) {
        $confirm = "SELECT * FROM receita WHERE pro_codigo = $id";
        if ($this->getAll($confirm)) {
            $query = "SELECT * FROM ingredientes";
            $ret = $this->getAll($query);
            if ($ret) {
                $cont = 1;
                echo ' <p class="col-12">Ingredientes do Produto</p>';
                foreach ($ret as $ing) {
                    $ingValor = ' R$ ' . number_format($ing['igr_valor'], 2, ',', '.');
                    echo '
                <div class="custom-control custom-checkbox col-lg-6 col-6 mt-1">
                    <input type="checkbox" class="custom-control-input" id="igr' . $cont . '" name="checkboxEdit[]" value="' . $ing['igr_codigo'] . '"
                        ';
                    $busca = "SELECT * FROM receita WHERE igr_codigo = " . $ing['igr_codigo'] . " AND pro_codigo = " . $id;
                    if ($this->getOne($busca)) {
                        echo 'checked';
                    }

                    echo '/>
                    <label class="custom-control-label" for="igr' . $cont . '">' . $ing['igr_nome'] . '(<font color="green">' . $ingValor . '</font>)</label>
                </div>';
                    $cont++;
                }
            }
        } else {
            $this->GetAllIngredientes();
        }
    }

    public function cadastraProduto($nome, $valor, $foto, $pontos, $pontosUsu, $tipo, $checkboxIgr) {

        $busca = "SELECT * FROM produtos WHERE pro_nome = '$nome' AND tip_codigo = $tipo";
        $ret = $this->getOne($busca);
        if ($ret) {
            $_SESSION['jeepnt'] = "jaExist";
            header("Location:admin.php?produtos");
        } else {
            $query = "INSERT INTO `produtos`(`pro_nome`, `pro_valor`, `pro_foto`, `pro_pontos`,`pro_pontosUsu`, `tip_codigo`) VALUES ('$nome','$valor','$foto',$pontos,$pontosUsu, $tipo)";
            $exec = $this->execute($query);
            if ($exec) {
                $busca = "SELECT * FROM produtos WHERE pro_nome = '$nome' AND tip_codigo = $tipo";
                $resultado = $this->getOne($busca);
                $codigo = $resultado['pro_codigo'];
                $busca = "SELECT * FROM produtos WHERE pro_nome = '$nome' AND tip_codigo = $tipo";
                $this->criaReceita($checkboxIgr, $codigo);
                $_SESSION['jeepnt'] = "cadastrado";
                header("Location:admin.php?produtos");
            } else {
                echo "Error";
            }
        }
    }

    public function criaReceita($checkboxIgr, $codigo) {
        foreach ($checkboxIgr as $dadosIgr) {
            $cadastra = "INSERT INTO receita(igr_codigo, pro_codigo) VALUES ($dadosIgr ,$codigo)";
            $this->execute($cadastra);
        }
    }

    public function excluirProduto($id) {
        if ($id > 0) {
            $confere = "SELECT * FROM produtos WHERE pro_codigo = $id";
            $res = $this->getOne($confere);
            if ($res) {
                $query = "DELETE FROM `produtos` WHERE pro_codigo = $id";
                $this->excluirReceita($id);
                if ($res['pro_foto'] == "proDefaut.png") {
                    
                } else {
                    $pasta = md5($res['tip_codigo']);
                    $foto = $res['pro_foto'];
                    unlink("../img/produtos/$pasta/" . $foto . "");
                }

                $this->execute($query);
                header("Location:admin.php?produtos");
            } else {
                echo "não existe";
            }
        }
    }

    public function excluirReceita($id) {
        if ($id > 0) {
            $query = "DELETE FROM `receita` WHERE pro_codigo = $id ";
            $exclui = $this->execute($query);
        }
    }

    public function getInformProduto($id) {
        $query = "SELECT * FROM produtos WHERE pro_codigo = $id";
        $ret = $this->getOne($query);
        if ($ret) {
            return $ret;
        }
    }

    public function updateProduto($id, $nome, $foto, $valor, $pontos, $pontosUsu, $tipo, $checkbox) {
        $rec = "SELECT * FROM receita WHERE pro_codigo = $id";
        $info = $this->getAll($rec);
        if ($info) {
            $this->excluirReceita($id);
        }if ($checkbox != null) {
            $this->criaReceita($checkbox, $id);
        }

        $query = "UPDATE `produtos` SET `pro_nome`='$nome',`pro_valor`=$valor,`pro_foto`='$foto',`pro_pontos`=$pontos,pro_pontosUsu=$pontosUsu, `tip_codigo`= $tipo WHERE pro_codigo = $id";
        if ($this->execute($query)) {
            $_SESSION['proAtt'] = 'success';
        } else {
            $_SESSION['proAtt'] = 'error';
        }
        header("Location:admin.php?produtos");
    }

    public function AllInformProduto($id) {
        $confirm = "SELECT * FROM receita WHERE pro_codigo = $id";
        if ($this->getAll($confirm)) {
            $queryBusca = "SELECT pro.* FROM produtos pro, ingredientes igr, tipo tip, receita rec WHERE igr.igr_codigo = rec.igr_codigo AND rec.pro_codigo = pro.pro_codigo AND pro.pro_codigo = $id and pro.tip_codigo = tip.tip_codigo";
        } else {
            $queryBusca = $query = "SELECT pro.* FROM produtos pro, tipo tip WHERE pro.pro_codigo = $id AND pro.tip_codigo = tip.tip_codigo";
        }
        $dados = $this->getOne($queryBusca);

        return $dados;
    }

}

class Ingredientes extends Conexao {

    public function CadastraIngredientes($nome, $valor) {
        $virgula = array('.', ',');
        $espaco = array('', '.');
        $valorNovo = str_replace($virgula, $espaco, $valor);
        if (($nome != null) && ($valor != null)) {
            $verifica = "SELECT * FROM ingredientes WHERE igr_nome = '{$nome}'";
            $ret = $this->getOne($verifica);
            if ($ret) {
                $_SESSION['msgFaltacampos'] = "<p class='text-center mt-3'>Este ingrediente já existe!</p>";
            } else {
                $query = "INSERT INTO ingredientes (igr_nome, igr_valor) VALUES ('" . $nome . "','$valorNovo')";
                $cadastra = $this->execute($query);
                if ($cadastra) {
                    header("Location:admin.php?ingredientes");
                } else {
                    $_SESSION['msgFaltacampos'] = "<p class='text-center text-danger mt-2'>Aconteceu algum erro, tente novamente!</p>";
                }
            }
        }
    }

    public function BuscaIngredientes() {
        $getall = "SELECT * FROM ingredientes ORDER BY igr_codigo DESC";
        $geral = $this->getAll($getall);
        if ($geral) {
            $cont = 1;

            foreach ($geral as $dados) {
                $ingValor = number_format($dados['igr_valor'], 2, ',', '.');


                echo '
                <div class = "container-fluid m-0 mt-2 border row p-2" >
                    <div class = "col-2">
                        <img src = "../img/icons/chili.png"/>
                    </div>
                    <div class = "col-6">
                        <p class = "text"><b>' . $dados['igr_nome'] . '</b> <font color = "green"> ' . $ingValor . '</font> reais</p>
                    </div>
                    <div class = "col-2">
                        <button type="button" style="background:none;border:none;outline:none;" data-toggle="modal" data-target="#modalEditIngre" data-whatevercodigo="' . $dados['igr_codigo'] . '" data-whatevernome="' . $dados['igr_nome'] . '" data-whatevervalor="' . $ingValor . '"><img src = "../img/icons/edit.png" class = "imgDelete" /></button>
                    </div>
                    <div class="col-2 ">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="igr' . $cont . '" name="igrApagar[]" value="' . $dados['igr_codigo'] . '"/>
                            <label class="custom-control-label" for="igr' . $cont . '"></label>
                        </div>
                    </div>
                </div>
                ';
                $cont++;
            }
        }
    }

    function deletaIngrediente($checkBox) {
        if ($checkBox != null) {
            foreach ($checkBox as $dadosDel) {
                $verifica = "SELECT * FROM receita WHERE igr_codigo = " . $dadosDel;
                if ($this->getAll($verifica)) {
                    $apagaRec = "DELETE FROM receita WHERE igr_codigo = " . $dadosDel;
                    $this->execute($apagaRec);
                }
                $deleta = "DELETE FROM ingredientes WHERE igr_codigo =" . $dadosDel;
                if ($this->execute($deleta)) {
                    header("Location:admin.php?ingredientes");
                } else {
                    $_SESSION['msgError'] = "<p class='text-center text-danger mt-3'>Error</p>";
                }
            }
        }
    }

    function updateIngrediente($id, $nome, $valor) {

        if (($id > 0) && ($nome != null) && ($valor > 0)) {

            $ver = "SELECT * FROM ingredientes WHERE igr_codigo = $id";
            $ret = $this->getOne($ver);
            if ($ret) {

                if (($ret['igr_nome'] == $nome) && ($ret['igr_valor'] == $valor)) {
                    $_SESSION['msgError'] = "AltDes";
                } else {
                    $query = "UPDATE ingredientes SET igr_nome = '$nome', igr_valor = '$valor' WHERE igr_codigo = $id";
                    $up = $this->execute($query);
                    if ($up) {
                        $_SESSION['msgError'] = "success";
                    } else {
                        $_SESSION['msgError'] = "errorUpt";
                    }
                }
            }
        }
    }

    public function buscaIngredienteName($nome) {
        $buscaUm = "SELECT * FROM ingredientes WHERE igr_nome LIKE '%$nome%'";
        $ve = $this->getAll($buscaUm);
        if ($ve) {
            $cont = 1;
            foreach ($ve as $geral) {
                $ingValor = number_format($geral['igr_valor'], 2, ',', '.');
                echo '
                <div class = "container-fluid m-0 mt-2 border row p-2" >
                    <div class = "col-2">
                        <img src = "../img/icons/chili.png"/>
                    </div>
                    <div class = "col-6">
                        <p class = "text"><b>' . $geral['igr_nome'] . '</b> <font color = "green"> ' . $ingValor . '</font> reais</p>
                    </div>
                    <div class = "col-2">
                        <button type="button" style="background:none;border:none;outline:none;" data-toggle="modal" data-target="#modalEditIngre" data-whatevercodigo="' . $geral['igr_codigo'] . '" data-whatevernome="' . $geral['igr_nome'] . '" data-whatevervalor="' . $ingValor . '"><img src = "../img/icons/edit.png" class = "imgDelete" /></button>
                    </div>
                    <div class="col-2 ">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="igr' . $cont . '" name="igrApagar[]" value="' . $geral['igr_codigo'] . '"/>
                            <label class="custom-control-label" for="igr' . $cont . '"></label>
                        </div>
                    </div>
                </div>
                ';
                $cont++;
            }
        } else {
            echo '
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Alerta!</strong> não foi cadastrado nenhum ingrediente com esse nome!
                </div>
                ';
        }
    }

}

class FuncaoPromocao extends Conexao {

    function getAllPromocoes() {
        $codT = $this->getTip('Promoções');
        $query = "SELECT * FROM produtos WHERE tip_codigo = $codT";
        if ($ret = $this->getAll($query)) {
            foreach ($ret as $item) {
                echo '<div class="item">
                            <div class="pad15 row" id="pro">
                                <div class="ImgProView col-12">
                                <img';
                if ($item['pro_foto'] == 'proDefaut.png') {
                    echo ' src="../img/produtos/proDefaut.png"';
                } else {
                    $pasta = md5($item['tip_codigo']);
                    echo ' src="../img/produtos/' . $pasta . '/' . $item['pro_foto'] . '"';
                }
                echo ' />';
                $proValor = ' R$ ' . number_format($item['pro_valor'], 2, ',', '.');
                echo '</div>
                                <div class="InforProView col-12 p-0" >
                                    <div class="row row-center m-0">
                                    <p class="col-12 ProValor ml-auto mb-1" style="height: 20px;">' . $proValor . '</p>
                                     <p class="TittlePro col-12 text-dark">' . $item['pro_nome'] . '</p>
                                        ';

                echo'
                
                </div>
                <div class="Bxedit">
                    <button type="button" style="background:none;border:none;" data-target="#modalEditPromocao" data-toggle="modal" data-codigo = "' . $item['pro_codigo'] . '" />
                        <img src="../img/icons/edit.png" />
                    </button>
                </div>
                <div class="Bxexpro">
                    <a id="delPromocao" onclick="confirmacaoDelPromocao(' . $item['pro_codigo'] . ', event)"/>
                        <img src="../img/icons/delete.png" /></div>
                    </a>
                </div>
                </div>
                </div>';
            }
        }
    }

    public function getTip($tipo) {
        $query = "SELECT * FROM tipo WHERE tip_nome = '$tipo'";
        $tipo = $this->getOne($query);
        return $tipo['tip_codigo'];
    }

    public function cadastraPromocao($nome, $valor, $foto, $pontos, $pontosUsu, $tipo) {

        $busca = "SELECT * FROM produtos WHERE pro_nome = '$nome' AND tip_codigo = $tipo";
        $ret = $this->getOne($busca);
        if ($ret) {
            $_SESSION['jeepnt'] = "jaExist";
            header("Location:admin.php?promocoes");
        } else {
            $query = "INSERT INTO `produtos`(`pro_nome`, `pro_valor`, `pro_foto`, `pro_pontos`,pro_pontosUsu, `tip_codigo`) VALUES ('$nome','$valor','$foto',$pontos,$pontosUsu, $tipo)";
            $exec = $this->execute($query);
            if ($exec) {

                $_SESSION['jeepnt'] = "cadastrado";
                header("Location:admin.php?promocoes");
            } else {
                echo "Error";
            }
        }
    }

    public function delPromocao($id) {
        if ($id > 0) {
            $verPedidos = "SELECT * FROM pedidos_produtos WHERE pro_codigo = $id";
            if ($this->getOne($verPedidos)) {
                $queryDelPed = "DELETE FROM pedidos_produtos WHERE pro_codigo = $id";
                if ($this->execute($queryDelPed)) {
                    $verifica = "SELECT * FROM produtos WHERE pro_codigo = $id";
                    if ($dado = $this->getOne($verifica)) {
                        if ($dado['pro_foto'] == "proDefaut.png") {
                            
                        } else {
                            $pasta = md5($dado['tip_codigo']);
                            $foto = $dado['pro_foto'];
                            unlink("../img/produtos/$pasta/" . $foto . "");
                        }
                        $query = "DELETE FROM produtos WHERE pro_codigo = $id";
                        if ($this->execute($query)) {
                            header("Location:admin.php?promocoes");
                        }
                    } else {
                        header("Location: admin.php?promocoes");
                    }
                }
            }
        }
    }

    public function UpdatePromocao($codigo, $nome, $valor, $foto, $pontos, $pontosUsu, $tipo) {
        if ($codigo > 0) {
            $verifica = "SELECT * FROM produtos WHERE pro_codigo = $codigo";
            if ($this->getOne($verifica)) {
                $query = "UPDATE `produtos` SET `pro_nome`='$nome',`pro_valor`='$valor',`pro_foto`='$foto',`pro_pontos`='$pontos', pro_pontosUsu = '$pontosUsu' WHERE pro_codigo = $codigo";
                if ($this->execute($query)) {
                    header("Location: admin.php?promocoes");
                }
            }
        }
    }

    public function delImgPro($foto) {
        $idTipo = $this->getTip('Promoções');
        if ($idTipo > 0) {
            $pastaMd = md5($idTipo);
            $pasta = "../img/produtos/$pastaMd/";
            chmod("$pasta", 0777);
            $img = opendir($pasta);
            unlink("../img/produtos/$pasta/" . $foto . "");
        }
    }

    public function informPromo($id) {
        if ($id > 0) {
            $query = "SELECT * FROM produtos WHERE pro_codigo = $id";
            if ($ret = $this->getOne($query)) {
                return $ret;
            } else {
                return 1;
            }
        }
    }

    public function getInformToHistoric() {
        
    }

    public function countUser() {
        $query = "SELECT COUNT(usu_codigo) AS qtd FROM usuario";
        if ($a = $this->getOne($query)) {
            return $a['qtd'];
        }
    }

    public function countProducts() {
        $query = "SELECT COUNT(pro_codigo) AS qtd FROM produtos";
        if ($a = $this->getOne($query)) {
            return $a['qtd'];
        }
    }

    public function countReceita() {

        $query = "SELECT SUM(ped_valor) AS qtd FROM pedidos WHERE ped_confirmacao = 1 AND ped_confirmCozinha = 1 AND ped_pagamento IN ('Cartão', 'Dinheiro') AND ped_hora >= DATE_SUB( DATE( NOW() ), INTERVAL DAY( NOW() ) -1 DAY ) Order by pp_codigo";
        if ($a = $this->getOne($query)) {
            return $a['qtd'];
        }
    }

    public function countVendas() {
        $query = "SELECT COUNT(pp_codigo) AS qtd FROM pedidos WHERE ped_confirmacao = 1 AND ped_confirmCozinha = 1 AND ped_hora >= DATE_SUB( DATE( NOW() ), INTERVAL DAY( NOW() ) -1 DAY ) AND CURRENT_DATE() Order by pp_codigo";
        if ($a = $this->getOne($query)) {
            return $a['qtd'];
        }
    }

    public function getVendas() {
        $query = "SELECT usu.*,ped.*, SUM(pp.ppp_qtd) AS qtd FROM pedidos ped, pedidos_produtos pp, usuario usu WHERE usu.usu_codigo = ped.usu_codigo AND ped.ped_confirmacao = 1 AND ped.ped_confirmCozinha = 1 AND ped.pp_codigo = pp.pp_codigo AND ped.ped_hora >= DATE_SUB( DATE( NOW() ), INTERVAL DAY( NOW() ) -1 DAY ) GROUP BY ped.pp_codigo Order by ped.pp_codigo ";
        if ($exec = $this->getAll($query)) {
            echo ' <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Comprador</th>
                                                    <th scope="col">Quantidade de Produtos</th>
                                                    <th scope="col">Valor</th>
                                                    <th scope="col">Pagamento</th>
                                                    <th scope="col">Data</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
            foreach ($exec as $item) {
                $data = date('d-m-Y', strtotime($item['ped_hora']));
                if ($item['ped_pagamento'] == 'Dinheiro' || $item['ped_pagamento'] == 'Cartão') {
                    $valor = ' R$ ' . number_format($item['ped_valor'], 2, ',', '.');
                } else {
                    $valor = $item['ped_valor'];
                }

                echo '
                <tr>
                     <th scope="row">
                     ' . $item['usu_nome'] . '  
                </th>
                      <td>
                            ' . $item['qtd'] . ' 
                       </td>
                       <td>
                           ' . $valor . '
                        </td>
                        <td>
                          ' . $item['ped_pagamento'] . '
                        </td>
                        <td>
                          ' . $data . '
                        </td>
                        
                     </tr>';
            }
            echo "</tbody>";
        } else {
            echo "<p class='text-center '>Nenhuma Venda Efetuada esse Mês!</p>";
        }
    }

    public function getDates() {

        $cont = 1;
        $query = "SELECT MONTH(ped.ped_hora) as mes, SUM(pp.ppp_qtd) as totalMes FROM pedidos ped, pedidos_produtos pp WHERE ped.ped_confirmacao = 1 AND ped.ped_confirmUsu = 1 AND ped.ped_confirmCozinha = 1 AND ped.pp_codigo = pp.pp_codigo GROUP BY MONTH(ped.ped_hora)";
        if ($a = $this->getAll($query)) {
            $array = [];
            foreach ($a as $item) {
                if ($item['mes'] == null) {
                    $array['0'] = 0;
                } else {
                    if ($item['mes'] == 1) {
                        if ($item['mes'] == null) {
                            $array['0'] = 0;
                        } else {
                            $array['0'] = $item['totalMes'];
                        }
                    } else if ($item['mes'] == 2) {
                        if ($item['mes'] == null) {
                            $array['1'] = 0;
                        } else {
                            $array['1'] = $item['totalMes'];
                        }
                    } else if ($item['mes'] == 3) {
                        if ($item['mes'] == null) {
                            $array['2'] = 0;
                        } else {
                            $array['2'] = $item['totalMes'];
                        }
                    } else if ($item['mes'] == 4) {
                        if ($item['mes'] == null) {
                            $array['3'] = 0;
                        } else {
                            $array['3'] = $item['totalMes'];
                        }
                    } else if ($item['mes'] == 5) {
                        if ($item['mes'] == null) {
                            $array['4'] = 0;
                        } else {
                            $array['4'] = $item['totalMes'];
                        }
                    } else if ($item['mes'] == 6) {
                        if ($item['mes'] == null) {
                            $array['5'] = 0;
                        } else {
                            $array['5'] = $item['totalMes'];
                        }
                    } else if ($item['mes'] == 7) {
                        if ($item['mes'] == null) {
                            $array['6'] = 0;
                        } else {
                            $array['6'] = $item['totalMes'];
                        }
                    } else if ($item['mes'] == 8) {
                        if ($item['mes'] == null) {
                            $array['7'] = 0;
                        } else {
                            $array['7'] = $item['totalMes'];
                        }
                    } else if ($item['mes'] == 9) {
                        if ($item['mes'] == null) {
                            $array['8'] = 0;
                        } else {
                            $array['8'] = $item['totalMes'];
                        }
                    } else if ($item['mes'] == 10) {
                        if ($item['mes'] == null) {
                            $array['9'] = 0;
                        } else {
                            $array['9'] = $item['totalMes'];
                        }
                    } else if ($item['mes'] == 11) {
                        if ($item['mes'] == null) {
                            $array['10'] = 0;
                        } else {
                            $array['10'] = $item['totalMes'];
                        }
                    } else if ($item['mes'] == 12) {
                        if ($item['mes'] == null) {
                            $array['11'] = 0;
                        } else {
                            $array['11'] = $item['totalMes'];
                        }
                    }
                }
            }
            $i = 0;
            foreach ($array as $mes) {
                if ($i == 0) {
                    echo $mes;
                } else {
                    echo ',' . $mes;
                }
                $i += 1;
            }
        }
    }

}

?>