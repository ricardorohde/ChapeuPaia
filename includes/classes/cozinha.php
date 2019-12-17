<?php

include_once '../classes/Conexao.php';

class cozinha extends Conexao {

    function getAllPedidos() {
        $query = "SELECT ped.*, pp.*, SUM(pp.ppp_qtd) as qtd FROM pedidos ped, pedidos_produtos pp WHERE ped.ped_confirmCozinha = 0 AND ped.ped_confirmacao = 1 AND ped.pp_codigo = pp.pp_codigo GROUP BY ped.pp_codigo ORDER BY ped.pp_codigo";
        $resultado = $this->getAll($query);
        if ($resultado) {
            foreach ($resultado as $item) {
                echo ' 
            <tr>
                <th scope="row">
                    <div class="media align-items-center">
                        
                        <div class="media-body">
                            <span class="mb-0 text-sm ml-2">' . $item['qtd'] . '</span>
                        </div>
                    </div>
                </th>
                
                
                <td>
                     ';
                $data = date('d-m-Y H:i:s', strtotime($item['ped_hora']));
                echo $data;
                echo ' 
                </td>
                <td>
                    <span class="badge badge-dot mr-4">
                        <i class="';
                if ($item['ped_confirmUsu'] == 1 && $item['ped_confirmacao'] == 1 && $item['ped_confirmCozinha'] == 0) {
                    echo 'bg-danger"></i> Pendente';
                }
                echo '
                    </span>
                </td>
                ';
                if ($item['ped_confirmUsu'] == 1 && $item['ped_confirmacao'] == 1 && $item['ped_confirmCozinha'] == 0) {
                    echo '
                
                <td class="text-right">
                    <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                       </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#showItens" data-codigo="' . $item['pp_codigo'] . '">Ver Itens</a>
                            
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

    function showItens($id) {
        if ($a = $this->getOne("SELECT ped.* FROM pedidos ped,usuario usu WHERE ped.pp_codigo = $id AND ped.usu_codigo = usu.usu_codigo")) {
            echo '<div class="modal-content">
                    <input type="hidden" name="pedidoConfirm" value="' . $id . '"/>
                            <div class="modal-header">
                                <h3 class="modal-title" id="modal-title-default">Pedido</h3>
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
                        <div class="col-12 row m-0">
                            <p>' . $item['ppp_qtd'] . ' '. $item['tip_nome'] .' de ' . $item['pro_nome'] . '</p>
                            <p class="col-12">';
                    if ($igr = $this->getAll("SELECT rec.*, igr.* FROM ingredientes igr, receita rec WHERE rec.pro_codigo = " . $item['pro_codigo'] . " AND rec.igr_codigo = igr.igr_codigo")) {

                        foreach ($igr as $ing) {
                            echo $ing['igr_nome'] . ', ';
                        }
                    }
                    echo '
                    </p>
                        </div>
                        
                    </div>
                    ';
                }
            }
            echo '
                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-link  ml-auto btn-lg" data-dismiss="modal">Cancelar</button>
                                
                                <button type="submit" name="btnConfirmPedido" class="btn" style="background: firebrick;color:white;">Confirmar</button>

                            </div>
                        </div>';
        }
    }

    function confirm($id) {
        if ($id > 0) {
            $query = "SELECT * FROM pedidos WHERE pp_codigo = " . $id;
            if ($a = $this->getOne($query)) {
                $update = "UPDATE pedidos SET ped_confirmCozinha = 1 WHERE pp_codigo = $id";
                if ($this->execute($update)) {
                    if ($ret = $this->getAll("SELECT * FROM mensagens WHERE usu_codigo = " . $a['usu_codigo'])) {
                        $deletaMen = "DELETE FROM mensagens WHERE usu_codigo = " . $a['usu_codigo'];
                        if ($this->execute($deletaMen)) {
                            
                        } else {
                            echo "<script>window.alert('Erro');</script>";
                        }
                    }
                    $updateMen = "INSERT INTO `mensagens`(`men_texto`, `men_visualizado`, `usu_codigo`) VALUES ('Seu pedido esta a caminho!Obrigado',0," . $a['usu_codigo'] . ")";
                    if($this->execute($updateMen)){
                        header("Location: cozinha.php");
                    }
                }else{
                    header("Location: cozinha.php");
                }
            }
        }
    }

}

if (isset($_GET['showItens'])) {
    $id = $_GET['showItens'];
    $pedido = new cozinha();
    $pedido->showItens($id);
}
